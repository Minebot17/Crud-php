<?php
function array_find($xs, $f, $t) {
    foreach ($xs as $x) {
        if (call_user_func($f, $x, $t) === true) {
            return $x;
        }
    } // TODO нахуй
    return null;
}