<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public storefront catalog
$routes->get('/', 'Catalog::index');
$routes->get('catalog', 'Catalog::index');

// Authentication routes
$routes->get('register', 'Auth::registerView');
$routes->post('register', 'Auth::register');
$routes->get('login', 'Auth::loginView');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// Cart routes
$routes->get('cart', 'Cart::index');
$routes->get('cart/get', 'Cart::get');
$routes->post('cart/add', 'Cart::add');
$routes->post('cart/update', 'Cart::update');
$routes->post('cart/remove', 'Cart::remove');
$routes->post('cart/checkout', 'Cart::checkout');

// Administrative routes (protected via Filters alias adminAuth in Config/Filters.php)
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    // Catalog CRUD actions
    $routes->get('catalog', 'Admin\Catalog::index');
    $routes->post('catalog/add', 'Admin\Catalog::add');
    $routes->post('catalog/edit/(:num)', 'Admin\Catalog::edit/$1');
    $routes->get('catalog/delete/(:num)', 'Admin\Catalog::delete/$1');

    // Orders Control
    $routes->get('orders', 'Admin\Orders::index');
    $routes->get('orders/details/(:num)', 'Admin\Orders::details/$1');
    $routes->post('orders/update-status/(:num)', 'Admin\Orders::updateStatus/$1');
});
