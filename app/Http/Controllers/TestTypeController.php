<?php
namespace App\Http\Controllers;

use App\Models\TestType;
use Illuminate\Http\Request;

class TestTypeController extends Controller
{
    public function index()
    {
        $testTypes = TestType::all();
        $categories = \App\Models\TestCategory::all();
        $allParameters = \App\Models\TestParameter::all();
        return view('test-types.index', compact('testTypes', 'categories', 'allParameters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'test_code' => 'required|string|max:255|unique:test_types,test_code',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'parameters' => 'nullable|array',
            'status' => 'required|in:Active,Inactive',
            'custom_field' => 'nullable|string|max:255',
        ]);
        
        TestType::create($validated);
        
        return back()->with('success', 'Test type added!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'test_code' => 'required|string|max:255|unique:test_types,test_code,' . $id,
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'parameters' => 'nullable|array',
            'status' => 'required|in:Active,Inactive',
            'custom_field' => 'nullable|string|max:255',
        ]);
        
        $type = TestType::findOrFail($id);
        $type->update($validated);
        
        return back()->with('success', 'Test type updated!');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="test_types_template.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['test_code', 'name', 'category', 'price', 'status', 'custom_field']);
            fputcsv($file, ['CBC01', 'Complete Blood Count', 'Hematology', '500', 'Active', 'Standard Panel']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:csv,txt']);
        
        $file = $request->file('file');
        $data = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_shift($data);
        
        foreach ($data as $row) {
            if (count($row) < 4) continue;
            $csv = array_combine($header, $row);
            
            TestType::updateOrCreate(
                ['test_code' => $csv['test_code']],
                [
                    'name' => $csv['name'],
                    'category' => $csv['category'],
                    'price' => $csv['price'],
                    'status' => $csv['status'] ?? 'Active',
                    'custom_field' => $csv['custom_field'] ?? null,
                ]
            );
        }
        
        return back()->with('success', 'Test types imported successfully!');
    }

    public function destroy($id)
    {
        $type = TestType::findOrFail($id);
        $type->delete();
        return back()->with('success', 'Test type deleted!');
    }
}
