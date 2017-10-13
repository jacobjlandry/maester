@extends('welcome')

@section('content')
    <div class="ui container" style="display: flex; justify-content: space-between;">
        <div></div>
        <a href="/task/{{ $task->id }}/edit" class="ui green button">Edit Project</a>
    </div>
    <div class="ui container raised segment">
        <div style="display: flex; flex-direction: column; width: 100%;">
            <div style="display: flex; flex-direction: row; justify-content: space-between; padding-bottom: 15px;">
                <div>
                    @component('task.card', ['task' => $task]) @endcomponent
                </div>
                <div style="display: flex; flex-direction: column; width: 100%; padding-left: 15px;">
                    {{ $task->detail }}

                    <h4>Files</h4>
                    <div class="ui vertical pointing menu" style="width: 100%;">
                        @foreach($task->files as $file)
                            <a class="item" style="display: flex; flex-direction: row; align-content: center; align-items: center;">
                                <img class="ui mini image" src="{{ $file->path }}"> &nbsp;&nbsp; {{ $file->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div>
                <h4>Comments</h4>
                <div class="ui threaded comments">
                    @foreach($task->comments->where('parent_id', null) as $comment)
                        @component('comment.show', ['comment' => $comment, 'task' => $task])@endcomponent
                    @endforeach
                    <form action="{{ route('project.comment') }}" method="POST" class="ui reply form">
                        {{ csrf_field() }}
                        <input type="hidden" name="task_id" value="{{ $task->id }}" />
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
        });
    </script>
@endpush