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


    $routes->group('kriteria', function($routes) {
    $routes->get('/', 'KriteriaController::index');
    $routes->post('getData', 'KriteriaController::getData');
    $routes->post('store', 'KriteriaController::store');
    $routes->get('show/(:num)', 'KriteriaController::show/$1');
    $routes->post('update/(:num)', 'KriteriaController::update/$1');
    $routes->delete('delete/(:num)', 'KriteriaController::delete/$1');
    });

    $routes->group('subkriteria', function($routes) {
        $routes->get('/', 'SubKriteria::index');
        $routes->post('getData', 'SubKriteria::getData');
        $routes->get('getKriteriaOptions', 'SubKriteria::getKriteriaOptions');
        $routes->post('store', 'SubKriteria::store');
        $routes->get('show/(:num)', 'SubKriteria::show/$1');
        $routes->post('update/(:num)', 'SubKriteria::update/$1');
        $routes->delete('delete/(:num)', 'SubKriteria::delete/$1');
    });

    // Add these routes to your app/Config/Routes.php file

    $routes->group('alternatif', function($routes) {
        $routes->get('/', 'Alternatif::index');
        $routes->post('getData', 'Alternatif::getData');
        $routes->post('store', 'Alternatif::store');
        $routes->get('show/(:num)', 'Alternatif::show/$1');
        $routes->post('update/(:num)', 'Alternatif::update/$1');
        $routes->delete('delete/(:num)', 'Alternatif::delete/$1');
        $routes->get('getKriteria', 'Alternatif::getKriteria');
        $routes->get('getSubKriteria/(:any)', 'Alternatif::getSubKriteria/$1');
        $routes->get('getNextKode', 'Alternatif::getNextKode');
    });


    // Add these routes to your existing Routes.php file

$routes->group('preferensi', function($routes) {
    $routes->get('/', 'Preferensi::index');
    $routes->post('getData', 'Preferensi::getData');
    $routes->post('store', 'Preferensi::store');
    $routes->get('show/(:num)', 'Preferensi::show/$1');
    $routes->post('update/(:num)', 'Preferensi::update/$1');
    $routes->delete('delete/(:num)', 'Preferensi::delete/$1');
    $routes->get('getKriteriaOptions', 'Preferensi::getKriteriaOptions');
    $routes->get('getTotalBobot', 'Preferensi::getTotalBobot');
});

// Route untuk Data Perhitungan (jika belum ada)
// Route baru (gunakan controller)
$routes->get('data_perhitungan', 'DataPerhitunganController::index');