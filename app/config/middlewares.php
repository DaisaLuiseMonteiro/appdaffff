<?php

use App\Core\Middlewares\Auth;
use App\Core\Middlewares\CryptPassword;

$middlewares = [
    'auth' => Auth::class,
    'cryptPassword' => CryptPassword::class,
];

function runMiddleWare($middlewareNames = []) {
    global $middlewares;
    
    if (empty($middlewareNames)) {
        return;
    }
    
    foreach ($middlewareNames as $middlewareName) {
        if (isset($middlewares[$middlewareName])) {
            $middlewareClass = $middlewares[$middlewareName];
            $middleware = new $middlewareClass();
            $middleware();
        }
    }
}