<?php

namespace App\Http\Controllers;

use App\File;
use App\Project;
use App\Task;
use Illuminate\Http\Request;
use App\TaskComment;
use Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

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
        $projects = Project::all();

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
            'detail' => 'required',
            'project_id' => 'required',
            'created_by' => 'required'
        ]);

        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'detail' => $request->input('detail'),
            'created_by' => $request->input('created_by'),
            'project_id' => $request->input('project_id')
        ]);

        foreach($request->files as $key => $file) {
            $uploadedFile = $request->file($key);

            $fileExtension = $uploadedFile->getClientOriginalExtension();
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
        };

        return redirect(route('task.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('task.show')
            ->with('task', $task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $projects = Project::all();

        return view('task.edit')
            ->with('projects', $projects)
            ->with('task', $task);
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
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'type' => 'required',
            'detail' => 'required',
            'project_id' => 'required',
            'created_by' => 'required'
        ]);

        $task->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'detail' => $request->input('detail'),
            'created_by' => $request->input('created_by'),
            'project_id' => $request->input('project_id')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        // delete files attached to this task
        $task->files->each(function($file) {
            unlink(storage_path('app/' . $file->path));
            $file->delete();
        });

        // delete task
        $task->delete();
    }

    /**
     * Save a comment for this task
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function comment(Request $request)
    {
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
}
