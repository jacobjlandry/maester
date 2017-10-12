@extends('welcome')

@section('content')
    <div class="ui container raised segment" style="display: flex; flex-direction: column;">
        <h3>Edit Project</h3>
        <form id='edit-form' method="post" class="ui form" action="/project/{{ $project->id }}">
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Name
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="name" type="text" placeholder="Project Name" value="{{ $project->name }}">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Description
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <input name="description" type="text" placeholder="Project Description" value="{{ $project->description }}">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Type
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <div class="ui dropdown fluid selection">
                        <input type="hidden" name="type" value="{{ $project->type }}">
                        <div class="default text">{{ ucfirst($project->type) }}</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="web" @if($project->type == 'web') selected @endif>Web</div>
                            <div class="item" data-value="writing" @if($project->type == 'writing') selected @endif>Writing</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Icon
                </div>
                <div class="ui fluid icon input labeled" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <div class="ui label">
                        <i class="fa fa-{{ $project->icon }}"></i>
                    </div>
                    <input name="icon" type="text" placeholder="Project Icon (FontAwesome)" value="{{ $project->icon }}"> &nbsp;&nbsp; <a href="http://fontawesome.io/icons/" target="_blank">FontAwesome Library</a>
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Source Code
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="source_code_url" type="text" placeholder="URL" value="{{ $project->source_code_url }}">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Production Site
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="production_url" type="text" placeholder="URL" value="{{ $project->production_url }}">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Test Site
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="test_url" type="text" placeholder="URL" value="{{ $project->test_url }}">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Dev Site
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="dev_url" type="text" placeholder="URL" value="{{ $project->dev_url }}">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    ReadMe
                </div>
                <div class="field ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <textarea name="readme">{{ $project->readme }}</textarea>
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;"></div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px;">
                    {{ csrf_field() }}
                    <button id="submit" class="ui button green">Submit</button>
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
            $('#submit').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('project.update', ['id' => $project->id ]) }}',
                    data: $('#edit-form').serialize(),
                    method: 'PUT',
                    success: function() {
                        location = '{{ route('project.show', ['id' => $project->id]) }}';
                    },
                    error: function() {
                        alert("Could not update!");
                    }
                });
            });

            $('#delete').on('click', function(e) {
                $.ajax({
                    url: '{{ route('project.destroy', ['id' => $project->id]) }}',
                    data: { _token: '{{ csrf_token() }}' },
                    method: 'DELETE',
                    success: function() {
                        location = '{{ route('project.index') }}';
                    },
                    error: function() {
                        alert("Could not delete!");
                    }
                })
            });
        });
    </script>
@endpush