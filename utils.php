<?php
function array_find($xs, $f, $t) {
    foreach ($xs as $x) {
        if (call_user_func($f, $x, $t) === true) {
            return $x;
        }
    }
    return null;
}

function read_from_url(&$var, $key, $default){
    if (array_key_exists($key, $_GET)){
        $var = $_GET[$key];
    }
    else if (!isset($var)){
        $var = $default;
    }
}