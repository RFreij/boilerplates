<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 22-5-2017
 * Time: 09:20
 */

$router->add( '/web-application', 'TestController@sdf');
$router->add( '/web-application/test', 'TestController@view');
$router->add( '/web-application/test/{id}', 'TestController@view');