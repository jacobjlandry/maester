@extends('welcome')

@section('content')
    <div class="ui container" style="display: flex; justify-content: space-between;">
        <div></div>
        <a href="/task/{{ $task->id }}/edit" class="ui green button">Edit Task</a>
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

                    <h4>@if($task->type == 'bug') Steps to Reproduce @else Details @endif</h4>
                    {{ $task->detail }}

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

                    <h4>Actions</h4>
                    @if($task->status == 'new' || $task->status == 'paused')
                        <button class="ui blue button update-status" status="in progress">Start Work</button>
                    @else
                        <button class="ui blue button update-status" status="paused">Stop Work</button>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
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
        });
    </script>
@endpush