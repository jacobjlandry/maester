<?php

namespace App\Http\Controllers;

use App\Project;
use App\ProjectComment;
use Illuminate\Http\Request;
use Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return view('project.list')
            ->with('projects', $projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::loginUsingId(1);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'type' => 'required|max:30'
        ]);

        Project::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'fontawesome' => $request->input('fontawesome') ?: 'globe',
            'created_by' => Auth::user()->id
        ]);

        return redirect('/project');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('project.show')
            ->with('project', $project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('project.edit')
            ->with('project', $project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        Auth::loginUsingId(1);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'type' => 'required|max:30'
        ]);

        $project->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'fontawesome' => $request->input('fontawesome') ?: 'globe',
            'created_by' => Auth::user()->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->comments()->delete();
        $project->tasks()->delete();
        $project->releases()->delete();
        $project->delete();
    }

    /**
     * Save a comment for this project
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function comment(Request $request)
    {
        Auth::loginUsingId(1);

        $request->validate([
            'comment' => 'required|max:255',
            'project_id' => 'required'
        ]);

        ProjectComment::create([
            'user_id' => Auth::user()->id,
            'project_id' => $request->input('project_id'),
            'comment' => $request->input('comment'),
            'parent_id' => $request->has('parent') ? $request->input('parent') : null
        ]);

        return redirect(route('project.show', ['id' => $request->input('project_id')]));
    }
}
