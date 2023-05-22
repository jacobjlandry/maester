<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LivewireController extends Controller
{
    public function list() {
        return view('livewireapp');
    }
}
