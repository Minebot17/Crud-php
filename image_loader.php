<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] != 'GET'
    || !array_key_exists('image', $_GET)
    || !array_key_exists('is_auth', $_SESSION)
    || !$_SESSION['is_auth']) {
    exit();
}

readfile($_GET['image']);