@extends('welcome')

@section('content')
    <div class="ui container" style="display: flex; justify-content: space-between; align-items: center; align-content: center;">
        <div>
            <a href="/project/{{ $project->id }}" class="ui blue button">Back to {{ $project->name }}</a>
        </div>
        <h2>{{ $project->name }} Readme</h2>
        <div></div>
    </div>
    <div class="ui container raised segment">
        <div id="code" style="width: 100%;"></div>
    </div>
@endsection

@push('scripts')
    $(document).ready(function() {
        var converter = new showdown.Converter();
        text = `{{ $project->readme }}`;
        html = converter.makeHtml(text);
        $('#code').html(html);
    });
@endpush