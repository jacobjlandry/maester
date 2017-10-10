<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectComment extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the user this comment was made by
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get all comments that are responding to this comment
     *
     * @return mixed
     */
    public function comments()
    {
        return ProjectComment::where('parent_id', $this->id)->orderBy('created_at', 'asc')->get();
    }
}
