<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function bugs()
    {
        return $this->hasMany('App\Task')->where('type', 'bug');
    }

    public function features()
    {
        return $this->hasMany('App\Task')->where('type', 'feature');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function releases()
    {
        return $this->hasMany('App\Release')->withTrashed();
    }

    public function comments()
    {
        return $this->hasMany('App\ProjectComment');
    }
}
