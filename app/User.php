<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get this User's roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * Associate Role with User
     *
     * @param Role $role
     */
    public function addRole(Role $role)
    {
        $this->roles()->attach($role);
    }

    /**
     * Remove Role from this User
     *
     * @param Role $role
     */
    public function removeRole(Role $role)
    {
        $this->roles()->detach($role);
    }

    /**
     * Return whether or not a user belongs to a role
     *
     * @param $role
     * @return mixed
     */
    public function role($role)
    {
        return $this->roles
            ->pluck('name')
            ->search(strtolower($role)) !== false;
    }

    /**
     * Return all users not attached to a particular project
     *
     * @param Project $project
     * @return mixed
     */
    public static function withoutProject(Project $project)
    {
        return User::whereNotIn('id', $project->users->pluck('id')->toArray())
            ->get();
    }
}
