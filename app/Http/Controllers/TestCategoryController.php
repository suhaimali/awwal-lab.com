<?php
namespace App\Http\Controllers;

use App\Models\TestCategory;
use Illuminate\Http\Request;

class TestCategoryController extends Controller
{
    public function index()
    {
        $categories = TestCategory::all();
        return view('test_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:test_categories,name',
            'description' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);
        
        TestCategory::create($validated);
        return back()->with('success', 'Category created successfully!');
    }

    public function update(Request $request, TestCategory $testCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:test_categories,name,' . $testCategory->id,
            'description' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);
        
        $testCategory->update($validated);
        return back()->with('success', 'Category updated successfully!');
    }

    public function destroy(TestCategory $testCategory)
    {
        $testCategory->delete();
        return back()->with('success', 'Category deleted successfully!');
    }
}
