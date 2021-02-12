<?php

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

use App\Http\Controllers\UsuarioController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group([], function () use ($router) {
        $router->get('/usuarios',  ['uses' => 'UsuarioController@index', 'as' => 'usuarios']);
        $router->get('/usuarios/{id}', ['uses' => 'UsuarioController@show']);
        $router->post('/usuarios', ['uses' => 'UsuarioController@store']);
        $router->delete('/usuarios/{id}', ['uses' => 'UsuarioController@destroy']);
        $router->put('/usuarios/{id}', ['uses' => 'UsuarioController@update']);
        $router->post('/usuarios/{id}/roles', ['uses' => 'UsuarioController@attachRoles']);
    });

});
