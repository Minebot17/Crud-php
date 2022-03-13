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
    foreach ($table_view_rows as $row) {
        echo '<tr>';

        foreach ($row as $item){
            echo '<td>' . $item . '</td>';
        }

        echo '<td>
                <button type="submit" class="btn btn-primary">Редактировать</button>
                <button type="submit" class="btn btn-danger" style="margin-left: 20px;">Удалить</button>
            </td>
        </tr>
        ';
    }
    ?>
    </tbody>
</table>

<button type="button" class="btn btn-primary">Создать</button>