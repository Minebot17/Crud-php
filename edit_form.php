<?php
read_from_url($entity_index, 'ei', 0);
read_from_url($row_index, 'ri', -1);
?>

<h2><?php echo $row_index == -1 ? 'Добавление': 'Изменение'; ?> сущности</h2><br>
<form action="/lab1_s/index.php?ei=<?php echo $entity_index; ?>&ri=<?php echo $row_index; ?>" method="post" enctype="multipart/form-data">
    <?php

    $current_entity_columns_view = $entity_columns_view[$entity_index];

    if ($row_index < 0){
        $current_entity_rows = [];

        foreach ($current_entity_columns_view as $item){
            $current_entity_rows[] = '';
        }
    }
    else {
        $current_entity_rows = $entity_rows[$entity_index][$row_index];
    }

    echo '<input name="id" value="'.$current_entity_rows[0].'" type="hidden">';
    for($i = 1; $i < count($current_entity_rows); $i++){
        if ($entity_columns[$entity_index][$i] == 'image_url'){
            echo '<input name="image_url" value="" type="hidden">';
            echo '<label for="image-file" class="form-label">Картинка</label>
                <input class="form-control" type="file" id="image-file" name="image-file"><br>';
        }
        else {
            echo '<label for="field' . $i . '" class="form-label">' . $current_entity_columns_view[$i] . '</label>
                <input type="text" class="form-control" id="field' . $i . '" name="' . $entity_columns[$entity_index][$i] . '" value="' . $current_entity_rows[$i] . '"><br>';
        }
    }
    ?>

<button type="submit" class="btn btn-primary table-button">Сохранить</button>
</form>