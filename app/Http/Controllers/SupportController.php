<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        return view('support.index');
    }

    public function submitTicket(Request $request)
    {
        // For now, we'll just redirect back with success as this is a UI implementation
        return back()->with('success', 'Your support request has been broadcast to Suhaim Soft engineers.');
    }
}
