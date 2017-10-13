<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = ['id'];

    public function fontawesome()
    {
        switch($this->type) {
            default:
            case 'feature':
                return 'list';
                break;
            case 'bug':
                return 'bug';
                break;
        }
    }

    public function release()
    {
        return $this->hasOne('App\Release');
    }

    public function user()
    {
        return $this->hasOne('\App\User', 'id', 'created_by');
    }

    public function project()
    {
        return $this->belongsTo('\App\Project');
    }

    public function files()
    {
        return $this->hasMany('\App\File');
    }

    public function comments()
    {
        return $this->hasMany('\App\TaskComment');
    }
}
