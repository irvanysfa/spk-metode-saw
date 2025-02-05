<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->post('/register/process', 'Auth::processRegister');

$routes->get('/login', 'Auth::login');
$routes->post('/login/process', 'Auth::processLogin');
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/siswa', 'SiswaController::index');
    $routes->get('/siswa/create', 'SiswaController::create');
    $routes->post('/siswa/store', 'SiswaController::store');
    $routes->get('/siswa/edit/(:num)', 'SiswaController::edit/$1');
    $routes->post('/siswa/update/(:num)', 'SiswaController::update/$1');
    $routes->get('/siswa/delete/(:num)', 'SiswaController::delete/$1');
    $routes->get('/siswa/edit-nilai/(:num)', 'SiswaController::editNilai/$1');
    $routes->post('/siswa/update-nilai', 'SiswaController::updateNilai');

    $routes->get('/kriteria', 'Kriteria::index');
    $routes->get('/kriteria/create', 'Kriteria::create');
    $routes->post('/kriteria/save', 'Kriteria::save');
    $routes->get('/kriteria/edit/(:num)', 'Kriteria::edit/$1');
    $routes->post('/kriteria/update/(:num)', 'Kriteria::update/$1');
    $routes->get('/kriteria/delete/(:num)', 'Kriteria::delete/$1');

    $routes->get('/nilai', 'Nilai::index');
    $routes->get('/nilai/create', 'Nilai::create');
    $routes->post('/nilai/store', 'Nilai::store');
    $routes->get('/nilai/edit/(:num)', 'Nilai::edit/$1');
    $routes->post('/nilai/update/(:num)', 'Nilai::update/$1');
    $routes->get('/nilai/delete/(:num)', 'Nilai::delete/$1');

    $routes->get('/perhitungan', 'PerhitunganController::index');

    $routes->get('/hasil', 'HasilController::index');
    $routes->get('/hasil/print_pdf', 'HasilController::print_pdf');
    $routes->post('hasil/deleteByKelas', 'HasilController::deleteByKelas');

});

$routes->get('/logout', 'Auth::logout');
