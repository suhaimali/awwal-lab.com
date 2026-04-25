<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['patient', 'report']);

        // Filters
        if ($request->filled('bill_no')) {
            $query->where('bill_no', 'like', '%' . $request->bill_no . '%');
        }

        if ($request->filled('patient_name')) {
            $query->whereHas('patient', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->patient_name . '%');
            });
        }

        if ($request->filled('phone')) {
            $query->whereHas('patient', function($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->phone . '%');
            });
        }

        if ($request->filled('doctor')) {
            $query->whereHas('patient', function($q) use ($request) {
                $q->where('reference_dr_name', 'like', '%' . $request->doctor . '%');
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('booking_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('booking_date', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $totalsQuery = clone $query;
        $bookings = $query->orderByDesc('id')->paginate(20);

        // Calculate Totals for the current filtered view
        $totals = [
            'bill_amount' => $totalsQuery->sum('total_amount'),
            'discount' => $totalsQuery->sum('discount'),
            'advance' => $totalsQuery->sum('advance_amount'),
            'balance' => $totalsQuery->sum('balance_amount'),
            'received' => $totalsQuery->sum('advance_amount'), // In this system, advance is what's received initially
        ];

        return view('admin.analysis.index', compact('bookings', 'totals'));
    }

    public function salesSlip(Booking $booking)
    {
        $booking->load(['patient', 'report.reportItems']);
        return view('admin.analysis.sales-slip', compact('booking'));
    }
}
