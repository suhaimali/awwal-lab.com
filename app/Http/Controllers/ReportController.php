<?php
namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportItem;
use App\Models\Booking;
use App\Models\TestType;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['booking.patient', 'reportItems.testType']);
        
        // Filters
        if ($request->filled('patient')) {
            $query->whereHas('booking.patient', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->patient . '%');
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $reports = $query->orderByDesc('id')->paginate(10);
        
        // All Bookings (Available for Report Creation)
        $pendingBookings = Booking::with('patient')
            ->orderByDesc('id')
            ->get();

        $totalReports = Report::count();
        $completedReports = Report::where('status', 'Completed')->count();
        $pendingReports = Report::where('status', 'Pending')->count();
        $testTypes = TestType::all();

        return view('admin.test-reports', compact('reports', 'pendingBookings', 'totalReports', 'completedReports', 'pendingReports', 'testTypes'));
    }

    public function importResults(Request $request)
    {
        $request->validate([
            'results_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('results_file');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle); // report_id, parameter_name, result_value

        $count = 0;
        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            
            $item = ReportItem::where('report_id', $data['report_id'])
                ->where('parameter_name', $data['parameter_name'])
                ->first();

            if ($item) {
                $item->update(['result_value' => $data['result_value']]);
                // If it's the first result for this report, maybe mark report as completed?
                // Or let the user do it.
                $item->report()->update(['status' => 'Completed']);
                $count++;
            }
        }

        fclose($handle);

        return back()->with('success', "Successfully imported $count test results.");
    }

    public function addParameter(Request $request, Report $report)
    {
        $validated = $request->validate([
            'parameter_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',
            'normal_range' => 'nullable|string|max:255',
            'result_value' => 'nullable|string|max:255',
        ]);

        ReportItem::create([
            'report_id' => $report->id,
            'parameter_name' => $validated['parameter_name'],
            'category' => $validated['category'],
            'unit' => $validated['unit'],
            'normal_range' => $validated['normal_range'],
            'result_value' => $validated['result_value'],
        ]);

        return back()->with('success', 'Parameter added successfully!');
    }

    public function print(Report $report)
    {
        $report->load(['booking.patient', 'reportItems']);
        $lab = \App\Models\Lab::first(); // Get lab details for header
        return view('admin.reports.print', compact('report', 'lab'));
    }

    public function show(Report $report)
    {
        return redirect()->route('admin.reports.edit', $report->id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id|unique:reports,booking_id',
        ]);

        $booking = Booking::with('patient')->findOrFail($validated['booking_id']);
        
        DB::beginTransaction();
        try {
            $report = Report::create([
                'lab_id' => \App\Models\Lab::first()?->id ?? 1,
                'booking_id' => $booking->id,
                'status' => 'Pending',
            ]);

            // Populate report items from the booking's tests
            $testIds = $booking->tests ?: [];
            foreach ($testIds as $testId) {
                // Find the test type by ID
                $testType = TestType::find($testId);
                if ($testType && is_array($testType->parameters)) {
                    foreach ($testType->parameters as $paramName) {
                        // Try to find if this parameter exists in the TestParameter table to get unit/range
                        $paramDetail = \App\Models\TestParameter::where('name', $paramName)->first();
                        
                        ReportItem::create([
                            'report_id' => $report->id,
                            'test_type_id' => $testType->id,
                            'parameter_name' => $paramName,
                            'category' => $paramDetail?->category,
                            'normal_range' => $paramDetail?->normal_range,
                            'unit' => $paramDetail?->unit,
                        ]);
                    }
                }
            }
            
            DB::commit();
            return redirect()->route('admin.reports.edit', $report->id)->with('success', 'Report initialized with ' . $report->reportItems()->count() . ' parameters. Please enter results.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating report: ' . $e->getMessage());
        }
    }

    public function edit(Report $report)
    {
        $report->load(['booking.patient', 'reportItems']);
        $allParameters = \App\Models\TestParameter::all();
        $categories = \App\Models\TestCategory::all();
        $testTypes = TestType::all();
        
        return view('admin.reports.edit', compact('report', 'allParameters', 'categories', 'testTypes'));
    }

    public function update(Request $request, Report $report)
    {
        $items = $request->input('items', []);

        DB::beginTransaction();
        try {
            foreach ($items as $itemId => $data) {
                $reportItem = ReportItem::find($itemId);
                if ($reportItem) {
                    $reportItem->update([
                        'result_value' => $data['value'],
                        'remarks' => $data['remarks'] ?? null,
                    ]);
                }
            }

            $report->update(['status' => 'Completed']);
            
            DB::commit();
            return redirect()->route('admin.test-reports')->with('success', 'Report updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating report: ' . $e->getMessage());
        }
    }

    public function dispatch(Request $request)
    {
        $query = Report::with(['booking.patient', 'reportItems'])
            ->where('status', 'Completed');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('booking.patient', function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }

        $reports = $query->orderByDesc('updated_at')->paginate(15);
        return view('admin.reports.dispatch', compact('reports'));
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return back()->with('success', 'Report deleted successfully.');
    }

    public function deleteParameter($id)
    {
        $item = \App\Models\ReportItem::findOrFail($id);
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Parameter deleted successfully.',
        ]);
    }
}
