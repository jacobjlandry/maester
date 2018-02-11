<?php

namespace App\Http\Controllers;

use App\Project;
use App\Release;
use App\Task;
use Illuminate\Http\Request;
use Auth;

class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Auth::user()->can('update', Project::find($request->input('project')))) {
            return view('release.create')
                ->with('project', Project::find($request->input('project')));
        }
        else {
            abort(403, 'You are not allowed to create releases for this project');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('update', Project::find($request->input('project_id')))) {
            $request->validate([
                'version' => 'required',
                'project_id' => 'required|int',
                'tasks' => 'required'
            ]);

            $release = Release::create([
                'version' => $request->input('version'),
                'project_id' => $request->input('project_id'),
                'created_by' => Auth::user()->id
            ]);

            Task::whereIn('id', $request->input('tasks'))
                ->get()
                ->each(function ($task) use ($release) {
                    $task->release()->associate($release->id);
                    $task->save();
                });

            return redirect('/project/' . $request->input('project_id'));
        }
        else {
            abort(403, 'You are not allowed to create releases for this project');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Release  $release
     * @return \Illuminate\Http\Response
     */
    public function show(Release $release)
    {
        return view('release.show')
            ->with('release', $release);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Release  $release
     * @return \Illuminate\Http\Response
     */
    public function edit(Release $release)
    {
        return view ('release.edit')
            ->with('release', $release);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Release  $release
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Release $release)
    {
        $request->validate([
            'version' => 'required',
            'tasks' => 'required'
        ]);

        $release->update([
            'version' => $request->input('version')
        ]);

        Task::where('release_id', $release->id)
            ->update([
                'release_id' => null
            ]);

        Task::whereIn('id', $request->input('tasks'))
            ->get()
            ->each(function ($task) use ($release) {
                $task->release()->associate($release->id);
                $task->save();
            });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Release  $release
     * @return \Illuminate\Http\Response
     */
    public function destroy(Release $release)
    {
        Task::where('release_id', $release->id)
            ->update([
                'release_id' => null
            ]);

        $release->delete();
    }
}
