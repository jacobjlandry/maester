@extends('welcome')

@section('content')
    <div class="ui container" style="display: flex; justify-content: flex-end;">
        <a href="/task/create" class="ui green button">New Task</a>
    </div>
    <div class="ui container raised segment">
        @foreach($tasks as $task)
            <div class="column" style="padding-top: 7px; padding-bottom: 7px;">
                @component('task.card', ['task' => $task])@endcomponent
            </div>
        @endforeach

        @if($tasks->count() == 0)
            There's nothing here, boss. Get the minions in shape!
        @endif
    </div>
@endsection