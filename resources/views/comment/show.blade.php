<div class="comment">
    <a class="avatar">
        <img src="/images/avatar/small/matt.jpg">
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
            <a class="reply">Reply</a>
        </div>
    </div>
    @if($comment->comments()->count())
        <div class="comments">
            @foreach($comment->comments() as $subComment)
                @component('comment.show', ['comment' => $subComment])@endcomponent
            @endforeach
        </div>
    @endif
</div>