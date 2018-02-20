<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Release extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * list tasks for this release
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany('\App\Task')->withTrashed();
    }

    public function tasksByPriority()
    {
        return $this->tasks->sortBy(function($task) {
            $order = collect(['highest', 'normal', 'lowest']);

            return $order->search($task->priority);
        });
    }

    public function project()
    {
        return $this->belongsTo('\App\Project');
    }

    public function completionPercent()
    {
        return round(($this->tasks->where('status', 'complete')->count() / $this->tasks->count()) * 100);
    }
}
