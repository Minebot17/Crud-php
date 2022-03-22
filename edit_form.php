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

    for($i = 0; $i < count($current_entity_rows); $i++){
        $current_type = $entity_columns_types[$entity_index][$i];

        if ($current_type == 'hidden'){
            echo '<input name="'.$entity_columns[$entity_index][$i].'" value="'.$current_entity_rows[$i].'" type="hidden">';
        }
        else if ($current_type == 'img'){
            echo '<input name="'.$entity_columns[$entity_index][$i].'" value="" type="hidden">';
            echo '<label for="image-file" class="form-label">Картинка</label>
                <input class="form-control" type="file" id="image-file" name="image-file"><br>';
        }
        else if (substr($current_type, 0, 6) === "entity"){
            $chunks = explode('-', $current_type);
            $select_entity_index = $chunks[1];
            $select_entity_column = $chunks[2];

            echo '<label for="select'.$i.'" class="form-label">'.$current_entity_columns_view[$i].'</label>
                <select class="form-select" aria-label="Default select example" id="select'.$i.'" name="'.$entity_columns[$entity_index][$i].'">';

            for($j = 0; $j < count($entity_rows[$select_entity_index]); $j++) {
                echo '<option '.($current_entity_rows[$i] == $entity_rows[$select_entity_index][$j][0] ? 'selected' : '').' 
                value="'.$entity_rows[$select_entity_index][$j][0].'">'.$entity_rows[$select_entity_index][$j][$select_entity_column].'</option>';
            }

            echo '</select><br>';
        }
        else {
            echo '<label for="field' . $i . '" class="form-label">' . $current_entity_columns_view[$i] . '</label>
                <input type="text" class="form-control" id="field' . $i . '" name="' . $entity_columns[$entity_index][$i] . '" value="' . $current_entity_rows[$i] . '"><br>';
        }
    }
    ?>

<button type="submit" class="btn btn-primary table-button">Сохранить</button>
</form>