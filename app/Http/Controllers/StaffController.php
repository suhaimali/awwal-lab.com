<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Show the staff dashboard.
     */
    public function dashboard()
    {
        return view('dashboards.staff');
    }
}
