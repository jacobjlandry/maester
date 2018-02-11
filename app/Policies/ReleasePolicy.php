<?php

namespace App\Policies;

use App\User;
use App\Release;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReleasePolicy
{
    use HandlesAuthorization;

    /**
     * Always allow admins through
     *
     * @param User $user
     * @param $ability
     * @return mixed
     */
    public function before(User $user, $ability)
    {
        return ($user->role('admin') ? $user->role('admin') : null);
    }

    /**
     * Determine whether the user can view the task.
     *
     * @param  \App\User  $user
     * @param  \App\Release $release
     * @return mixed
     */
    public function view(User $user, Release $release)
    {
        return (
            $user->id == $release->project->creator->id ||
            $release->project->users->pluck('id')->search($user->id) !== false
        );
    }

    /**
     * Determine whether the user can create tasks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the task.
     *
     * @param  \App\User  $user
     * @param  \App\Release $release
     * @return mixed
     */
    public function update(User $user, Release $release)
    {
        return (
            $user->id == $release->project->creator->id ||
            $release->project->users->pluck('id')->search($user->id) !== false
        );
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param  \App\User  $user
     * @param  \App\Release $release
     * @return mixed
     */
    public function delete(User $user, Release $release)
    {
        return (
            $user->id == $release->project->creator->id ||
            $release->project->users->pluck('id')->search($user->id) !== false
        );
    }
}
