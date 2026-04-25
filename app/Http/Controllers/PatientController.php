<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function dashboard()
    {
        $totalPatients  = Patient::count();
        $recentPatients = Patient::orderBy('created_at', 'desc')->take(5)->get();
        return view('dashboard', compact('totalPatients', 'recentPatients'));
    }

    public function index(Request $request)
    {
        $query = Patient::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('reference_dr_name', 'like', "%$search%");
            });
        }
        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->input('date'));
        }

        $testTypes = \App\Models\TestType::all();
        $doctors   = \App\Models\Doctor::all();
        $patients  = $query->with(['latestBooking'])->orderBy('created_at', 'desc')->paginate(10);

        // Summary totals for filtered set
        $summaryQuery    = clone $query;
        $allPatientsIds  = $summaryQuery->pluck('id');
        $latestBookings  = \App\Models\Booking::whereIn('patient_id', $allPatientsIds)
            ->whereIn('id', function ($q) {
                $q->selectRaw('max(id)')->from('bookings')->groupBy('patient_id');
            })->get();

        $summary = [
            'total_bill'     => $latestBookings->sum('total_amount'),
            'total_discount' => $latestBookings->sum('discount'),
            'total_advance'  => $latestBookings->sum('advance_amount'),
            'total_balance'  => $latestBookings->sum('balance_amount'),
        ];

        return view('patients.index', compact('patients', 'testTypes', 'summary', 'doctors'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'age'               => 'required|integer|min:0',
            'gender'            => 'required|in:Male,Female,Other',
            'phone'             => 'required|string|max:20',
            'address'           => 'required|string',
            'reference_dr_name' => 'nullable|string|max:255',
            'visit_date'        => 'required|date',
            'notes'             => 'nullable|string',
            'tests'             => 'required|array',
            'total_amount'      => 'required|numeric',
            'discount'          => 'nullable|numeric',
            'advance_amount'    => 'nullable|numeric',
            'balance_amount'    => 'nullable|numeric',
            'reporting_date'    => 'nullable|date',
            'photo'             => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('patients/photos', 'public');
        }

        $patient = Patient::create([
            'name'              => $request->name,
            'age'               => $request->age,
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'address'           => $request->address,
            'reference_dr_name' => $request->reference_dr_name,
            'visit_date'        => $request->visit_date,
            'notes'             => $request->notes,
            'lab_id'            => \App\Models\Lab::first()?->id ?? 1,
            'photo'             => $photoPath,
        ]);

        $latestBooking = \App\Models\Booking::latest('id')->first();
        $nextId        = $latestBooking ? $latestBooking->id + 1 : 1;
        $billNo        = 'BILL-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        \App\Models\Booking::create([
            'patient_id'     => $patient->id,
            'lab_id'         => $patient->lab_id,
            'booking_id'     => 'BK-' . strtoupper(uniqid()),
            'bill_no'        => $billNo,
            'tests'          => $request->tests,
            'booking_date'   => $request->visit_date,
            'amount'         => $request->total_amount,
            'total_amount'   => $request->total_amount,
            'discount'       => $request->discount ?? 0,
            'advance_amount' => $request->advance_amount ?? 0,
            'balance_amount' => $request->balance_amount ?? 0,
            'reporting_date' => $request->reporting_date,
            'status'         => 'Pending',
        ]);

        return redirect()->route('admin.patients.index')->with('success', 'Patient registered successfully.');
    }

    public function edit(Patient $patient)
    {
        $testTypes = \App\Models\TestType::all();
        return view('patients.index', compact('patient', 'testTypes'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'age'               => 'required|integer|min:0',
            'gender'            => 'required|in:Male,Female,Other',
            'phone'             => 'required|string|max:20',
            'address'           => 'required|string',
            'reference_dr_name' => 'nullable|string|max:255',
            'visit_date'        => 'required|date',
            'notes'             => 'nullable|string',
            'tests'             => 'required|array',
            'total_amount'      => 'required|numeric',
            'discount'          => 'nullable|numeric',
            'advance_amount'    => 'nullable|numeric',
            'balance_amount'    => 'nullable|numeric',
            'reporting_date'    => 'nullable|date',
            'photo'             => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'              => $request->name,
            'age'               => $request->age,
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'address'           => $request->address,
            'reference_dr_name' => $request->reference_dr_name,
            'visit_date'        => $request->visit_date,
            'notes'             => $request->notes,
        ];

        if ($request->hasFile('photo')) {
            if ($patient->photo) {
                Storage::disk('public')->delete($patient->photo);
            }
            $data['photo'] = $request->file('photo')->store('patients/photos', 'public');
        }

        $patient->update($data);

        $booking = $patient->latestBooking;
        if (!$booking) {
            $latestBooking = \App\Models\Booking::latest('id')->first();
            $nextId        = $latestBooking ? $latestBooking->id + 1 : 1;
            $booking       = \App\Models\Booking::create([
                'patient_id'   => $patient->id,
                'lab_id'       => $patient->lab_id ?? (\App\Models\Lab::first()?->id ?? 1),
                'booking_id'   => 'BK-' . strtoupper(uniqid()),
                'bill_no'      => 'BILL-' . str_pad($nextId, 5, '0', STR_PAD_LEFT),
                'booking_date' => $request->visit_date,
                'status'       => 'Pending',
            ]);
        }

        $booking->update([
            'tests'          => $request->tests,
            'booking_date'   => $request->visit_date,
            'amount'         => $request->total_amount,
            'total_amount'   => $request->total_amount,
            'discount'       => $request->discount ?? 0,
            'advance_amount' => $request->advance_amount ?? 0,
            'balance_amount' => $request->balance_amount ?? 0,
            'reporting_date' => $request->reporting_date,
        ]);

        return redirect()->route('admin.patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        if ($patient->photo) {
            Storage::disk('public')->delete($patient->photo);
        }
        $patient->delete();
        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully.');
    }

    public function show(Patient $patient)
    {
        $testTypes = \App\Models\TestType::all()->keyBy('id');
        $patient->load('latestBooking');
        return view('patients.show', compact('patient', 'testTypes'));
    }

    public function printInvoice($id)
    {
        $patient   = Patient::with('bookings')->findOrFail($id);
        $booking   = $patient->latestBooking;
        $testTypes = \App\Models\TestType::all()->keyBy('id');
        return view('patients.invoice', compact('patient', 'booking', 'testTypes'));
    }
}
