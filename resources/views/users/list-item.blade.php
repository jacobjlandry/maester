<tr>
    <td>{{ $user->name }}</td>
    @foreach($roles as $role)
        <td><input class='role' user_id='{{ $user->id }}' role_id='{{ $role->id }}' type="checkbox" @if($user->role($role->name)) checked @endif/></td>
    @endforeach
</tr>