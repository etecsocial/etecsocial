<?php

function active_class_path($paths, $classes = null)
{
    foreach ((array) $paths as $path) {
        if (request()->is($path)) {
            return ($classes ? $classes . ' ' : '') . 'active';
        }
    }
    return $classes ? $classes : '';
}
