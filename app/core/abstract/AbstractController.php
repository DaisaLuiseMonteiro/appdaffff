<?php

namespace App\Core\Abstract;

use app\core\Singleton;

abstract class AbstractController extends Singleton{
 

    protected   $layout = 'base';

    
    

    abstract public function index();
    // abstract public function create();
    // abstract public function store();
    // abstract public function edit();
    // // abstract public function destroy();
    // abstract public function show();

    

   
    
       public function renderJson($data, $httpCode = 200)
    {
        if (ob_get_level()) {
            ob_clean();
        }
                 
        http_response_code($httpCode);
        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
                         
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
     }
    

}