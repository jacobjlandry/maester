<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectComment extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return ProjectComment::where('parent_id', $this->id)->get();
    }
}
