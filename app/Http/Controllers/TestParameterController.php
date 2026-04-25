<?php
namespace App\Http\Controllers;

use App\Models\TestParameter;
use Illuminate\Http\Request;

class TestParameterController extends Controller
{
    public function index()
    {
        $parameters = TestParameter::all();
        return view('test_parameters.index', compact('parameters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:test_parameters,name',
            'unit' => 'nullable|string|max:50',
            'normal_range' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);
        
        TestParameter::create($validated);
        return back()->with('success', 'Parameter created successfully!');
    }

    public function update(Request $request, TestParameter $testParameter)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:test_parameters,name,' . $testParameter->id,
            'unit' => 'nullable|string|max:50',
            'normal_range' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);
        
        $testParameter->update($validated);
        return back()->with('success', 'Parameter updated successfully!');
    }

    public function destroy(TestParameter $testParameter)
    {
        $testParameter->delete();
        return back()->with('success', 'Parameter deleted successfully!');
    }
}
