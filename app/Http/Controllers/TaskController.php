<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = \App\Models\Task::with('assignedUser')->orderBy('created_at', 'desc')->get();
        $users = \App\Models\User::all();
        return view('admin.tasks.index', compact('tasks', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Directive,Bug,Maintenance',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,In Progress,Completed,Action Needed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        \App\Models\Task::create($validated);

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = \App\Models\Task::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:Directive,Bug,Maintenance',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:Pending,In Progress,Completed,Action Needed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update($validated);
        
        return redirect()->back()->with('success', 'Task updated successfully!');
    }

    public function destroy($id)
    {
        $task = \App\Models\Task::findOrFail($id);
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully.');
    }

    public function recent()
    {
        $user = auth()->user();
        $query = \App\Models\Task::where('status', '!=', 'Completed');

        // Staff only see tasks assigned to them or unassigned
        if ($user->role !== 'admin') {
            $query->where(function($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhereNull('assigned_to');
            });
        }

        $tasks = $query->orderBy('created_at', 'desc')->take(5)->get();
        return response()->json($tasks);
    }
}
