@extends('welcome')

@section('content')
    <div class="ui container" style="display: flex; justify-content: space-between;">
        <div></div>
        @if(Auth::user()->can('update', $task))
            <a href="/task/{{ $task->id }}/edit" class="ui green button">Edit Task</a>
        @endif
    </div>
    <div class="ui container raised segment">
        <div style="display: flex; flex-direction: column; width: 100%;">
            <div style="display: flex; flex-direction: row; justify-content: space-between; padding-bottom: 15px;">
                <div>
                    @component('task.card', ['task' => $task]) @endcomponent
                </div>
                <div style="display: flex; flex-direction: column; width: 100%; padding-left: 15px;">
                    <h4>Status</h4>
                    {{ ucwords($task->status) }}

                    <h4>Priority</h4>
                    {{ ucwords($task->priority) }}

                    <h4>@if($task->type == 'bug') Steps to Reproduce @else Details @endif</h4>
                    {!! preg_replace("/\r\n/", "<br />", $task->detail) !!}

                    @if($task->files->count())
                        <h4>Files</h4>
                        <div class="ui vertical pointing menu" style="width: 100%;">
                            @foreach($task->files as $file)
                                <a class="item file" modal="{{ $file->id }}" style="display: flex; flex-direction: row; align-content: center; align-items: center;">
                                    <i class="fa fa-{{ $file->icon() }}"></i> &nbsp;&nbsp; {{ $file->name }}.{{ $file->extension }}
                                </a>
                                @component('file.modal', ['file' => $file])@endcomponent
                            @endforeach
                        </div>
                    @endif

                    @if(Auth::user()->id == $task->owner->id)
                        <h4>Actions</h4>
                        @if($task->status == 'new' || $task->status == 'paused')
                            <button class="ui blue button update-status" status="in progress">Start Work</button>
                        @elseif($task->status == "in progress")
                            <button class="ui blue button update-status" status="paused">Stop Work</button>
                        @endif

                        <br />

                        <div class="ui buttons">
                            <button class="ui button negative reject">Reject</button>
                            <button class="ui button positive complete">Complete</button>
                        </div>
                    @endif

                    @if($task->notes->count())
                        <h4>History</h4>
                        <div class="ui vertical pointing menu" style="width: 100%;">
                            @foreach($task->notes as $note)
                                <div class="item" style="display: flex; flex-direction: row; align-content: center; align-items: center;">
                                    {{ \App\User::find($note->user_id)->name }}: {{ $note->note }} @ {{ $note->created_at->toDateTimeString() }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div>
                <h4 id="comments">Comments</h4>
                <div class="ui threaded comments">
                    @foreach($task->comments->where('parent_id', null) as $comment)
                        @component('comment.show', ['comment' => $comment, 'object' => $task, 'action' => route('task.comment')])@endcomponent
                    @endforeach
                    @if(Auth::user()->can('update', $task))
                        <form action="{{ route('task.comment') }}" method="POST" class="ui reply form">
                            {{ csrf_field() }}
                            <input type="hidden" name="object_id" value="{{ $task->id }}" />
                            <div class="field">
                                <textarea name="comment"></textarea>
                            </div>
                            <button type="submit" class="ui blue labeled submit icon button">
                                <i class="icon edit"></i> Add Comment
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    $('.reply-link').on('click', function(e) {
        $('.comment-reply').hide();
        $(e.currentTarget).siblings().show();
    });

    /** show file modal **/
    $('.file').on('click', function(e) {
        var modalId = $(e.currentTarget).attr('modal');
        $('#fileModal' + modalId).modal('show');
    });

    $('.update-status').on('click', function(e) {
        var status = $(e.currentTarget).attr('status');

        $.ajax({
            url: '{{ route('task.status', ['id' => $task->id ]) }}',
            data: { 'status': status, 'user_id': {{ Auth::user()->id }}, '_token': '{{ csrf_token() }}' },
            method: 'PATCH',
            success: function() {
                location.reload();
            },
            error: function() {
                alert("Could not update!");
            }
        });
    });

    $('.reject').on('click', function(e) {
        $.ajax({
            url: '{{ route('task.status', ['id' => $task->id ]) }}',
            data: { 'status': 'rejected', 'user_id': {{ Auth::user()->id }}, '_token': '{{ csrf_token() }}' },
            method: 'PATCH',
            success: function() {
                window.location = '{{ route('project.show', ['id' => $task->project->id ]) }}';
            },
            error: function() {
                alert("Could not update!");
            }
        });
    });

    $('.complete').on('click', function(e) {
        $.ajax({
            url: '{{ route('task.status', ['id' => $task->id ]) }}',
            data: { 'status': 'complete', 'user_id': {{ Auth::user()->id }}, '_token': '{{ csrf_token() }}' },
            method: 'PATCH',
            success: function() {
                window.location = '{{ route('project.show', ['id' => $task->project->id ]) }}';
            },
            error: function() {
                alert("Could not update!");
            }
        });
    });
@endpush