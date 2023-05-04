<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = ['_id', 'created_at', 'updated_at', 'deleted_at'];
    // protected $primaryKey = '_id';
    // public $incrementing = false;
}
