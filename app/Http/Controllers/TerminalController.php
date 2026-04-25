<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Patient;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class TerminalController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        $bookings = Booking::where('status', '!=', 'Paid')->get();
        return view('admin.payments.terminal', compact('patients', 'bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string',
            'patient_id_manual' => 'required|string',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'booking_id' => 'nullable|exists:bookings,id'
        ]);

        $patient = Patient::where('id', $validated['patient_id_manual'])->first();
        $booking = $request->booking_id ? Booking::find($request->booking_id) : null;
        
        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'patient_id' => $patient->id,
                'booking_id' => $booking?->id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'Paid',
                'transaction_id' => 'TERM-' . strtoupper(uniqid()),
                'payment_date' => now(),
                'lab_id' => auth()->user()->lab_id ?? 1,
            ]);

            // Sync with Booking if linked
            if ($booking) {
                $newBalance = max(0, $booking->balance_amount - $request->amount);
                $booking->update([
                    'advance_amount' => $booking->advance_amount + $request->amount,
                    'balance_amount' => $newBalance,
                    'status' => $newBalance <= 0 ? 'Confirmed' : $booking->status
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Terminal transaction finalized and ledger updated.',
                'payment_id' => $payment->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Ledger update failed: ' . $e->getMessage()], 500);
        }
    }
}
