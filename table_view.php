<div>
    <h1 class="table-header"><?php echo DataBase::getInstance()->entity_names[$entity_index]; ?></h1>
    <button type="button" class="btn btn-success table-button-create"><a class="table-button-link" href="/lab1_s/form_page.php?ei=<?php echo $entity_index; ?>&ri=-1">Создать</a></button>
</div>
<table class="table">
    <thead>
    <tr>
        <?php foreach ($table_view_headers as $header): ?>
            <th scope="col"><?=$header;?></th>
        <?php endforeach; ?>
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
                <button type="submit" class="btn btn-primary table-button"><a class="table-button-link" href="/lab1_s/form_page.php?ei='.$entity_index.'&ri='.$i.'">Редактировать</a></button>
                <form method="post" action="/lab1_s/index.php?ei='.$entity_index.'" class="table-header">
                    <input type="hidden" value="'.$table_view_rows[$i][0].'">
                    <button type="submit" class="btn btn-danger table-button table-header">Удалить</button>
                </form>
            </td>
        </tr>
        ';
    }
    ?>
    </tbody>
</table>