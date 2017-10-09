@extends('welcome')

@section('content')
    <div class="ui container raised segment" style="display: flex; flex-direction: column;">
        <h3>New Project</h3>
        <form method="post" action="/project">
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Name
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="name" type="text" placeholder="Project Name">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Description
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <input name="description" type="text" placeholder="Project Description">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Type
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <input name="type" type="text" placeholder="Project Type">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Icon
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <input name="fontawesome" type="text" placeholder="Project Icon (FontAwesome)">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">

                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px;">
                    {{ csrf_field() }}
                    <button class="ui button green">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection