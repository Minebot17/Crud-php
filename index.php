<!DOCTYPE HTML5>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	</head>
	<body>
        <?php
        function array_find($xs, $f, $t) {
            foreach ($xs as $x) {
                if (call_user_func($f, $x, $t) === true)
                    return $x;
            }
            return null;
        }

        if (array_key_exists('ei', $_GET)){
            $entity_index = $_GET['ei'];
        }
        else if (!isset($entity_index)){
            $entity_index = 0;
        }

        require 'header.php';

        $db = new mysqli('localhost', 'root', '', 'books_shop');
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
                $books_rows_view[$i][1] = 'url';
            }

            $result -> close();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_GET['ri'] == -1) {
                $insert_query = "";

                foreach ($_POST as $key=>$item){
                    if ($key == 'id'){
                        $item = 'NULL';
                    }

                    $insert_query .= "'".$item."',";
                }

                $insert_query = substr($insert_query, 0, -1);
                $db->query("INSERT INTO ".$entity_tables[$entity_index]." VALUES (".$insert_query.")");
            }
            else {
                $update_query = "";

                foreach ($_POST as $key=>$item){
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
	</body>
</html>