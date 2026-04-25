<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Lab;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::with('lab')->get();
        return view('equipment.index', compact('equipment'));
    }

    public function create()
    {
        $labs = Lab::all();
        return view('equipment.create', compact('labs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lab_id' => 'required|exists:labs,id',
            'status' => 'required|string',
        ]);

        Equipment::create($request->all());

        return redirect()->route('admin.equipment.index')->with('success', 'Equipment created successfully.');
    }

    public function show(Equipment $equipment)
    {
        return view('equipment.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        $labs = Lab::all();
        return view('equipment.edit', compact('equipment', 'labs'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lab_id' => 'required|exists:labs,id',
            'status' => 'required|string',
        ]);

        $equipment->update($request->all());

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.equipment.index')->with('success', 'Equipment updated successfully.');
        } else {
            return redirect()->route('admin.equipment.index')->with('success', 'Equipment status updated successfully.');
        }
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('admin.equipment.index')->with('success', 'Equipment deleted successfully.');
    }
}
