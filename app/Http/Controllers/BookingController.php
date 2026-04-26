<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Patient;
use App\Models\TestType;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('patient')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('booking_id', 'like', "%$search%")
                  ->orWhereHas('patient', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
        }

        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->input('date'));
        }
        
        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        $bookings = $query->get();
        $patients = Patient::orderBy('name')->get();
        $testTypes = TestType::where('status', 'Active')->orderBy('name')->get();

        $totalBookings = Booking::count();
        $todayBookings = Booking::whereDate('booking_date', date('Y-m-d'))->count();
        $totalRevenue = Booking::sum('total_amount');
        $pendingBookings = Booking::where('status', 'Pending')->count();

        return view('bookings.index', compact('bookings', 'patients', 'testTypes', 'totalBookings', 'todayBookings', 'totalRevenue', 'pendingBookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'tests' => 'required|array',
            'tests.*' => 'exists:test_types,id',
            'booking_date' => 'required|date',
            'status' => 'required|in:Pending,Confirmed,Cancelled',
            'notes' => 'nullable|string',
        ]);

        // Auto-calculate Total Amount
        $totalAmount = 0;
        if (!empty($validated['tests'])) {
            $totalAmount = TestType::whereIn('id', $validated['tests'])->sum('price');
        }

        // Generate Booking ID
        $latestBooking = Booking::latest('id')->first();
        $nextId = $latestBooking ? $latestBooking->id + 1 : 1;
        $bookingId = 'BKG-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        Booking::create([
            'booking_id' => $bookingId,
            'lab_id' => \App\Models\Lab::first()?->id ?? 1,
            'patient_id' => $validated['patient_id'],
            'tests' => $validated['tests'],
            'booking_date' => $validated['booking_date'],
            'amount' => $totalAmount,
            'total_amount' => $totalAmount,
            'status' => $validated['status'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully.');
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'tests' => 'required|array',
            'tests.*' => 'exists:test_types,id',
            'booking_date' => 'required|date',
            'status' => 'required|in:Pending,Confirmed,Cancelled',
            'notes' => 'nullable|string',
        ]);

        // Auto-calculate Total Amount
        $totalAmount = 0;
        if (!empty($validated['tests'])) {
            $totalAmount = TestType::whereIn('id', $validated['tests'])->sum('price');
        }

        $booking->update([
            'patient_id' => $validated['patient_id'],
            'tests' => $validated['tests'],
            'booking_date' => $validated['booking_date'],
            'total_amount' => $totalAmount,
            'status' => $validated['status'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }
}
