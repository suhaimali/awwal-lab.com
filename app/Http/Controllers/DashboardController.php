<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lab;
use App\Models\Equipment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalLabs = Lab::count();
        $totalEquipment = Equipment::count();
        $totalUsers = User::count();

        switch ($user->role) {
            case 'admin':
                return view('dashboards.admin', compact('totalLabs', 'totalEquipment', 'totalUsers'));
            case 'staff':
                return view('dashboards.staff', compact('totalLabs', 'totalEquipment'));
            default:
                return redirect('/');
        }
    }
}
