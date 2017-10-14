@extends('welcome')

@section('content')
    <div class="ui container" style="display: flex; justify-content: flex-end;">
        <a href="/project/create" class="ui green button">New Project</a>
    </div>
    <div class="ui container raised segment">
        @foreach($projects as $project)
            <div class="column" style="padding-top: 7px; padding-bottom: 7px;">
                @component('project.card', ['project' => $project]) @endcomponent
            </div>
        @endforeach

        @if(!$projects->count())
            There's nothing here boss, create some cool projects!
        @endif
    </div>
@endsection