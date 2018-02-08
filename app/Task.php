<?php

namespace App;

use Carbon\Carbon;
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
            case 'deleted':
                return 'red';
                break;
            case 'new':
                return 'yellow';
                break;
            case 'in progress':
                return 'blue';
                break;
        }
    }

    public function estimateInSeconds()
    {
        if($this->estimate) {
            return $this->estimate * 1000;//3600;
        }
        else {
            return 0;
        }
    }

    public function timeWorked()
    {
        $notes = $this->notes
            ->filter(function($row){
                return preg_match("/in progress/", $row->note);
            });

        $work = $notes->filter(function($row) {
                return preg_match('/=> in progress/', $row->note);
            })->keys()
            ->map(function($key) use($notes) {
                $start = $notes[$key]->created_at;

                if(isset($notes[$key + 1])) {
                    $end = $notes[$key + 1]->created_at;
                    return $start->diffInSeconds($end);
                }
                else {
                    return $start->diffInSeconds(Carbon::now());
                }
            });

        return $work->sum();
    }

    public function completionPercent()
    {
        return round(($this->timeWorked() / $this->estimateInSeconds()) * 100);
    }
}
