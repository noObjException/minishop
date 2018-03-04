<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group([
    'namespace' => 'v1',
    'prefix'    => 'v1'
], function (Router $router) {

    $router->get('homes', 'HomeController@index');

    $router->group([
        'namespace' => 'Good',
    ], function (Router $router) {
        $router->apiResource('goods', 'GoodController');
        $router->apiResource('good/categories', 'CategoryController');
        $router->apiResource('good/themes', 'ThemeController');
    });

    $router->group([
        'namespace' => 'Auth'
    ], function(Router $router) {
        $router->post('token', 'AuthController@token');
        $router->post('register', 'AuthController@register');
    });

    $router->group([
        'namespace' => 'Order',
        'middleware' => 'auth:api'
    ], function(Router $router) {
        $router->apiResource('orders', 'OrderController');
    });

    $router->group([
        'namespace' => 'User',
        'middleware' => 'auth:api'
    ], function (Router $router) {
        $router->apiResource('users', 'UserController');
        $router->apiResource('user/orders', 'OrderController');
    });

//    $router->group([
//        'namespace' => 'Setting',
//    ], function (Router $router) {
//        //        $router->apiResource('advertises', 'AdvertiseController');
//        //        $router->apiResource('carousels', 'CarouselController');
//        //        $router->apiResource('navMenus', 'NavMenuController');
//    });
});
