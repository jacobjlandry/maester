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

    public static function searchBy(Request $request)
    {
        if ($request->get('parent')) {
            return self::where('parent_id', $request->get('parent'))->get();
        } else {
            return self::whereNull('parent_id')->get();
        }
    }

    public function validateInput(Request $request) 
    {
        $title = $request->get('title');
        $description = $request->get('description', null);
        $parent = $request->get('parent', null);

        // required params
        if (!$title) {
            abort(400, 'Title is required');
        }
        $this->title = $title;

        // optional params
        $this->description = $description;
        $this->parent_id = $parent;
    }

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
