<?php
require_once 'functions.php';
$input = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $content = $_POST['content'];
    switch ($_POST['function']){
        case '0':
            $result = Functions::getAllP($content);
            break;

        case '1':
            $result = Functions::smartTrim($content);
            break;

        case '2':
            $result = Functions::getAllA($content);
            break;

        case '3':
            $result = Functions::formatClear($content);
            break;
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'GET' && array_key_exists('preset', $_GET)){
    $input = file_get_contents('preset'.$_GET['preset'].'.txt');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <form action="/lab1_s/lab5/text.php" method="post">
            <textarea name="content"><?php echo htmlspecialchars($input); ?></textarea><br>
            <select name="function">
                <option value="0" selected>Задание 3</option>
                <option value="1">Задание 9</option>
                <option value="2">Задание 14</option>
                <option value="3">Задание 19</option>
            </select><br>
            <input type="submit" value="Отправить">
        </form><br>
        <div>
            <?php if (isset($result)) echo str_replace('\n', '<br>', $result); ?>
        </div>
    </body>
</html>