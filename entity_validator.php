<?php

class EntityValidator {

    private static function validate_value(&$errors, $values,  $column, $validator, $error){
        if (array_key_exists($column, $values)){
            if (!$validator($values[$column])){
                $errors[$column] = $error;
            }
        }
    }

    public static function validate_author($columns_values): array {
        $result = array();

        static::validate_value($result, $columns_values, 'first_name', function($value): bool {
            return strlen($value) >= 2 && strlen($value) <= 50;
        }, "Имя должно быть длинной от 2 до 50 символов");

        static::validate_value($result, $columns_values, 'second_name', function($value): bool {
            return strlen($value) >= 2 && strlen($value) <= 50;
        }, "Фамилия должна быть длинной от 2 до 50 символов");

        return $result;
    }

    public static function validate_books($columns_values): array {
        $result = array();

        static::validate_value($result, $columns_values, 'name', function($value): bool {
            return strlen($value) >= 2 && strlen($value) <= 50;
        }, "Название должно быть длинной от 2 до 50 символов");

        static::validate_value($result, $columns_values, 'description', function($value): bool {
            return strlen($value) >= 2 && strlen($value) <= 200;
        }, "Описание должно быть длинной от 2 до 200 символов");

        static::validate_value($result, $columns_values, 'cost', function($value): bool {
            return is_int($value) && ((int) $value) >= 1;
        }, "Фамилия должна быть не меньше 1");

        return $result;
    }
}
