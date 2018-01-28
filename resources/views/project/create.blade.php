@extends('welcome')

@section('content')
    <div class="ui container raised segment" style="display: flex; flex-direction: column;">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <h3>New Project</h3>
            </div>
            <div>
                * designates a required field
            </div>
        </div>

        <form method="post" class="ui form" action="/project">
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Name *
                </div>
                <div class="ui input" style="width: 85%;">
                    <input name="name" type="text" placeholder="Project Name">
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Description *
                </div>
                <div class="ui fluid input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px;">
                    <input name="description" type="text" placeholder="Project Description">
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Type *
                </div>
                <div class="ui fluid input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <div class="ui dropdown fluid selection">
                        <input type="hidden" name="type">
                        <div class="default text">Type</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="web">Web</div>
                            <div class="item" data-value="writing">Writing</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Icon
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <input name="icon" type="text" placeholder="Project Icon (FontAwesome)"> &nbsp;&nbsp; <a href="http://fontawesome.io/icons/" target="_blank">FontAwesome Library</a>
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Source Code
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="source_code_url" type="text" placeholder="URL">
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Production Site
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="production_url" type="text" placeholder="URL">
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Test Site
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="test_url" type="text" placeholder="URL">
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Dev Site
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="dev_url" type="text" placeholder="URL">
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    ReadMe
                </div>
                <div class="field ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <textarea name="readme"></textarea>
                </div>
            </div>
            <div class="field" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;"></div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; flex-direction: column; margin-bottom: 15px;">
                    {{ csrf_field() }}
                    <button class="ui button green">Submit</button>
                    <div class="ui error message"></div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    $('.ui.dropdown').dropdown();

    $('.ui.form')
        .form({
            on: 'blur',
            fields: {
                name: {
                    identifier  : 'name',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : 'Please enter a name'
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
                }
            }
        });
@endpush