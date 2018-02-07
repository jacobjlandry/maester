<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

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

    public function creator()
    {
        return $this->hasOne('\App\User', 'id', 'created_by');
    }

    public function owner()
    {
        return $this->hasOne('\App\User', 'id', 'owned_by');
    }

    public function users()
    {
        return $this->belongsToMany('\App\User');
    }

    public function hasUser($userId)
    {
        return $this->users->search(function($item) use($userId) {
            return $item->id == $userId;
        }) !== false;
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

    public function notes()
    {
        return $this->hasMany('\App\TaskNote');
    }

    public function statusColor()
    {
        switch($this->status) {
            case 'complete':
                return 'green';
                break;
            case 'rejected':
                return 'red';
                break;
        }
    }
}
