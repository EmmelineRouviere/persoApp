<?php 

class ErrorHandler {
    
    private static $errors = [];

    public static function addError($code, $message) {
        self::$errors[$code] = $message;
    }

    public static function getErrors() {
        return self::$errors;
    }

    public static function hasErrors() {
        return !empty(self::$errors);
    }

    public static function clearErrors() {
        self::$errors = [];
    }
}
