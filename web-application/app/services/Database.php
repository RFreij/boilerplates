<?php

/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 18-4-2017
 * Time: 11:05
 */

namespace app\services;

use \PDO;

class Database {
	
	public $db;
	
	function __construct() {

		$envLoader = new EnvLoader();
		$driver = $envLoader->getVariable("DB_CONNECTION");
		$host = $envLoader->getVariable( "DB_HOST");
		$table = $envLoader->getVariable("DB_TABLE");
		$port = $envLoader->getVariable("DB_PORT");
		$username = $envLoader->getVariable("DB_USERNAME");
		$password = $envLoader->getVariable("DB_PASSWORD");
		$dsn = $driver . ":host=" . $host . ";port= " . $port . ";dbname=" . $table;
		
		
		try {
			
			$this->db = new PDO( $dsn, $username, $password, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ] );
			
		}
		catch ( \PDOException $exception ) {
			die( $exception );
		}
		
	}
	
}