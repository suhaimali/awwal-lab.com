<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::query();
        if ($request->filled('search')) {
            $query->whereHas('patient', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        $payments = $query->orderBy('created_at', 'desc')->paginate(10);
        $totalPayments = Payment::count();
        $totalRevenue = Payment::where('payment_status', 'Paid')->sum('amount') ?: 0;
        $totalPending = Payment::where('payment_status', 'Pending')->sum('amount') ?: 0;
        $totalCollections = Payment::sum('amount') ?: 0;
        $patientsList = \App\Models\Patient::orderBy('name')->get();
        $bookingsList = \Illuminate\Support\Facades\DB::table('bookings')->orderBy('created_at', 'desc')->get();
        return view('payments.index', compact('payments', 'totalPayments', 'totalRevenue', 'totalPending', 'totalCollections', 'patientsList', 'bookingsList'));
    }

    public function create()
    {
        $patients = \App\Models\Patient::orderBy('name')->get();
        return view('payments.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric',
            'payment_status' => 'required|in:Paid,Pending,Failed',
            'payment_method' => 'required|in:Cash,Bank Transfer,Card',
            'transaction_id' => 'nullable|string|max:255',
            'booking_id' => 'nullable|exists:bookings,id',
        ]);
        Payment::create($validated);
        return redirect()->route('admin.payments.index')->with('success', 'Payment added successfully.');
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $patients = \App\Models\Patient::orderBy('name')->get();
        $appointments = [];
        // If you have an Appointment model, replace the above with:
        // $appointments = \App\Models\Appointment::orderBy('appointment_date', 'desc')->get();
        return view('payments.edit', compact('payment', 'patients', 'appointments'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric',
            'payment_status' => 'required|in:Paid,Pending,Failed',
            'payment_method' => 'required|in:Cash,Bank Transfer,Card',
            'transaction_id' => 'nullable|string|max:255',
            'booking_id' => 'nullable|exists:bookings,id',
        ]);
        $payment->update($validated);
        return redirect()->route('admin.payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully.');
    }
}
