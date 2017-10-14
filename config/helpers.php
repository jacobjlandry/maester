<?php

/**
 * Helper function to determine if we are looking at the currently active nav pill or not
 * 
 * @param $target
 * @return bool|int
 */
function active_nav($target)
{
    if($target == 'home') {
        return \Illuminate\Http\Request::capture()->path() == '/';
    }

    return preg_match("/{$target}/", \Illuminate\Http\Request::capture()->path());
}