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

        if ($result = $db -> query("SELECT * FROM author")) {
            $author_rows = $result->fetch_all();
            $result -> close();
        }

        if ($result = $db -> query("SELECT * FROM book")) {
            $books_rows = $result->fetch_all();
            $books_rows_view = $books_rows;

            for ($i = 0; $i < count($books_rows_view); $i++){
                $found_object = array_find($author_rows, function($x, $t) { return $x[0] == $t; }, $books_rows_view[$i][3]);
                $books_rows_view[$i][3] = $found_object[1];
                $books_rows_view[$i][1] = 'url';
            }

            $result -> close();
        }

        $table_view_headers = $entity_index == 0 ?
            ['ID', 'Имя', 'Фамилия'] :
            ['ID', 'Картинка', 'Название', 'Автор', 'Описание', 'Цена'];

        $table_view_rows = $entity_index == 0 ? $author_rows : $books_rows_view;
        require 'table_view.php';
        ?>
	</body>
</html>