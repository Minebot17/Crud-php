<?php

class Author {

    public int $id = 0;
    public string $first_name;
    public string $second_name;

    public function __construct(int $id, string $first_name, string $second_name)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->second_name = $second_name;
    }

    public static function FromPost(): Author {
        return new Author(empty($_POST['id']) ? 0 : $_POST['id'], $_POST['first_name'], $_POST['second_name']);
    }
}