<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 18-4-2017
 * Time: 14:36
 */

namespace app\services;


class EnvLoader {
	
	private $envVariables = [];
	
	public function __construct() {
	
		$envFile = ".env";
		if ( file_exists( $envFile ) ) {
			
			$envFile = file( ".env" );
			
			foreach ( $envFile as $en ) {
				
				$expl = explode( '=', $en );
				$this->envVariables[trim($expl[0])] = trim($expl[1]);
				
			}
			
		}
		
	}
	
	public function getVariable( $variable ) {
		
		if ( key_exists( $variable, $this->envVariables ) ) {
			return $this->envVariables[$variable];
		}
		else {
			return null;
		}
		
	}
	
}