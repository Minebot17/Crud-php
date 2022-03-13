<table>
    <?php
    if (array_key_exists('ei', $_GET)){
        $entity_index = $_GET['ei'];
    }
    else if (!isset($entity_index)){
        $entity_index = 0;
    }

    if (array_key_exists('ri', $_GET)){
        $row_index = $_GET['ri'];
    }
    else if (!isset($row_index)){
        $row_index = -1;
    }

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
        echo '<tr><td>'.$current_entity_columns_view[$i].'</td><td><input type="text" class="form-control" id="input'.$i.'" value="'.$current_entity_rows[$i].'"></td></tr>';
    }
    ?>
</table>

<button type="button" class="btn btn-primary" style="margin-left: 20px;">Сохранить</button>