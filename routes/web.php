<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return redirect('shop');
});

$router->get('shop', 'ShopController@index');
$router->post('shop', 'ShopController@store');

$router->get('cart', 'CartController@index');
$router->post('cart', 'CartController@store');
$router->post('cart/submit', 'CartController@submit');
$router->delete('cart/{id}/delete', 'CartController@delete');
$router->delete('cart/cancel', 'CartController@cancel');
