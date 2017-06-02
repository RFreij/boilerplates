<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 22-5-2017
 * Time: 09:20
 */

$routes[] = [
	"path" => "/web-application/test/{id}",
	"controller" => "FallbackController",
	"action" => "index"
];

$routes[] = [
	"path" => "/web-application/testing/test/{id}",
	"controller" => "FallbackController",
	"action" => "index"
];

$routes[] = [
	"path" => "/web-application/testing/test",
	"controller" => "FallbackController",
	"action" => "index"
];