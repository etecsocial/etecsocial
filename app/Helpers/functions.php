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

function getRandomNumbers($num, $min, $max, $repeat = false) {
    if ((($max - $min) + 1) >= $num) {
        $n = array();
        while (count($n) < $num) {
            $number = mt_rand($min, $max);

            if ($repeat || !in_array($number, $n)) {
                $n[] = $number;
            }
        }
        return $n;
    }
    return false;
}
