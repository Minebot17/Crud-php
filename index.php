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
        read_from_url($entity_index, 'ei', 0);
        require 'header.php';
        echo '<div class="container">';

        $db = new mysqli('jenypc.ddns.net', 'root', 'root', 'books_shop');
        if ($db->connect_error) {
            die('Connect Error (' . $db->connect_errno . ') ' . $db->connect_error);
        }

        $entity_tables = ['author', 'book'];
        $entity_columns = [];
        $entity_rows = [];
        $entity_columns_view =
            [
                ['ID', 'Имя', 'Фамилия'],
                ['ID', 'Картинка', 'Название', 'Автор', 'Описание', 'Цена']
            ];
        $entity_columns_types =
            [
                ['hidden', 'str', 'str'],
                ['hidden', 'img', 'str', 'entity-0-1', 'str', 'str']
            ];

        for ($i = 0; $i < count($entity_tables); $i++){
            if ($result = $db -> query('SHOW COLUMNS FROM ' . $entity_tables[$i])) {
                $columns_info = $result->fetch_all();
                $entity_columns[$i] = [];

                foreach ($columns_info as $column_info){
                    $entity_columns[$i][] = $column_info[0];
                }

                $result -> close();
            }
        }

        if ($result = $db -> query('SELECT * FROM author')) {
            $author_rows = $result->fetch_all();
            $entity_rows[] = $author_rows;
            $result -> close();
        }

        if ($result = $db -> query('SELECT * FROM book')) {
            $books_rows = $result->fetch_all();
            $entity_rows[] = $books_rows;
            $books_rows_view = $books_rows;

            for ($i = 0; $i < count($books_rows_view); $i++){
                $found_object = array_find($author_rows, function($x, $t) { return $x[0] == $t; }, $books_rows_view[$i][3]);
                $books_rows_view[$i][3] = $found_object[1];
            }

            $result -> close();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (array_key_exists('image-file', $_FILES) && array_key_exists('extension', pathinfo($_FILES['image-file']['name']))){
                $info = pathinfo($_FILES['image-file']['name']);
                $ext = $info['extension'];
                $newname = rand(0, 9999999).".".$ext;

                $target = 'images/'.$newname;
                move_uploaded_file($_FILES['image-file']['tmp_name'], $target);
                $_POST['image_url'] = 'http://jenypc.ddns.net/lab1_s/'.$target;
            }

            if ($_GET['ri'] == -1) {
                $insert_query = "";

                foreach ($_POST as $key=>$item){
                    if ($key == 'id'){
                        $item = 'NULL';
                    }

                    $insert_query .= "'".$item."',";
                }

                $insert_query = substr($insert_query, 0, -1);
                $db->query("INSERT INTO ".$entity_tables[$entity_index]." VALUES ('0',".$insert_query.")");
            }
            else {
                $update_query = "";

                foreach ($_POST as $key=>$item){
                    if ($item == ''){
                        continue;
                    }

                    $update_query .= $key."='".$item."',";
                }

                $update_query = substr($update_query, 0, -1);
                $db->query("UPDATE ".$entity_tables[$entity_index]." SET ".$update_query." WHERE id=".$_POST['id']);
            }

            echo '<p>Действие успешно выполнено</p>';
        }
        else if (array_key_exists('del', $_GET)) {
            $db->query("DELETE FROM ".$entity_tables[$entity_index]." WHERE id=".$_GET['del']);
            echo '<p>Действие успешно выполнено</p>';
        }
        else if (array_key_exists('ri', $_GET)) {
            require 'edit_form.php';
        }
        else {
            $table_view_headers = $entity_columns_view[$entity_index];
            $table_view_rows = $entity_index == 0 ? $author_rows : $books_rows_view;
            require 'table_view.php';
        }
        ?>
        </div>
	</body>
</html>