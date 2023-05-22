<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task as TaskModel;

class Task extends Component
{
    public $tasks = [];

    public function load()
    {
        $this->tasks = TaskModel::whereNull('parent_id')->get();
    }

    public function render()
    {
        return view('livewire.task');
    }
}
