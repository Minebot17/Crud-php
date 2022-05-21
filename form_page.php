<?php
require_once 'data_base.php';
require_once 'entity_validator.php';
require_once 'models/author.php';
require_once 'models/book.php';

$entity_index = array_key_exists('ei', $_GET) ? $_GET['ei'] : 0;
$action_success_view = false;

if (!array_key_exists('is_auth', $_POST) || !$_SESSION['is_auth']){
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validate_errors = $entity_index == 0
        ? EntityValidator::validate_author($_POST)
        : EntityValidator::validate_books($_POST);

    if (count($validate_errors) == 0) {

        if (array_key_exists('image-file', $_FILES)
            && array_key_exists('extension', pathinfo($_FILES['image-file']['name']))) {

            $info = pathinfo($_FILES['image-file']['name']);
            $ext = $info['extension'];
            $newname = rand(0, 9999999) . "." . $ext;

            $target = 'images/' . $newname;
            move_uploaded_file($_FILES['image-file']['tmp_name'], $target);
            $_POST['image_url'] = 'http://jenypc.ddns.net/lab1_s/' . $target;
        }

        if ($_GET['ri'] == -1) {
            if ($entity_index == 0){
                DataBase::getInstance()->insert_author(Author::FromPost());
            }
            else if ($entity_index == 1){
                DataBase::getInstance()->insert_book(Book::FromPost());
            }
        } else {
            if ($entity_index == 0){
                DataBase::getInstance()->update_author(Author::FromPost());
            }
            else if ($entity_index == 1){
                DataBase::getInstance()->update_book(Book::FromPost());
            }
        }

        $action_success_view = true;
    }
}

require 'header.php';

if ($action_success_view){
    echo '<p>Действие успешно выполнено</p>';
}
else {
    require 'edit_form.php';
}

require 'footer.php';