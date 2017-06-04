<?php

/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 18-4-2017
 * Time: 11:05
 */

namespace app\services;

class Autoloader {
	
	function __construct () {
		
		spl_autoload_register( function ( $file ) {
			if ( ! class_exists( $file ) ) {
				$file = str_replace( "\\", "/", $file );
				include $file . '.php';
			}
		} );
		
	}
	
}