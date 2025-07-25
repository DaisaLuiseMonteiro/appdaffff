<?php
namespace App\Core;
use App\Core\Singleton;

class Validator  extends Singleton
{
    private static array $errors = [];

    private static array $rules;

    public function __construct()
    {
        self::$errors = [];
        self::$rules = [
            "required" => function ($key, $value, $message) {
                if (empty($value)) {
                    self::addError($key, $message);
                    
                }
            },
            "minLength" => function ($key, $value, $minLength, $message ) {
                if (strlen($value) < $minLength) {
                    self::addError($key, $message);
                }
            },
            "isMail" => function ($key, $value, $message) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    self::addError($key, $message);
                }
            },
            "isPassword" => function ($key, $value, $message) {
                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/', $value)) {
                    self::addError($key, $message);
                }
            },
            "isSenegalPhone" => function ($key, $value, $message) {
                $value = preg_replace('/\D/', '', $value);
                $prefixes = ['70', '75', '76', '77', '78'];
                if (!(strlen($value) === 9 && in_array(substr($value, 0, 2), $prefixes))) {
                    self::addError($key, $message);
                }
            },
            "isCNI" => function ($key, $value, $message) {
                $value = preg_replace('/\D/', '', $value);
                if (!preg_match('/^1\d{12}$/', $value)) {
                    self::addError($key, $message);
                }
            },
        ];
    }

    

    

    public function validate(array $data, array $rules): bool
    {
        self::$errors = [];
        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;
       if($value !== null){
            foreach ($fieldRules as $rule) {
                if(isset(self::$errors[$field])){
                    break;
                }
                if (is_string($rule)) {
                    $callback = self::$rules[$rule] ?? null;
                    if ($callback) {
                        $callback($field, $value);
                    }
                }
                elseif (is_array($rule)) {
                    $ruleName = $rule[0];
                    $params = array_slice($rule, 1);
                    $callback = self::$rules[$ruleName] ?? null;

                    if ($callback) {
                        $callback($field, $value, ...$params);
                    }
                }
            }
        }
        }

        return empty(self::$errors);
    }

    public static function addError(string $field, string $message)
    {
        self::$errors[$field] = $message;
    }

    public static function getErrors()
    {
        return self::$errors;
    }

    
}
