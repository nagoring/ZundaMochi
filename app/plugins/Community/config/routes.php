<?php
use Cake\Routing\Router;

Router::plugin('Community', function ($routes) {
//    $routes->fallbacks('InflectedRoute');
    $routes->fallbacks('DashedRoute');
});
