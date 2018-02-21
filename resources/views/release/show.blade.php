@extends('welcome')

@section('content')
    <div class="ui container raised segment" style="display: flex; flex-direction: column;">
        <div class="ui container" style="display: flex; justify-content: space-between; align-items: center; align-content: center;">
            <a href="/release/{{ $release->id }}/notes" class="ui blue button">View Release Notes</a>
            <h2><a href="/project/{{ $release->project->id }}">{{ $release->project->name }}</a> Release - {{ $release->version }}</h2>
            <div>
                @if(Auth::user()->can('update', $release))
                    <a href="/release/{{ $release->id }}/edit" class="ui green button">Edit Release</a>
                @endif
            </div>
        </div>

        <div class="ui @if($release->completionPercent() != 100) blue active @else green @endif progress" id="progressContainer" data-percent="{{ $release->completionPercent() }}">
            <div class="bar" id="progressBar" style="transition-duration: 300ms; width: {{ $release->completionPercent() }}%; max-width: 100%;">
                <div class="progress" id="progressNumber">{{ $release->completionPercent() }}%</div>
            </div>
        </div>

        <div id="available-tasks" class="ui vertical pointing menu" style="width: 85%;">
            @foreach($release->tasksByPriority() as $task)
                <a href="/task/{{ $task->id }}" class="item" task-id="{{ $task->id }}" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
                    <div><i class="fa fa-{{ $task->fontawesome()  }} {{ $task->type }}"></i> &nbsp; {{ $task->title }}</div>
                    <div>
                        <div class="ui yellow horizontal label">
                            @if($task->priority == 'highest')
                                !!!
                            @elseif($task->priority == "normal")
                                !!
                            @else
                                !
                            @endif
                        </div>
                        <div class="ui {{ $task->statusColor() }} horizontal label">{{ ucwords($task->status) }}</div>
                    </div>
                </a>
            @endforeach
            @if(!$release->tasks->count())
                <a class="item" href="#">
                    No tasks yet, boss. Get those minions to work!
                </a>
            @endif
        </div>
    </div>
@endsection