<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function dashboard()
    {
        $totalPatients = Patient::count();
        $recentPatients = Patient::orderBy('created_at', 'desc')->take(5)->get();
        return view('dashboard', compact('totalPatients', 'recentPatients'));
    }

    public function index(Request $request)
    {
        $query = Patient::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
        }
        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->input('date'));
        }
        $patients = $query->orderBy('created_at', 'desc')->get();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'visit_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        Patient::create($validated);
        return redirect()->route('patients.index')->with('success', 'Patient added successfully.');
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'visit_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        $patient->update($validated);
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }
}
