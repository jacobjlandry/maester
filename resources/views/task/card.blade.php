<div class="ui card task-card">
    <div class="image">
        <div class="icon">
            <i class="fa fa-@if($task->type == 'bug')bug @elseif($task->type == 'feature')list @endif fa-4x"></i>
            <a class="header" href="/task/{{ $task->id }}">{{ $task->title }}</a>
        </div>
    </div>
    <div class="content">
        <div class="meta">
            <span class="date">Created by {{ $task->user->name }} on {{ $task->created_at->toDateString() }}</span>
        </div>
        <div class="description">
            {{ $task->description }}
        </div>
    </div>
    <div class="extra">
        <div class="comments">
            <a class='ui' href="#comments">
                <i class="fa fa-comments"></i> {{ $task->comments->count() }}
            </a>
        </div>
        <div>
            <a href="/project/{{ $task->project->id }}">
                <i class="fa fa-{{ $task->project->icon }}"></i> &nbsp; {{ $task->project->name }}
            </a>
        </div>
        <div class="users">
            <a class='ui' href="#">
                <i class="fa fa-user"></i> 0
            </a>
        </div>
    </div>
</div>