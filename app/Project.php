<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Get tasks applied to this project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany('App\Task')->orderBy('id', 'desc');
    }

    /**
     * Get tasks logged as bugs against this project
     *
     * @return $this
     */
    public function bugs()
    {
        return $this->hasMany('App\Task')->where('type', 'bug');
    }

    /**
     * Get tasks logged as new features against this project
     *
     * @return $this
     */
    public function features()
    {
        return $this->hasMany('App\Task')->where('type', 'feature');
    }

    public function creator()
    {
        return $this->hasOne('\App\User', 'id', 'created_by');
    }

    /**
     * Get users attached to this project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Get releases attached to this project
     *
     * @return mixed
     */
    public function releases()
    {
        return $this->hasMany('App\Release')->withTrashed();
    }

    /**
     * Get comments attached to this project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\ProjectComment')->orderBy('created_at', 'asc');
    }
}
