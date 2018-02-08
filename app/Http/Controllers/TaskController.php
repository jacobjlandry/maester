<?php

namespace App\Http\Controllers;

use App\File;
use App\Project;
use App\Task;
use App\TaskNote;
use Illuminate\Http\Request;
use App\TaskComment;
use Auth;
use Session;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all()
            ->filter(function($task) {
                return Auth::user()->can('view', $task);
            });

        return view('task.list')
            ->with('tasks', $tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all()
            ->filter(function($project) {
                return Auth::user()->can('view', $project);
            });

        return view('task.create')
            ->with('projects', $projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'type' => 'required',
            'priority' => 'required',
            'detail' => 'required',
            'project_id' => 'required',
            'created_by' => 'required'
        ]);

        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'priority' => $request->input('priority'),
            'detail' => $request->input('detail'),
            'created_by' => $request->input('created_by'),
            'owned_by' => $request->input('created_by'),
            'project_id' => $request->input('project_id')
        ]);

        foreach($request->files as $key => $file) {
            $uploadedFile = $request->file($key);

            $fileExtension = $uploadedFile->getClientOriginalExtension();

            if(File::allowed($fileExtension)) {
                $fileName = preg_replace("/\.$fileExtension/", "", $uploadedFile->getClientOriginalName());
                $storedFileName = rand(1,999) . '_' . $uploadedFile->getClientOriginalName();

                $uploadedFile->storeAs('uploads', $storedFileName);

                $file = File::create([
                    'task_id' => $task->id,
                    'name' => $fileName,
                    'extension' => $fileExtension,
                    'size' => $uploadedFile->getClientSize(),
                    'path' => '/uploads/' . $storedFileName,
                    'created_by' => $request->input('created_by')
                ]);
            }
            else {
                Session::flash('error', 'A file was not uploaded due to unsupported type ( ' . $fileExtension . ' )');
            }
        };

        return redirect(route('project.show', ['id' => $request->input('project_id')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task`
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        if(Auth::user()->can('view', $task)) {
            return view('task.show')
                ->with('task', $task);
        }
        else {
            abort(403, 'You are not authorized to view ' . $task->title);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        if (Auth::user()->can('update', $task)) {
            $projects = Project::all()
                ->filter(function($project) {
                    return Auth::user()->can('view', $project);
                });

            return view('task.edit')
                ->with('projects', $projects)
                ->with('task', $task);
        }
        else {
            abort(403, 'You are not authorized to edit ' . $task->title);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        if (Auth::user()->can('update', $task)) {
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required|max:255',
                'type' => 'required',
                'priority' => 'required',
                'estimate' => 'integer',
                'detail' => 'required',
                'project_id' => 'required',
                'modified_by' => 'required'
            ]);

            $task->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'type' => $request->input('type'),
                'priority' => $request->input('priority'),
                'estimate' => $request->input('estimate'),
                'detail' => $request->input('detail'),
                'project_id' => $request->input('project_id'),
                'modified_by' => $request->input('modified_by')
            ]);

            return json_encode(['success' => true]);
        }
        else {
            abort(403, 'You are not authorized to edit ' . $task->title);
        }
    }

    /**
     * Update the status of a ticket and attach the user who updated the status to the ticket
     *
     * @param Request $request
     * @param Task $task
     */
    public function updateStatus(Request $request, Task $task)
    {
        if (Auth::user()->can('update', $task)) {
            $request->validate([
                'status' => 'required',
                'user_id' => 'required'
            ]);

            if (!$task->hasUser($request->input('user_id'))) {
                $task->users()->attach($request->input('user_id'));
            }

            TaskNote::create([
                'task_id' => $task->id,
                'user_id' => $request->input('user_id'),
                'note' => "status changed {$task->status} => {$request->input('status')}"
            ]);

            $task->update([
                'status' => $request->input('status')
            ]);

            switch($request->input('status')) {
                case 'complete':
                case 'rejected':
                    $task->delete();
                    break;
            }
        }
        else {
            abort(403, 'You are not authorized to edit ' . $task->title);
        }
    }

    public function assign(Request $request, Task $task)
    {
        if (Auth::user()->can('update', $task)) {
            $request->validate([
                'owner_id' => 'required'
            ]);

            TaskNote::create([
                'task_id' => $task->id,
                'user_id' => $request->input('user_id'),
                'note' => "owner changed {$task->owner->name} => " . \App\User::find($request->input('owner_id'))->name,
            ]);

            $task->update([
                'owned_by' => $request->input('owner_id')
            ]);
        }
        else {
            abort(403, 'You are not authorized to edit ' . $task->title);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if (Auth::user()->can('delete', $task)) {
            // delete files attached to this task
            $task->files->each(function ($file) {
                unlink(storage_path('app/' . $file->path));
                $file->delete();
            });

            $task->update([
                'status' => 'deleted'
            ]);

            // delete task
            $task->delete();
        }
        else {
            abort(403, 'You are not authorized to edit ' . $task->title);
        }
    }

    /**
     * Save a comment for this task
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function comment(Request $request)
    {
        if (Auth::user()->can('update', Task::find($request->input('object_id')))) {
            $request->validate([
                'comment' => 'required|max:255',
                'object_id' => 'required'
            ]);

            TaskComment::create([
                'user_id' => Auth::user()->id,
                'task_id' => $request->input('object_id'),
                'comment' => $request->input('comment'),
                'parent_id' => $request->has('parent') ? $request->input('parent') : null
            ]);

            return redirect(route('task.show', ['id' => $request->input('object_id')]));
        }
        else {
            abort(403, 'You are not authorized to comment on this task.');
        }
    }

    /**
     * Get this tasks completion percent
     *
     * @param Task $task
     * @return float
     */
    public function progress(Task $task)
    {
        return $task->completionPercent();
    }
}
