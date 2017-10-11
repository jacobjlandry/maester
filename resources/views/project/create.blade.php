@extends('welcome')

@section('content')
    <div class="ui container raised segment" style="display: flex; flex-direction: column;">
        <h3>New Project</h3>
        <form method="post" class="ui form" action="/project">
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
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Icon
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px">
                    <input name="icon" type="text" placeholder="Project Icon (FontAwesome)"> &nbsp;&nbsp; <a href="http://fontawesome.io/icons/" target="_blank">FontAwesome Library</a>
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Source Code
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="source_code_url" type="text" placeholder="URL">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Production Site
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="production_url" type="text" placeholder="URL">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Test Site
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="test_url" type="text" placeholder="URL">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    Dev Site
                </div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <input name="dev_url" type="text" placeholder="URL">
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 15px;">
                <div style="width: 15%; display: flex; align-items: center;">
                    ReadMe
                </div>
                <div class="field ui fluid icon input" style="width: 85%; display: flex; align-items: center;">
                    <textarea name="readme"></textarea>
                </div>
            </div>
            <div class="form-item" style="display: flex; flex-direction: row; justify-content: space-between;">
                <div style="width: 15%; display: flex; align-items: center;"></div>
                <div class="ui fluid icon input" style="width: 85%; display: flex; align-items: center; margin-bottom: 15px;">
                    {{ csrf_field() }}
                    <button class="ui button green">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ui.dropdown').dropdown();
        });
    </script>
@endpush