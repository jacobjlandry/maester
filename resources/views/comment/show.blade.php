<div class="comment">
    <a class="avatar" style="text-align: center;">
        @if($comment->user->avatar)
            <img src="{{ $comment->user->avatar }}">
        @else
            <i class="fa fa-user fa-2x" style="color: #636b6f;"></i>
        @endif
    </a>
    <div class="content">
        <a class="author">{{ $comment->user->name }}</a>
        <div class="metadata">
            <span class="date">{{ $comment->created_at }}</span>
        </div>
        <div class="text">
            {{ $comment->comment }}
        </div>
        <div class="actions">
            <a class="reply reply-link">Reply</a>
            <form action="{{ route('project.comment') }}" method="POST" class="ui reply form comment-reply" style="display: none;">
                {{ csrf_field() }}
                <input type="hidden" name="project_id" value="{{ $project->id }}" />
                <input type="hidden" name="parent" value="{{ $comment->id }}" />
                <div class="field">
                    <textarea name="comment"></textarea>
                </div>
                <button type="submit" class="ui blue labeled submit icon button">
                    <i class="icon edit"></i> Add Reply
                </button>
            </form>
        </div>
    </div>
    @if($comment->comments()->count())
        <div class="comments">
            @foreach($comment->comments() as $subComment)
                @component('comment.show', ['comment' => $subComment, 'project' => $project])@endcomponent
            @endforeach
        </div>
    @endif
</div>