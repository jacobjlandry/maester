@extends('welcome')

@section('content')
    <div class="ui container raised segment" style="display: flex; flex-direction: column;">
        <h3>
            New Task
            @if(Request::get('project'))
                for {{ \App\Project::find(Request::get('project'))->name }}
            @endif
        </h3>
        <form method="post" class="ui form" action="/task" enctype="multipart/form-data">
            @if(Request::get('project'))
                <input type="hidden" name="project_id" value="{{ Request::get('project') }}" />
            @else
                <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                    <div style="width: 15%; display: flex; align-items: center;">
                        Project
                    </div>
                    <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                        <div class="ui dropdown fluid selection">
                            <input type="hidden" name="project_id">
                            <div class="default text">Project</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                @foreach($projects as $project)
                                    <div class="item" data-value="{{ $project->id }}">{{ $project->name }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Title
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="title" type="text" placeholder="Task Title">
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Description
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <input name="description" type="text" placeholder="Task Description">
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Type
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <div class="ui dropdown fluid selection">
                        <input id="task-type" type="hidden" name="type">
                        <div class="default text">Type</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="bug">Bug</div>
                            <div class="item" data-value="feature">Feature</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    <div id="bug-detail" style="display: none;">Steps to Recreate</div>
                    <div id="feature-detail">Details</div>
                </div>
                <div class="field ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <textarea name="detail"></textarea>
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Files
                </div>
                <div class="field ui fluid icon input file" style="width: 85%; display: flex; align-items: center;">
                    <div class="ui action input">
                        <input type="text" placeholder="File 1" readonly>
                        <input name="file1" type="file" style="display: none;">
                        <div class="ui icon button">
                            <i class="attach icon"></i>
                        </div>
                    </div>
                    &nbsp;&nbsp;
                    <div class="ui action input">
                        <input type="text" placeholder="File 2" readonly>
                        <input name="file2" type="file" style="display: none;">
                        <div class="ui icon button">
                            <i class="attach icon"></i>
                        </div>
                    </div>
                    &nbsp;&nbsp;
                    <div class="ui action input">
                        <input type="text" placeholder="File 3" readonly>
                        <input name="file3" type="file" style="display: none;">
                        <div class="ui icon button">
                            <i class="attach icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;"></div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; flex-direction: column; margin-bottom: 15px;">
                    {{ csrf_field() }}
                    <input type="hidden" name="created_by" value="{{ Auth::user()->id }}" />
                    <button class="ui button green">Submit</button>
                    <div class="ui error message"></div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
$('.ui.dropdown').dropdown();
$('#task-type').on('change', function(e) {
    if($('#task-type').val() == "bug") {
        $('#bug-detail').show();
        $('#feature-detail').hide();
    }
    else if($('#task-type').val() == "feature") {
        $('#bug-detail').hide();
        $('#feature-detail').show();
    }
});

$("input:text", '.file').click(function() {
    $(this).parent().find("input:file").click();
});

$('input:file', '.file')
    .on('change', function(e) {
        var name = e.target.files[0].name;
        $('input:text', $(e.target).parent()).val(name);
    });

$('.ui.form')
    .form({
        on: 'blur',
        fields: {
            project: {
                identifier  : 'project_id',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Please choose a project'
                    }
                ]
            },
            title: {
                identifier  : 'title',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Please enter a title'
                    }
                ]
            },
            description: {
                identifier  : 'description',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Please enter a description'
                    }
                ]
            },
            type: {
                identifier  : 'type',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Please choose a type'
                    }
                ]
            },
            detail: {
                identifier  : 'detail',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Please provide details or steps to reproduce'
                    }
                ]
            }
        }
    });
@endpush