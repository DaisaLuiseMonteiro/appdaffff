<?php

namespace App\Core;
class Session {


    private static ?Session  $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public static function set(string $key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, $value) {
        return $_SESSION[$key][$value];
    }

    public static function unset(string $key) {
        unset($_SESSION[$key]);
    }

    public static function isset($key){
        return isset($_SESSION[$key]);
    }
    public static function destroy(){
        session_destroy();
    }
}