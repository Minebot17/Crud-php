<?php
require_once 'models/author.php';
require_once 'models/book.php';
require_once 'models/user.php';

class DataBase {

    private static $instance = null;

    public $entity_names = ['Авторы', "Книги"];
    public $entity_tables = ['author', 'book'];
    public $entity_columns = [];
    public $entity_rows = [];
    public $entity_columns_view =
        [
            ['ID', 'Имя', 'Фамилия'],
            ['ID', 'Картинка', 'Название', 'Автор', 'Описание', 'Цена']
        ];
    public $entity_columns_types =
        [
            ['hidden', 'str', 'str'],
            ['hidden', 'img', 'str', 'entity-0-1', 'str', 'str']
        ];
    public $books_rows_view;

    private $conn;

    protected function __construct() {
        $this->conn = new mysqli('jenypc.ddns.net', 'root', 'root', 'books_shop');

        if ($this->conn->connect_error) {
            die('Connect Error (' . $this->conn->connect_errno . ') ' . $this->conn->connect_error);
        }

        $this->fetchAllEntitiesColumnNames();
        $this->fetchAllEntitiesRows();
    }

    protected function __clone() { }

    public function __wakeup(){
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): DataBase {
        if (!isset(self::$instance)){
            self::$instance = new DataBase();
        }

        return self::$instance;
    }

    public function insert_author(Author $author) {
        $this->insert_new_row(0, $author);
    }

    public function update_author(Author $author) {
        $this->update_row(0, $author, $author->id);
    }

    public function delete_author(Author $author) {
        $this->delete_row(0, $author->id);
    }

    public function insert_book(Book $book) {
        $this->insert_new_row(1, $book);
    }

    public function update_book(Book $book) {
        $this->update_row(1, $book, $book->id);
    }

    public function delete_book(Book $book) {
        $this->delete_row(1, $book->id);
    }

    public function register_user(User $user): bool {
        $login = $this->conn->real_escape_string($user->login);
        $email = $this->conn->real_escape_string($user->email);
        $password = md5($this->conn->real_escape_string($user->password));
        return $this->conn->query('INSERT INTO users VALUES(0,"'.$login.'","'.$email.'","'.$password.'")');
    }

    public function login_user(User $user): bool {
        $login = $this->conn->real_escape_string($user->login);
        $password = md5($this->conn->real_escape_string($user->password));
        return $this->conn->query('SELECT * FROM users WHERE login="'.$login.'" AND password="'.$password.'"')->num_rows != 0;
    }

    private function fetchAllEntitiesColumnNames(){
        for ($i = 0; $i < count($this->entity_tables); $i++){
            if ($result = $this->conn->query('SHOW COLUMNS FROM ' . $this->entity_tables[$i])) {
                $columns_info = $result->fetch_all();
                $this->entity_columns[$i] = [];

                foreach ($columns_info as $column_info){
                    $this->entity_columns[$i][] = $column_info[0];
                }

                $result -> close();
            }
        }
    }

    private function fetchAllEntitiesRows(){
        $author_rows = [];
        if ($result = $this->conn->query('SELECT * FROM author')) {
            $author_rows = $result->fetch_all();
            $this->entity_rows[] = $author_rows;
            $result -> close();
        }

        if ($result = $this->conn->query('SELECT * FROM book')) {
            $books_rows = $result->fetch_all();
            $this->entity_rows[] = $books_rows;
            $this->books_rows_view = $books_rows;

            for ($i = 0; $i < count($this->books_rows_view); $i++){
                $found_object = $this->array_find($author_rows, function($x, $t) { return $x[0] == $t; }, $this->books_rows_view[$i][3]);
                $this->books_rows_view[$i][3] = $found_object[1];
            }

            $result -> close();
        }
    }

    private function array_find($xs, $f, $t) {
        foreach ($xs as $x) {
            if (call_user_func($f, $x, $t) === true) {
                return $x;
            }
        }

        return null;
    }

    private function insert_new_row($entity_index, $column_value_dict){
        $insert_query = "";

        foreach ($column_value_dict as $key=>$item){

            if ($key == 'id'){
                $item = 'NULL';
            }

            $insert_query .= "'".$this->conn->real_escape_string($item)."',";
        }

        $insert_query = substr($insert_query, 0, -1);
        $this->conn->query("INSERT INTO ".$this->entity_tables[$entity_index]." VALUES (".$insert_query.")");
    }

    private function update_row($entity_index, $column_value_dict, $target_row_id){
        $target_row_id = $this->conn->real_escape_string($target_row_id);
        $update_query = "";

        foreach ($column_value_dict as $key=>$item){
            if ($item == ''){
                continue;
            }

            $update_query .= $key."='".$this->conn->real_escape_string($item)."',";
        }

        $update_query = substr($update_query, 0, -1);
        $this->conn->query("UPDATE ".$this->entity_tables[$entity_index]." SET ".$update_query." WHERE id=".$target_row_id);
    }

    private function delete_row($entity_index, $target_row_id){
        echo $target_row_id;
        $target_row_id = intval($target_row_id);
        $this->conn->query("DELETE FROM ".$this->entity_tables[$entity_index]." WHERE id=".$target_row_id);
    }
}