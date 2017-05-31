<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 31-5-2017
 * Time: 14:55
 */

namespace app\services;


class Authenticate {
	
	public function checkLoggedIn()
	{
		if ( !isset($_SESSION['loggedIn']) or !$_SESSION['loggedIn'] )
		{
			header( 'Location: ?con=login' );
			die();
		}
	}
	
}