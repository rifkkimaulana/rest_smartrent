<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

$routes->group('api', ['filter' => 'cors'], function ($routes) {
	// Dashboard Segment
	$routes->resource('transaksi', ['namespace' => 'App\Controllers\Api']);
	$routes->resource('pembayaran', ['namespace' => 'App\Controllers\Api']);
	$routes->resource('users', ['namespace' => 'App\Controllers\Api']);
	$routes->resource('riwayat', ['namespace' => 'App\Controllers\Api']);

	// UI User
	$routes->resource('produk', ['namespace' => 'App\Controllers\Api']);

	// Pengaturan Segment
	$routes->resource('daftar_bank', ['namespace' => 'App\Controllers\Api\Pengaturan']);
	$routes->resource('bank', ['namespace' => 'App\Controllers\Api\Pengaturan']);

	// Segment Inventaris
	$routes->resource('inventaris', ['namespace' => 'App\Controllers\Api\Inventaris']);
	$routes->resource('kategori', ['namespace' => 'App\Controllers\Api\Inventaris']);

	// Segment Perjalanan
	$routes->resource('destinasi', ['namespace' => 'App\Controllers\Api\Perjalanan']);
	$routes->resource('kategori_perjalanan', ['namespace' => 'App\Controllers\Api\Perjalanan']);
	$routes->resource('paket_perjalanan', ['namespace' => 'App\Controllers\Api\Perjalanan']);
	$routes->resource('pemesanan_perjalanan', ['namespace' => 'App\Controllers\Api\Perjalanan']);
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
