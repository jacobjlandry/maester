<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    protected $guarded = ['id'];

    /**
     * Get user who made this comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get list of replies to this comment
     *
     * @return mixed
     */
    public function comments()
    {
        return TaskComment::where('parent_id', $this->id)->orderBy('created_at', 'asc')->get();
    }
}
