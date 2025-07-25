<?php

use App\Controller\CitoyenController;

$routes = [
    'GET:/api/citoyens' => [
        'controller' => CitoyenController::class,
        'method' => 'index',
    ]
    // ,

    // 'GET:/api/citoyens/{id}' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'show',
    //     'middlewares' => ['auth']
    // ],

    // 'POST:/api/citoyens' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'store',
    //     'middlewares' => ['auth']
    // ],

    // 'PUT:/api/citoyens/{id}' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'update',
    //     'middlewares' => ['auth']
    // ],

    // 'DELETE:/api/citoyens/{id}' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'destroy',
    //     'middlewares' => ['auth']
    // ],

    // 'GET:/api/citoyens/search' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'search',
    //     'middlewares' => ['auth']
    // ],

    // 'GET:/api/citoyens/search/{critere}' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'searchBy',
    //     'middlewares' => ['auth']
    // ],

    // // Routes de filtrage
    // 'GET:/api/citoyens/filter/status/{status}' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'filterByStatus',
    //     'middlewares' => ['auth']
    // ],

    // 'GET:/api/citoyens/filter/region/{region}' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'filterByRegion',
    //     'middlewares' => ['auth']
    // ],

    // // Routes de statistiques
    // 'GET:/api/citoyens/stats' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'getStats',
    //     'middlewares' => ['auth']
    // ],

    // 'GET:/api/citoyens/count' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'count',
    //     'middlewares' => ['auth']
    // ],

    // // Routes de validation
    // 'POST:/api/citoyens/validate' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'validate',
    //     'middlewares' => ['auth']
    // ],

    // // Routes d'export
    // 'GET:/api/citoyens/export/csv' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'exportCsv',
    //     'middlewares' => ['auth']
    // ],

    // 'GET:/api/citoyens/export/pdf' => [
    //     'controller' => CitoyenController::class,
    //     'method' => 'exportPdf',
    //     'middlewares' => ['auth']
    // ],

    // // Route de health check
    // 'GET:/api/health' => [
    //     'controller' => SecurityController::class,
    //     'method' => 'healthCheck'
    // ],

    // // Route pour les options CORS
    // 'OPTIONS:/api/{path}' => [
    //     'controller' => SecurityController::class,
    //     'method' => 'handleOptions'
    // ]
];