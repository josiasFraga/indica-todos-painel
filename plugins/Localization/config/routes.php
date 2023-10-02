<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Localization',
    ['path' => '/localization'],
    function (RouteBuilder $routes) {
    	// Extension JSON
		$routes->setExtensions(['json']);

		// Extend resources
		$routes->resources('Cidades');

        $routes->fallbacks(DashedRoute::class);
    }
);
