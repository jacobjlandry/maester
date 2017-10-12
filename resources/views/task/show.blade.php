@extends('welcome')

@section('content')
    <div class="ui container" style="display: flex; justify-content: space-between;">
        <a href="/project/{{ $task->id }}/readme" class="ui blue button">View Readme</a>
        <a href="/project/{{ $task->id }}/edit" class="ui green button">Edit Project</a>
    </div>
    <div class="ui container raised segment">

    </div>
@endsection

@push('scripts')

@endpush