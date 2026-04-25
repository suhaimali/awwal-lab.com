<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lab;
use App\Models\Equipment;
use App\Models\User;
use App\Models\Patient;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalLabs = Lab::count();
        $totalEquipment = Equipment::count();
        $totalUsers = User::count();

        // Add total patients and reports
        $totalPatients = Patient::count();
        $totalReports = \App\Models\Report::count();
        $tasks = \App\Models\Task::orderBy('created_at', 'desc')->take(5)->get();
        
        $recentPatients = Patient::orderBy('created_at', 'desc')->take(5)->get()->map(function($item) {
            return (object)[
                'type' => 'patient',
                'title' => 'New Patient Registered: ' . $item->name,
                'time' => $item->created_at,
                'icon' => 'fa-solid fa-user-plus',
                'icon_color' => '#2563eb',
                'icon_bg' => '#eff6ff'
            ];
        });

        $recentPayments = \App\Models\Payment::orderBy('created_at', 'desc')->take(5)->get()->map(function($item) {
            return (object)[
                'type' => 'payment',
                'title' => 'Payment Received: ₹' . number_format($item->amount, 2),
                'time' => $item->created_at,
                'icon' => 'fa-solid fa-money-bill-transfer',
                'icon_color' => '#10b981',
                'icon_bg' => '#d1fae5'
            ];
        });

        // Calculate Metrics for Admin
        $performanceScore = 'A+';
        $systemIncome = \App\Models\Booking::sum('advance_amount');
        $testsCompleted = \App\Models\Report::where('status', 'Completed')->count();

        $activities = $recentPatients->concat($recentPayments)->sortByDesc('time')->take(5)->map(function($a) {
            $a->time_ago = $a->time->diffForHumans();
            return $a;
        });

        if (request()->has('api')) {
            return response()->json([
                'activities' => $activities->values()
            ]);
        }

        $pendingReports = \App\Models\Report::where('status', 'Pending')->count();
        $completedReportsToday = \App\Models\Report::where('status', 'Completed')->whereDate('updated_at', date('Y-m-d'))->count();
        $todayBookings = \App\Models\Booking::whereDate('booking_date', date('Y-m-d'))->count();

        if ($user->role === 'admin') {
            return view('dashboards.admin', compact('totalLabs', 'totalEquipment', 'totalUsers', 'totalPatients', 'totalReports', 'activities', 'tasks', 'performanceScore', 'systemIncome', 'testsCompleted'));
        } elseif ($user->role === 'staff') {
            $sessionCollection = \App\Models\Booking::whereDate('created_at', today())->sum('advance_amount');
            return view('dashboards.staff', compact('pendingReports', 'completedReportsToday', 'todayBookings', 'activities', 'tasks', 'sessionCollection'));
        }
        
        return redirect('/');
    }
}
