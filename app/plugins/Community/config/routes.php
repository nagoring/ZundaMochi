<?php
use Cake\Routing\Router;

Router::plugin('Community', function ($routes) {
//    $routes->fallbacks('InflectedRoute');
//    $routes->connect('/', ['controller' => 'Communities', 'action' => 'index', 'Plugin' => 'Community']);
    $routes->fallbacks('DashedRoute');
});

Router::scope('/m', ['plugin' => 'Community'], function ($routes) {
    $routes->connect(
		'/co:id', 
		['controller' => 'Communities', 'action' => 'view'],
		[
			'pass' => 'id',
			':id' => '[0-9]+',
		]
	);
});
