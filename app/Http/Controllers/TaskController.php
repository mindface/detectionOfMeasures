<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * get task list
     */
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->get();

        return response()->json([
            'message' => 'Tasks retrieved successfully',
            'tasks' => $tasks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'detail' => 'required|string',
        // ]);

        $task = Task::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'detail' => $request->detail,
            'status' => 'run',
        ]);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json([
            'message' => 'Task retrieved successfully',
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::where('id', $id)->where('user_id', auth()->id())->first();
        Log::info('-------', ['user_id' => auth()->id()]);
        Log::info('Request data:', $request->all()); 
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // $request->validate([
        //     'title' => 'sometimes|string|max:255',
        //     'detail' => 'sometimes|string',
        //     'status' => 'sometimes|string|in:pending,completed,canceled',
        // ]);

        $task->update($request->only('title', 'detail', 'status'));

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
