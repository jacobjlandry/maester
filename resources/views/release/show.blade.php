@extends('welcome')

@section('content')
    <div class="ui container raised segment" style="display: flex; flex-direction: column;">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <h3>View Release - {{ $release->version }}</h3>
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