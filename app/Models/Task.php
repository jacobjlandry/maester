<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Http\Request;

class Task extends Model
{
    use HasFactory;

    protected $guarded = ['_id', 'created_at', 'updated_at', 'deleted_at'];
    // protected $primaryKey = '_id';
    // public $incrementing = false;
    
    /**
     * Check if this task has any subtasks related to it
     * @return bool
     */
    public function hasSubtasks()
    {
        if (Task::where('parent_id', $this->id)->count()) {
            return true;
        }

        return false;
    }
}
