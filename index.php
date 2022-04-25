<?php
require 'header.php';

$db = DataBase::getInstance();
$validator = EntityValidator::getInstance();
$current_view = 'table_view.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (array_key_exists('image-file', $_FILES) && array_key_exists('extension', pathinfo($_FILES['image-file']['name']))) {
        $info = pathinfo($_FILES['image-file']['name']);
        $ext = $info['extension'];
        $newname = rand(0, 9999999) . "." . $ext;

        $target = 'images/' . $newname;
        move_uploaded_file($_FILES['image-file']['tmp_name'], $target);
        $_POST['image_url'] = 'http://jenypc.ddns.net/lab1_s/' . $target;
    }

    $validate_errors = $entity_index == 0 ? $validator->validate_author($_POST) : $validator->validate_books($_POST);
    if (count($validate_errors) == 0) {
        if ($_GET['ri'] == -1) {
            $db->insert_new_row($entity_index, $_POST);
        } else {
            $db->update_row($entity_index, $_POST, $_POST['id']);
        }

        $current_view = 'action_success';
    } else {
        $current_view = 'edit_form.php';
    }
} else if (array_key_exists('del', $_GET)) {
    $db->delete_row($entity_index, $_GET['del']);
    $current_view = 'action_success';
} else if (array_key_exists('ri', $_GET)) {
    $current_view = 'edit_form.php';
} else {
    $table_view_headers = $db->entity_columns_view[$entity_index];
    $table_view_rows = $entity_index == 0 ? $db->entity_rows[0] : $db->books_rows_view;
    $current_view = 'table_view.php';
}

switch ($current_view){
    case 'action_success':
        echo '<p>Действие успешно выполнено</p>';
        break;

    default:
        require $current_view;
        break;
}

require 'footer.php';