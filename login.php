<?php
require_once 'data_base.php';
require_once 'entity_validator.php';
session_start();
$action_success_view = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validate_errors = EntityValidator::validate_auth($_POST);

    if (count($validate_errors) == 0) {
        $user = User::FromPost();
        $login_success = DataBase::getInstance()->login_user(User::FromPost());

        if (!$login_success){
            $login_error = true;
        }
        else {
            $_SESSION["is_auth"] = true;
            $_SESSION['login'] = $user->login;
        }

        $action_success_view = $login_success;
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'GET'
    && array_key_exists('logout', $_GET)
    && $_GET['logout'])
{
    $_SESSION["is_auth"] = false;
    $_SESSION['login'] = "";
    $action_success_view = true;
}

require 'header.php';
if ($action_success_view){
    echo '<p>Действие успешно выполнено</p>';
}
else {
    $is_register = false;
    require 'auth_form.php';
}
require 'footer.php';