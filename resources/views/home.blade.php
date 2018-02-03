@extends('welcome')

@section('content')
<div class="ui container raised segment" style="display: flex; flex-direction: column;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($projects as $project)
                        <div class="column" style="padding-top: 7px; padding-bottom: 7px;">
                            @component('project.card', ['project' => $project]) @endcomponent
                        </div>
                    @endforeach

                    @if(!$projects->count())
                        There's nothing here, boss.  Create some cool projects!
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
