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
                echo '<td><img src="'.$item.'" style="max-width: 100px;"></td>';
            }
            else {
                echo '<td>' . $item . '</td>';
            }
        }

        echo '<td>
                <button type="submit" class="btn btn-primary"><a href="/index.php?ei='.$entity_index.'&ri='.$i.'" style="color: white; text-decoration: none;">Редактировать</a></button>
                <button type="submit" class="btn btn-danger" style="margin-left: 20px;"><a href="/index.php?ei='.$entity_index.'&del='.$table_view_rows[$i][0].'" style="color: white; text-decoration: none;">Удалить</a></button>
            </td>
        </tr>
        ';
    }
    ?>
    </tbody>
</table>

<button type="button" class="btn btn-primary" style="margin-left: 20px;"><a href="/index.php?ei=<?php echo $entity_index; ?>&ri=-1" style="color: white; text-decoration: none;">Создать</a></button>