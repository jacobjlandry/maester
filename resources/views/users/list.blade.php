@extends('welcome')

@section('content')
    <div class="ui container raised segment">
        <table class="ui celled table">
            <thead>
                <tr>
                    <th>Name</th>
                    @foreach($roles as $role)
                        <th>{{ $role->name }}</th>
                    @endforeach
                </tr>
            </thead>
            @foreach($users as $user)
                @component('users.list-item', ['user' => $user, 'roles' => $roles]) @endcomponent
            @endforeach
        </table>
    </div>
@endsection

@push('scripts')
    $('.role').on('click', function(e) {
        var checkbox = $(e.currentTarget);
        var userId = checkbox.attr('user_id');
        var roleId = checkbox.attr('role_id');

        // add role to user or remove as requested
        if(checkbox.is(':checked')) {
            $.get('/admin/users/addRole?user_id=' + userId + '&role_id=' + roleId);
        }
        else {
            $.get('/admin/users/removeRole?user_id=' + userId + '&role_id=' + roleId);
        }
    });
@endpush