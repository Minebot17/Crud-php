<?php

class EntityValidator {

    private static $instance = null;

    private $author_validators;
    private $book_validators;

    public function __construct()
    {
        $this->author_validators = array(
            "first_name" => array(function($value): bool {
                return strlen($value) >= 2 && strlen($value) <= 50;
            }, "Имя должно быть длинной от 2 до 50 символов"),
            "second_name" => array(function($value): bool {
                return strlen($value) >= 2 && strlen($value) <= 50;
            }, "Фамилия должна быть длинной от 2 до 50 символов"),
        );

        $this->book_validators = array(
            "name" => array(function($value): bool {
                return strlen($value) >= 2 && strlen($value) <= 50;
            }, "Название должно быть длинной от 2 до 50 символов"),
            "description" => array(function($value): bool {
                return strlen($value) >= 2 && strlen($value) <= 200;
            }, "Описание должно быть длинной от 2 до 200 символов"),
            "cost" => array(function($value): bool {
                return is_int($value) && ((int) $value) >= 1;
            }, "Фамилия должна быть не меньше 1"),
        );
    }

    protected function __clone() { }

    public function __wakeup(){
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): EntityValidator {
        if (!isset(self::$instance)){
            self::$instance = new EntityValidator();
        }

        return self::$instance;
    }

    public function validate_author($columns_values): array {
        $result = array();

        foreach ($columns_values as $key=>$value){
            if (array_key_exists($key, $this->author_validators)){
                $validator = $this->author_validators[$key];

                if (!$validator[0]($value)){
                    $result[$key] = $validator[1];
                }
            }
        }

        return $result;
    }

    public function validate_books($columns_values): array {
        $result = array();

        foreach ($columns_values as $key=>$value){
            if (array_key_exists($key, $this->book_validators)){
                $validator = $this->book_validators[$key];

                if (!$validator[0]($value)){
                    $result[$key] = $validator[1];
                }
            }
        }

        return $result;
    }
}
