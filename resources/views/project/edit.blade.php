@extends('welcome')

@section('content')
    <div class="ui container raised segment" style="display: flex; flex-direction: column;">
        <h3>Edit Project</h3>
        <form id='edit-form' method="post" action="/project/{{ $project->id }}">
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
                    <input name="type" type="text" placeholder="Project Type" value="{{ $project->type }}">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Icon
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <input name="fontawesome" type="text" placeholder="Project Icon (FontAwesome)" value="{{ $project->fontawesome }}">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">

                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px;">
                    {{ csrf_field() }}
                    <a id='submit' class="ui button green">Submit</a>
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