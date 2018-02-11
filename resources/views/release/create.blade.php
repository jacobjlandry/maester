@extends('welcome')

@section('content')
    <div class="ui container raised segment" style="display: flex; flex-direction: column;">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <h3>New Release</h3>
            </div>
        </div>

        <form method="post" class="ui form" action="/release">
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Version
                </div>
                <div class="ui input" style="width: 85%;">
                    <input name="version" type="text" placeholder="Version">
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">Release Tasks</div>
                <div id="release-tasks" class="ui vertical pointing menu" style="width: 85%;"></div>
                <div id="hidden-inputs" style="display: none;"></div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">Available Tasks</div>
                <div id="available-tasks" class="ui vertical pointing menu" style="width: 85%;">
                    @foreach($project->openTasks() as $task)
                        <div class="item" task-id="{{ $task->id }}" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
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
                        </div>
                    @endforeach
                    @if(!$project->tasks->count())
                        <a class="item" href="#">
                            No tasks yet, boss. Get those minions to work!
                        </a>
                    @endif
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;"></div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; flex-direction: column; margin-bottom: 15px;">
                    {{ csrf_field() }}
                    <input type="hidden" name="project_id" value="{{ $project->id }}" />
                    <button class="ui button green">Submit</button>
                    <div class="ui error message"></div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    dragula([document.querySelector('#release-tasks'), document.querySelector('#available-tasks')], {
            revertOnSpill: true
        }).on('drop', function (el) {
            var tasks = [];
            $('#release-tasks .item').each(function(el, target, source, sibling) {
                tasks.push("<input type='hidden' name='tasks[]' value='" + $(target).attr('task-id') + "' />");
            });
            $('#hidden-inputs').html(tasks.join(''));
        });
@endpush