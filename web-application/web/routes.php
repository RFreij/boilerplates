<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 22-5-2017
 * Time: 09:20
 */
//Example
$router->get( '/web-application/', 'AppController');
$router->get( '/web-application/{id}', 'AppController@show');
$router->get( '/web-application/edit/{id}', 'AppController@edit');
$router->get('/web-application/create', 'AppController@create');
$router->post( '/web-application/', 'AppController');
$router->put( '/web-application/', 'AppController');
$router->delete('/web-application/{id}', 'AppController');

$router->get('/web-application/', 'AppController');