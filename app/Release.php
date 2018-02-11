<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Release extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function tasks()
    {
        return $this->hasMany('\App\Task');
    }
}
