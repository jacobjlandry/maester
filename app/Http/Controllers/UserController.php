<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(Request $request)
    {
        return view('users.list')
            ->with('users', User::all())
            ->with('roles', Role::all());
    }

    /**
     * Add a role to a user
     *
     * @param Request $request
     */
    public function addRole(Request $request)
    {
        User::find($request->input('user_id'))
            ->addRole(Role::find($request->input('role_id')));
    }

    /**
     * Remove a role from a user
     *
     * @param Request $request
     */
    public function removeRole(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $role = Role::find($request->input('role_id'));

        $user->removeRole($role);
    }
}
