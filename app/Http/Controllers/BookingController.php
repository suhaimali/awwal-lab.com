<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create()
    {
        $labs = Lab::all();
        return view('bookings.create', compact('labs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lab_id' => 'required|exists:labs,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'lab_id' => $request->lab_id,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return redirect()->route('student.labs.index')->with('success', 'Lab booked successfully.');
    }
}
