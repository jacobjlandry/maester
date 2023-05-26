<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request && $request->get('parent')) {
            return Task::where('parent_id', $request->get('parent'))->get();
        } else {
            return Task::whereNull('parent_id')->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $validated = $request->validated();

        return Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'parent_id' => $validated['parent'] ?? null,
        ]);
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
    public function update(TaskRequest $request, Task $task)
    {
        // get the validated input
        $validated = $request->validated();

        $task->title = $validated['title'];
        $task->description = $validated['description'] ??  null;
        $task->parent_id = $validated['parent'] ?? null;
        $task->save();

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
