<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;

class Counter extends Component
{
    public $count = 0;
    public $tasks = [];

    public function increment() 
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
