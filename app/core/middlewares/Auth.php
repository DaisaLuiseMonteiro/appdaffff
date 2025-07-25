<?php

namespace App\Core\Middlewares;

class Auth{
    public function __invoke(){
        if(!isset($_SESSION['user'])){
            header('Location: /');
            exit();
        }
    }
}