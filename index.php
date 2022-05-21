<?php
require_once 'data_base.php';
require_once 'models/author.php';
require_once 'models/book.php';
session_start();

$entity_index = array_key_exists('ei', $_GET) ? $_GET['ei'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && array_key_exists('del', $_POST)) {

    if ($entity_index == 0){
        DataBase::getInstance()->delete_author(new Author($_POST['del'], "", ""));
    }
    else if ($entity_index == 1){
        DataBase::getInstance()->delete_book(new Book($_POST['del'], "", "", null, "", 0));
    }

    header('Location: index.php?');
    exit( );
}

require 'header.php';

if (array_key_exists('message', $_GET)){
    echo $_GET['message'];
}
else {
    $table_view_headers = DataBase::getInstance()->entity_columns_view[$entity_index];
    $table_view_rows = $entity_index == 0 ? DataBase::getInstance()->entity_rows[0] : DataBase::getInstance()->books_rows_view;
    require 'table_view.php';
}

require 'footer.php';