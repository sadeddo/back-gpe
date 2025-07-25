<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/register' => [[['_route' => 'api_register', '_controller' => 'App\\Controller\\AuthController::register'], null, ['POST' => 0], null, false, false, null]],
        '/api/login' => [[['_route' => 'api_login', '_controller' => 'App\\Controller\\AuthController::login'], null, ['POST' => 0], null, false, false, null]],
        '/api/guest' => [[['_route' => 'api_guest', '_controller' => 'App\\Controller\\AuthController::guest'], null, ['POST' => 0], null, false, false, null]],
        '/api/favorites/locations' => [
            [['_route' => 'get_user_favorites', '_controller' => 'App\\Controller\\FavoriteLocationController::list'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'add_favorite_location', '_controller' => 'App\\Controller\\FavoriteLocationController::add'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/favorites/pois' => [
            [['_route' => 'get_user_favorite_pois', '_controller' => 'App\\Controller\\FavoritePoiController::list'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'add_favorite_poi', '_controller' => 'App\\Controller\\FavoritePoiController::add'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/locations/nearby' => [[['_route' => 'api_locations_nearby', '_controller' => 'App\\Controller\\LocationController::nearby'], null, ['GET' => 0], null, false, false, null]],
        '/api/me' => [
            [['_route' => 'get_me', '_controller' => 'App\\Controller\\UserController::getMe'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'update_me', '_controller' => 'App\\Controller\\UserController::updateMe'], null, ['PUT' => 0], null, false, false, null],
            [['_route' => 'delete_me', '_controller' => 'App\\Controller\\UserController::deleteMe'], null, ['DELETE' => 0], null, false, false, null],
        ],
        '/api/test-location' => [[['_route' => 'test_location', '_controller' => 'App\\Controller\\UserController::testLocation'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api/(?'
                    .'|favorites/(?'
                        .'|locations/([^/]++)(*:81)'
                        .'|pois/([^/]++)(*:101)'
                    .')'
                    .'|locations/([^/]++)/pois(*:133)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        81 => [[['_route' => 'remove_favorite_location', '_controller' => 'App\\Controller\\FavoriteLocationController::remove'], ['id'], ['DELETE' => 0], null, false, true, null]],
        101 => [[['_route' => 'remove_favorite_poi', '_controller' => 'App\\Controller\\FavoritePoiController::remove'], ['id'], ['DELETE' => 0], null, false, true, null]],
        133 => [
            [['_route' => 'get_location_pois', '_controller' => 'App\\Controller\\PoiController::list'], ['id'], ['GET' => 0], null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
