<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 22-5-2017
 * Time: 10:45
 */

namespace app\controllers;

class FallbackController extends Controller {
	
	/**
	 * @param $url
	 */
	public function index ( $url ) {
		
		header( "HTTP/1.0 404 Not Found" );
		$stack[ 'title' ] = "404 - not found";
		$stack[ 'url' ]   = $url;
		
		$this->render( 'static.404', $stack );
		
	}
	
}