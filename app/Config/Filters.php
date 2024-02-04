<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' => \CodeIgniter\Filters\Honeypot::class,
		'cors' => \Fluent\Cors\Filters\CorsFilter::class,
		'apiKey' => \App\Filters\ApiKeyFilter::class,
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			//'honeypot'
			// 'csrf',
		],
		'after'  => [
			'toolbar',
			//'honeypot'
		],
	];
	/*
	public $response = [
		'headers' => [
			'Access-Control-Allow-Origin' => ['*'],
			'Access-Control-Allow-Methods' => ['GET', 'POST', 'OPTIONS', 'PUT', 'DELETE'],
			'Access-Control-Allow-Headers' =>
			[
				'X-Requested-With',
				'Content-Type',
				'Origin',
				'Authorization',
				'Accept',
				'X-API-Key'
			],
			'Access-Control-Allow-Credentials' => false,
			//'Access-Control-Max-Age' => 86400,
		],
	];
	*/

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],

	public $filters = [
		// ...
		'cors' => [
			'before' => ['api/*'],
			'after' => ['
			/*']
		],
		'apiKey' => ['before' => ['api/*']],

	];
}
