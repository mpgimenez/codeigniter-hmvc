<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


// Rotas para User
$routes->group('users', ['namespace' => 'App\Modules\User\Controllers'], function($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('login', 'UserController::login');
    $routes->post('login', 'UserController::login');

    $routes->get('create', 'UserController::create');
    $routes->post('addOrEdit', 'UserController::addOrEdit');
    $routes->delete('remove/(:num)', 'ClientController::remove/$1');
    $routes->get('list', 'UserController::listAll');

});

$routes->group('clients', ['namespace' => 'App\Modules\Client\Controllers'], function($routes) {
    $routes->get('/', 'ClientController::index'); 
    $routes->get('list', 'ClientController::listAll');
    $routes->post('add', 'ClientController::add'); 
    $routes->delete('remove/(:num)', 'ClientController::remove/$1');
});
