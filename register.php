<?php
require_once 'data_base.php';
require_once 'entity_validator.php';
session_start();
$action_success_view = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validate_errors = EntityValidator::validate_auth($_POST);

    if (count($validate_errors) == 0) {
        $register_success = DataBase::getInstance()->register_user(User::FromPost());

        if (!$register_success){
            $register_error = true;
        }

        $action_success_view = $register_success;
    }
}

require 'header.php';
if ($action_success_view){
    echo '<p>Действие успешно выполнено</p>';
}
else {
    $is_register = true;
    require 'auth_form.php';
}
require 'footer.php';