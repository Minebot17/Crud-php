<?php

class User {

    public int $id = 0;
    public string $login;
    public string $email;
    public string $password;

    public function __construct(int $id, string $login, string $email, string $password)
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
    }

    public static function FromPost(): User {
        return new User(
            empty($_POST['id']) ? 0 : $_POST['id'],
            empty($_POST['login']) ? "" : $_POST['login'],
            empty($_POST['email']) ? "" : $_POST['email'],
            empty($_POST['password']) ? "" : $_POST['password']);
    }
}