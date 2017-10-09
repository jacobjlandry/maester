<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
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
}
