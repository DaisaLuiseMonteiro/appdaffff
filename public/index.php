<?php
require_once "../vendor/autoload.php";
require_once "../app/config/bootstrap.php";
 use App\Core\Router;

header('Content-Type: application/json; charset=UTF-8');

set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function($exception) {
    http_response_code(500);
    echo json_encode([
        'data' => null,
        'statut' => 'error',
        'code' => 500,
        'message' => 'Erreur serveur: ' . $exception->getMessage()
    ], JSON_UNESCAPED_UNICODE);
});

try {
    

    Router::resolve();
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'data' => null,
        'statut' => 'error',
        'code' => 500,
        'message' => 'Erreur d\'initialisation: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

// echo "helllo world"; 