@extends('welcome')

@section('content')
    <div class="ui container" style="display: flex; justify-content: space-between; align-items: center; align-content: center;">
        <a href="/project/{{ $project->id }}/readme" class="ui blue button">View Readme</a>
        <h2>View Project</h2>
        <a href="/project/{{ $project->id }}/edit" class="ui green button">Edit Project</a>
    </div>
    <div class="ui container raised segment">
        <div style="display: flex; flex-direction: column; width: 100%;">
            <div style="display: flex; flex-direction: row; justify-content: space-between; padding-bottom: 15px;">
                <div>
                    @component('project.card', ['project' => $project]) @endcomponent
                    @component('project.detailCard', ['project' => $project]) @endcomponent
                </div>
                <div style="display: flex; flex-direction: column; width: 100%; padding-left: 15px;">
                    <div class="ticket-list" style="padding-bottom: 15px;">
                        <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
                            <div>
                                <h4>Open Tickets</h4>
                            </div>
                            <div>
                                <a href="/task/create?project={{ $project->id }}" class="ui green button">New Task</a>
                            </div>
                        </div>
                        <div class="ui vertical pointing menu" style="width: 100%;">
                            @foreach($project->tasks as $task)
                                <a class="item" href="/task/{{ $task->id }}">
                                    <i class="fa fa-{{ $task->fontawesome()  }} {{ $task->type }}"></i> &nbsp; {{ $task->title }}
                                </a>
                            @endforeach
                            @if(!$project->tasks->count())
                                    <a class="item" href="#">
                                        No tasks yet, boss. Get those minions to work!
                                    </a>
                            @endif
                        </div>
                    </div>
                    <div class="imcomplete-release-list" style="padding-bottom: 15px;">
                        <h4>Planned Releases</h4>
                        <div class="ui vertical pointing menu" style="width: 100%;">
                            @foreach($project->releases->where('deleted_at', null) as $release)
                                <a class="item">
                                    {{ $release->version }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="complete-release-list" style="padding-bottom: 15px;">
                        <h4>Completed Releases</h4>
                        <div class="ui vertical pointing menu" style="width: 100%;">
                            @foreach($project->releases->filter(function($release) { return $release->deleted_at != null; }) as $release)
                                <a class="item">
                                    {{ $release->version }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h4 id="comments">Comments</h4>
                <div class="ui threaded comments">
                    @foreach($project->comments->where('parent_id', null) as $comment)
                        @component('comment.show', ['comment' => $comment, 'object' => $project, 'action' => route('project.comment')])@endcomponent
                    @endforeach
                    <form action="{{ route('project.comment') }}" method="POST" class="ui reply form">
                        {{ csrf_field() }}
                        <input type="hidden" name="object_id" value="{{ $project->id }}" />
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
    $('.reply-link').on('click', function(e) {
        $('.comment-reply').hide();
        $(e.currentTarget).siblings().show();
    });
@endpush