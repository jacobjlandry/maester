<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Task::searchBy($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $task = new Task();

        try {
            $task->validateInput($request);
            $task->save();
        } catch(\Exception $e) {
            $task->error = $e->getMessage();
        }
        
        return $task;
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $task;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        try {
            $task->validateInput($request);
            $task->save();
        } catch(\Exception $e) {
            $task->error = $e->getMessage();
        }

        return $task;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // check for subtasks
        if ($task->hasSubtasks()) {
            abort(409, "Task has subtasks");
        }

        return $task->delete();
    }
}
