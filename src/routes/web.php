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
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'usuarios'], function () use ($router) {
        $router->get('', 'UsuarioController@index');
        $router->post('', 'UsuarioController@store');
        $router->get('{id}', 'UsuarioController@show');
        $router->put('{id}', 'UsuarioController@update');
        $router->delete('{id}', 'UsuarioController@destroy');
    });

    $router->group(['prefix' => 'contas'], function () use ($router) {
        $router->get('', 'ContaController@index');
        $router->post('', 'ContaController@store');
        $router->get('{id}', 'ContaController@show');
    });

    $router->post('deposito', 'OperacaoController@store');
    $router->post('saque', 'OperacaoController@store');
    $router->post('transferencia', 'OperacaoController@store');

    $router->get('extrato/{contaId}', 'ExtratoController@show');
});
