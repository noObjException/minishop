<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->group(['namespace' => 'User'], function (Router $router) {
        $router->resource('users', 'UserController');
        $router->resource('userGroups', 'GroupController');
        $router->resource('userLevels', 'LevelController');
    });

    $router->group(['namespace' => 'Setting'], function (Router $router) {
        $router->resource('carousels', 'CarouselController');
    });

    $router->group(['namespace' => 'Good'], function (Router $router) {
        $router->resource('goods', 'GoodController');
        $router->resource('good/categories', 'CategoryController');
        $router->resource('good/themes', 'ThemeController');
    });

});
