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
        $taskQuery = Task::where('user_id', 1);

        // parent
        if ($request && $request->get('parent')) {
            $taskQuery->where('parent_id', $request->get('parent'))->get();
        } else {
            $taskQuery->whereNull('parent_id')->get();
        }

        // due dates
        $taskQuery->where(function($query) {
            $query->whereNull('due_datetime')
                ->orWhereNull('hidden_until_due')
                ->orWhere(function($query) {
                    $query->where('due_datetime', '<=', Date('Y-m-d 23:59:59'))
                        ->orWhere('hidden_until_due', false);
                });
        });

        return $taskQuery->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        // store validated task
        return Task::create($request->validated());
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
        // use the validated input to update the task
        $task->update($request->validated());

        // return the new task
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
