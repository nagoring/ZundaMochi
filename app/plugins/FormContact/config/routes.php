<?php
use Cake\Routing\Router;

Router::plugin('FormContact', function ($routes) {
//    $routes->fallbacks('InflectedRoute');
    $routes->fallbacks('DashedRoute');
});
