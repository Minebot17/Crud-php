<!DOCTYPE HTML5>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
	<body>
        <?php
        require 'utils.php';
        require 'data_base.php';
        require 'entity_validator.php';
        read_from_url($entity_index, 'ei', 0);
        require 'header.php';

        echo '<div class="container">';

        $db = DataBase::getInstance();
        $validator = EntityValidator::getInstance();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (array_key_exists('image-file', $_FILES) && array_key_exists('extension', pathinfo($_FILES['image-file']['name']))){
                $info = pathinfo($_FILES['image-file']['name']);
                $ext = $info['extension'];
                $newname = rand(0, 9999999).".".$ext;

                $target = 'images/'.$newname;
                move_uploaded_file($_FILES['image-file']['tmp_name'], $target);
                $_POST['image_url'] = 'http://jenypc.ddns.net/lab1_s/'.$target;
            }

            $validate_errors = $entity_index == 0 ? $validator->validate_author($_POST) : $validator->validate_books($_POST);
            if (count($validate_errors) == 0) {
                if ($_GET['ri'] == -1) {
                    $db->insert_new_row($entity_index, $_POST);
                } else {
                    $db->update_row($entity_index, $_POST, $_POST['id']);
                }

                echo '<p>Действие успешно выполнено</p>';
            }
            else {
                require 'edit_form.php';
            }
        }
        else if (array_key_exists('del', $_GET)) {
            $db->delete_row($entity_index, $_GET['del']);
            echo '<p>Действие успешно выполнено</p>';
        }
        else if (array_key_exists('ri', $_GET)) {
            require 'edit_form.php';
        }
        else {
            $table_view_headers = $db->entity_columns_view[$entity_index];
            $table_view_rows = $entity_index == 0 ? $db->entity_rows[0] : $db->books_rows_view;
            require 'table_view.php';
        }
        ?>
        </div>
	</body>
</html>