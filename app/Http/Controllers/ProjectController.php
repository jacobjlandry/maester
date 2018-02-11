<?php

namespace App\Http\Controllers;

use App\Project;
use App\ProjectComment;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all()
            ->filter(function($project) {
                return Auth::user()->can('view', $project);
            });

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
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'type' => 'required',
        ]);

        $project = Project::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'icon' => $request->input('icon') ?: 'globe',
            'readme' => $request->input('readme'),
            'source_code_url' => $request->input('source_code_url'),
            'production_url' => $request->input('production_url'),
            'test_url' => $request->input('test_url'),
            'dev_url' => $request->input('dev_url'),
            'created_by' => Auth::user()->id
        ]);

        // store relationship for project owner
        $project->users()->attach(Auth::user());

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
        if(Auth::user()->can('view', $project)) {
            return view('project.show')
                ->with('project', $project);
        }
        else {
            abort(403, 'You are not authorized to view ' . $project->name);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        if (Auth::user()->can('update', $project)) {
            return view('project.edit')
                ->with('project', $project);
        }
        else {
            abort(403, 'You are not authorized to edit ' . $project->name);
        }
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
        if (Auth::user()->can('update', $project)) {
            $request->validate([
                'name' => 'required|max:255',
                'description' => 'required|max:255',
                'type' => 'required'
            ]);

            $project->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'type' => $request->input('type'),
                'icon' => $request->input('icon') ?: 'globe',
                'readme' => $request->input('readme'),
                'source_code_url' => $request->input('source_code_url'),
                'production_url' => $request->input('production_url'),
                'test_url' => $request->input('test_url'),
                'dev_url' => $request->input('dev_url'),
                'created_by' => Auth::user()->id
            ]);

            return json_encode(['success' => true]);
        }
        else {
            abort(403, 'You are not authorized to edit ' . $project->name);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if(Auth::user()->can('destroy', $project)) {
            $project->comments()->delete();
            $project->tasks()->delete();
            $project->releases()->delete();
            $project->delete();
        }
        else {
            abort(403, 'You are not authorized to delete ' . $project->name);
        }
    }

    /**
     * Save a comment for this project
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function comment(Request $request)
    {
        if(Auth::user()->can('update', Project::find($request->input('object_id')))) {
            $request->validate([
                'comment' => 'required|max:255',
                'object_id' => 'required'
            ]);

            ProjectComment::create([
                'user_id' => Auth::user()->id,
                'project_id' => $request->input('object_id'),
                'comment' => $request->input('comment'),
                'parent_id' => $request->has('parent') ? $request->input('parent') : null
            ]);

            return redirect(route('project.show', ['id' => $request->input('object_id')]));
        }
        else {
            abort(403, 'You are not allowed to comment on this project');
        }
    }

    /*
     * Display readme file (markup)
     */
    public function readme(Project $project)
    {
        return view('project.readme')
            ->with('project', $project);
    }
}
