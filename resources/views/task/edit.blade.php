@extends('welcome')

@section('content')
    <div class="ui container raised segment" style="display: flex; flex-direction: column;">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <h3>Edit Task</h3>
            </div>
            <div>
                * designates a required field
            </div>
        </div>
        <form class="ui form" id="edit-form">
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Project
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <div class="ui dropdown fluid selection">
                        <input type="hidden" name="project_id" value="{{ $task->project->id }}">
                        <div class="default text">{{ $task->project->name }}</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            @foreach($projects as $project)
                                <div class="item" data-value="{{ $project->id }}">{{ $project->name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Title
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="title" type="text" placeholder="Task Title" value="{{ $task->title }}">
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Description
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <input name="description" type="text" placeholder="Task Description" value="{{ $task->description }}">
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Type
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <div class="ui dropdown fluid selection">
                        <input id="task-type" type="hidden" name="type" value="{{ $task->type }}">
                        <div class="default text">{{ $task->type }}</div>
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
                    <textarea name="detail">{{ $task->detail }}</textarea>
                </div>
            </div>
            @if($task->files->count())
                <div class="field" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                    <div style="width: 15%; display: flex; align-items: center;">
                        Files
                    </div>
                    <div class="field ui fluid icon input file" style="width: 85%; display: flex; flex-direction: row; align-items: center; flex-wrap: wrap; justify-content: space-between;">
                        @foreach($task->files as $file)
                            <div class="ui action input" style="width: 30%; padding-bottom: 15px;">
                                <input class="uploaded-file" modal="{{ $file->id }}" type="text" placeholder="File 1" value="{{ $file->name }}.{{ $file->extension }}" readonly>
                                <div class="ui icon button">
                                    <i class="attach icon"></i>
                                </div>
                            </div>
                            @component('file.modal', ['file' => $file])@endcomponent
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;"></div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; flex-direction: column; margin-bottom: 15px;">
                    {{ csrf_field() }}
                    <input type="hidden" name="modified_by" value="{{ Auth::user()->id }}" />
                    <button id="submit" class="ui button green">Submit</button>
                    <div class="ui error message"></div>
                </div>
            </div>
        </form>
    </div>
    <div class="ui container raised segment" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
        <div>
            <h3>Danger Zone!</h3>
        </div>
        <div>
            <a id="delete" class="ui button red">Delete</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
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

            $('#submit').on('click', function(e) {
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
                    }).api({
                        url: '{{ route('task.update', ['id' => $task->id ]) }}',
                        data: $('#edit-form').serialize(),
                        method: 'PUT',
                        onSuccess: function() {
                            location = '{{ route('task.show', ['id' => $task->id]) }}';
                        }
                    });
            });

            $('#delete').on('click', function(e) {
                $.ajax({
                    url: '{{ route('task.destroy', ['id' => $task->id]) }}',
                    data: { _token: '{{ csrf_token() }}' },
                    method: 'DELETE',
                    success: function() {
                        location = '{{ route('task.index') }}';
                    },
                    error: function() {
                        alert("Could not delete!");
                    }
                })
            });

            /** show file modal **/
            $('.uploaded-file').on('click', function(e) {
                var modalId = $(e.currentTarget).attr('modal');
                $('#fileModal' + modalId).modal('show');
            });
        });
    </script>
@endpush