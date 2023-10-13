<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;

return static function (RouteBuilder $routes) {
    $routes->plugin(
        'Localization',
        ['path' => '/localization'],
        function (RouteBuilder $builder) {
            $builder->setExtensions(['json']);
            $builder->resources('Cidades');
            $builder->fallbacks(DashedRoute::class);
        }
    );
};
