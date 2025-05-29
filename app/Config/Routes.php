<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Auth::login');

// Auth routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->get('register', 'Auth::register');
    $routes->post('attempt-login', 'Auth::attemptLogin');
    $routes->post('attempt-register', 'Auth::attemptRegister');
    $routes->get('logout', 'Auth::logout');
    $routes->post('logout', 'Auth::logout');
});

// Dashboard (protected)
$routes->get('dashboard', 'Auth::dashboard');



    $routes->get('/profile', 'Profile::index');
    $routes->post('/profile/update', 'Profile::update');
    $routes->post('/profile/change-password', 'Profile::changePassword');

//     $routes->get('profile', 'Profile::index');
// $routes->post('profile/update', 'Profile::update');
// $routes->post('profile/change-password', 'Profile::changePassword');
