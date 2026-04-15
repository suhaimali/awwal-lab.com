<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully!');
    }

    public function index(Request $request)
    {
        $query = Booking::with('patient');

        // Filtering
        if ($request->filled('search')) {
            $query->whereHas('patient', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('from')) {
            $query->whereDate('booking_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('booking_date', '<=', $request->to);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderByDesc('id')->paginate(10)->withQueryString();

        // Summary cards
        $totalBookings = Booking::count();
        $confirmed = Booking::where('status', 'Confirmed')->count();
        $pending = Booking::where('status', 'Pending')->count();
        $cancelled = Booking::where('status', 'Cancelled')->count();
        $totalRevenue = Booking::sum('amount');

        $patients = \App\Models\Patient::orderBy('name')->get();
        $testTypes = \App\Models\TestType::all();

        return view('bookings.booking', compact('bookings', 'totalBookings', 'confirmed', 'pending', 'cancelled', 'totalRevenue', 'patients', 'testTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'test_type' => 'required|string',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'amount' => 'required|numeric|min:0',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);
        $validated['total_amount'] = $request->input('amount');
        $validated['discount'] = $request->input('discount', 0);
        $validated['final_payable'] = $validated['total_amount'] - $validated['discount'];
        // Get patient name and phone
        $patient = \App\Models\Patient::find($validated['patient_id']);
        $validated['name'] = $patient ? $patient->name : null;
        $validated['phone'] = $patient ? $patient->phone : null;
        $validated['status'] = $request->input('status', 'Pending');
        // Save booking
        $booking = \App\Models\Booking::create($validated);

        // Save payment details
        \App\Models\Payment::create([
            'patient_id' => $validated['patient_id'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'] ?? 'Cash',
            'payment_status' => 'Paid',
            'payment_date' => now(),
            'total' => $validated['final_payable'], // Include total field
            'payable' => $validated['final_payable'], // Include payable field
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking and payment saved successfully!');
    }
    public function edit(Booking $booking)
    {
        $patients = \App\Models\Patient::orderBy('name')->get();
        $testTypes = \App\Models\TestType::all();
        return view('bookings.edit_booking', compact('booking', 'patients', 'testTypes'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'test_type' => 'required|string',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'amount' => 'required|numeric|min:0',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);
        $patient = \App\Models\Patient::find($validated['patient_id']);
        $validated['name'] = $patient ? $patient->name : null;
        $validated['phone'] = $patient ? $patient->phone : null;
        $validated['status'] = $request->input('status', $booking->status ?? 'Pending');
        $validated['discount'] = $request->input('discount', 0);
        $validated['total_amount'] = $request->input('amount');
        $validated['final_payable'] = $validated['total_amount'] - $validated['discount'];

        $booking->update($validated);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully!');
    }
}
