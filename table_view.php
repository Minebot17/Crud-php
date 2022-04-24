<div>
    <h1 class="table-header"><?php echo DataBase::getInstance()->entity_names[$entity_index]; ?></h1>
    <button type="button" class="btn btn-success table-button-create"><a class="table-button-link" href="/lab1_s/index.php?ei=<?php echo $entity_index; ?>&ri=-1">Создать</a></button>
</div>
<table class="table">
    <thead>
    <tr>
        <?php
        foreach ($table_view_headers as $header){
            echo '<th scope="col">' . $header . '</th>';
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i = 0; $i < count($table_view_rows); $i++) {
        $row = $table_view_rows[$i];
        echo '<tr>';

        foreach ($row as $item){
            if (strpos($item, 'http') !== false){
                echo '<td><img class="table-image" src="'.$item.'"></td>';
            }
            else {
                echo '<td>' . $item . '</td>';
            }
        }

        echo '<td>
                <button type="submit" class="btn btn-primary table-button"><a class="table-button-link" href="/lab1_s/index.php?ei='.$entity_index.'&ri='.$i.'">Редактировать</a></button>
                <button type="submit" class="btn btn-danger table-button"><a class="table-button-link" href="/lab1_s/index.php?ei='.$entity_index.'&del='.$table_view_rows[$i][0].'">Удалить</a></button>
            </td>
        </tr>
        ';
    }
    ?>
    </tbody>
</table>