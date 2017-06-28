<?php

/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 18-4-2017
 * Time: 11:05
 */

namespace app\services;

use app\services\querybuilder\QueryBuilder;
use \PDO;

class Database {
	
	private $host = DB_HOST;
	private $user = DB_USERNAME;
	private $pass = DB_PASSWORD;
	private $dbName = DB_NAME;
	private $driver = DB_CONNECTION;
	private $port = DB_PORT;
	
	private $dbh;
	/** @var  \PDOStatement */
	private $stmt;
	
	function __construct() {
		
		$dsn     = $this->driver . ":host=" . $this->host . ";port= " . $this->port . ";dbname=" . $this->dbName;
		$options = [
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION
		];
		
		try {
			$this->dbh = new PDO( $dsn, $this->user, $this->pass, $options );
		}
		catch ( \PDOException $e ) {
			$message = new Message();
			$message->createDatabaseError();
		}
		
	}
	
	public function query( $query ) {
		
		$this->stmt = $this->dbh->prepare( $query );
	}
	
	public function bind( $param, $value, $type = null ) {
		
		if ( is_null( $type ) ) {
			switch ( true ) {
				case is_int( $value ) :
					$type = PDO::PARAM_INT;
					break;
				case is_bool( $value ) :
					$type = PDO::PARAM_BOOL;
					break;
				case is_null( $value ) :
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
					break;
			}
		}
		$this->stmt->bindValue( $param, $value, $type );
	}
	
	public function all() {
		
		$this->execute();
		return $this->stmt->fetchAll( PDO::FETCH_ASSOC );
	}
	
	public function execute() {
		
		return $this->stmt->execute();
	}
	
	public function single() {
		$this->execute();
		return $this->stmt->fetch( PDO::FETCH_ASSOC );
	}
	
	public function countRows() {
		return $this->stmt->rowCount();
	}
	
	public function lastId() {
		return $this->dbh->lastInsertId();
	}
	
	public static function table( $tablename ) {
		return new QueryBuilder( $tablename );
	}
	
}