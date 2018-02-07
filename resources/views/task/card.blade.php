<div class="ui card task-card">
    <div class="image">
        <div class="icon">
            <i class="fa fa-@if($task->type == 'bug')bug @elseif($task->type == 'feature')list @endif fa-4x"></i>
            <a class="header" href="/task/{{ $task->id }}">{{ $task->title }}</a>
        </div>
    </div>
    <div class="content">
        <div class="meta">
            Current Owner: {{ $task->owner->name }}
        </div>
        <div class="meta">
            <span class="date">Created by {{ $task->creator->name }} on {{ $task->created_at->toDateString() }}</span>
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
        <div id="task-users" class="users">
            <a class='ui' href="#">
                <i class="fa fa-user"></i> 1
            </a>
        </div>
    </div>
</div>

@if(Auth::user()->can('update', $task))
    <div class="ui modal">
        <div class="header">Manage {{ $task->title }}'s Team</div>
        <div class="content">
            <h3>Assign Task</h3>
            <div class="ui list task-creator">
                <div class="item user">
                    <div class="avatar image">
                        <span class="fa-stack fa-sm">
                          <i class="fa fa-circle-o fa-stack-2x"></i>
                          <i class="fa fa-user fa-stack-1x"></i>
                        </span>
                    </div>
                    <div class="content">
                        <a class="header">{{ $task->owner->name }}</a>
                        <div class="description">{{ $task->owner->email }} (owner) @if($task->creator->id == $task->owner->id)(creator)@endif</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <h3>Available Users</h3>
            <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
                @foreach($task->project->users as $user)
                    @if($user->id != $task->owner->id)
                        <div class="ui list">
                            <div class="task-list-item item user" user_id="{{ $user->id }}" project_id="{{ $task->id }}">
                                <div class="avatar image">
                                <span class="fa-stack fa-sm">
                                  <i class="fa fa-circle-o fa-stack-2x"></i>
                                  <i class="fa fa-user fa-stack-1x"></i>
                                </span>
                                </div>
                                <div class="content">
                                    <a class="header">{{ $user->name }}</a>
                                    <div class="description">{{ $user->email }} @if($task->creator->id == $user->id)(creator)@endif</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button user_id="{{ $user->id }}" class="ui primary button assign">Assign</button>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="actions">
            <div class="left">
                <div class="ui cancel button">Close</div>
            </div>
            <div class="right">

            </div>
        </div>
    </div>
@endif

@push('scripts')
    @if(Auth::user()->can('update', $task))
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $('#task-users').on('click', function() {
            $('.ui.modal').modal('show');
        });

        $('.assign').on('click', function(e) {
            // reset styles
            $('.assign').text('Assign');
            $('.assign').removeClass('positive');
            $('.assign').addClass('primary');

            var userId = $(e.currentTarget).attr('user_id');
            $.post({
                url: '{{ route('task.assign', ['task' => $task->id]) }}',
                data: { 'owner_id': userId, 'user_id': {{ Auth::user()->id }}, '_token': '{{ csrf_token() }}' },
                success: function() {
                    $(e.currentTarget).removeClass('primary');
                    $(e.currentTarget).addClass('positive');
                    $(e.currentTarget).html('<i class="fa fa-check"></i>');
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                }
            });
        });
    @endif
@endpush