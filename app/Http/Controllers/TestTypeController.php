<?php
namespace App\Http\Controllers;

use App\Models\TestType;
use Illuminate\Http\Request;

class TestTypeController extends Controller
{
    public function index()
    {
        $testTypes = TestType::all();
        return view('test-types.index', compact('testTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'custom_field' => 'nullable|string|max:255',
        ]);
        TestType::create([
            'name' => $request->name,
            'custom_field' => $request->custom_field,
        ]);
        return back()->with('success', 'Test type added!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'custom_field' => 'nullable|string|max:255',
        ]);
        $type = TestType::findOrFail($id);
        $type->update([
            'name' => $request->name,
            'custom_field' => $request->custom_field,
        ]);
        return back()->with('success', 'Test type updated!');
    }

    public function destroy($id)
    {
        $type = TestType::findOrFail($id);
        $type->delete();
        return back()->with('success', 'Test type deleted!');
    }
}
