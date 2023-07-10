<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function list() {
        $includes = collect(scandir("build/assets"));
        $css = $includes->filter(function(string $file) { return preg_match("/\.css$/", $file); });
        $js = $includes->filter(function(string $file) { return preg_match("/\.js$/", $file); });
        
        return view('app')
            ->with('css_includes', $css)
            ->with('js_includes', $js);
    }
}
