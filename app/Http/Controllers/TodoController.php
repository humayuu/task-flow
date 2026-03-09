<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Todo::where('user_id', Auth::id())->paginate(5);
        return view('todo.index', compact('tasks'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|max:50',
            'priority' => 'required',
            'due_date' => 'required',
        ]);
        try {

            Todo::create([
                'title' => $request->task,
                'status' => 'pending',
                'priority' => $request->priority,
                'due_date' => $request->due_date,
                'user_id' => Auth::id(),
            ]);

            return redirect()->back()->with('success', 'Task Created Successfully');
        } catch (Exception $e) {
            Log::error('Error in task creation ' . $e->getMessage());

            return redirect()->back()->with('error', 'Task Creation failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        return view('todo.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'task' => 'required|max:50',
            'priority' => 'required',
            'due_date' => 'required',
        ]);
        try {

            $todo->update([
                'title' => $request->task,
                'priority' => $request->priority,
                'due_date' => $request->due_date,
            ]);

            return redirect()->back()->with('success', 'Task Updated Successfully');
        } catch (Exception $e) {
            Log::error('Error in task update ' . $e->getMessage());

            return redirect()->back()->with('error', 'Task Updated failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        try {
            $todo->delete();

            return redirect()->back()->with('success', 'Task Deleted Successfully');
        } catch (Exception $e) {
            Log::error('Error in Task Deletion ' . $e->getMessage());

            return redirect()->back()->with('error', 'Task Deleted Failed');
        }
    }

    /**
     * For Update Task Status
     */
    public function TaskStatus($id)
    {
        $task = Todo::findOrFail($id);

        $task->update(['status' => 'complete']);
        return redirect()->back()->with('success', 'Task Completed');
    }
}
