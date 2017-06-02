<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 22-5-2017
 * Time: 09:14
 */

namespace app\models;

use app\ServiceLoader;
use \PDO;

class Model {

	protected $db;
	protected $auth;
	public $message;
	protected $tablename;
	
	function __construct( ServiceLoader $loader, $tablename ) {
	
		$this->db = $loader->get('Database');
		$this->message = $loader->get('Message');
		$this->auth = $loader->get('Authenticate');
		$this->tablename = $tablename;
		
	}
	
	public function fetchAll() {
		
		$sql = "SELECT * FROM `" . $this->tablename . "`";
		$statement = $this->db->prepare( $sql );
		
		$result = $statement->execute();
		
		return $this->returnData( $statement, $result );
		
	}
	
	/*
	 * param String table: naam tabel ( enkelvoud van Class )
	 * param Integer id: id dat in controller gevalideerd is met filter_input
	 */
	public function fetchSingle( $id ) {
		
		$sql = "SELECT * FROM `" . $this->tablename . "` WHERE `id` = :id";
		$statement = $this->db->prepare( $sql );
		$statement->bindValue( ":id", $id, PDO::PARAM_INT );
		
		$result = $statement->execute();
		
		return $this->returnData( $statement, $result );
		
	}
	
	public function delete( $id ) {
		
		$sql = "SELECT * FROM `" . $this->tablename . "` WHERE `id` = :id";
		$statement = $this->db->prepare( $sql );
		
		$statement->bindValue( ":id", $id, PDO::PARAM_INT );
		
		$result = $statement->execute();
		
		$data = $this->returnData( $statement, $result );
		
		if ( count( $data ) > 0 ) {
			
			$sql = "DELETE FROM `" . $this->tablename . "` WHERE `id` = :id";
			$statement = $this->db->prepare( $sql );
			
			$statement->bindValue( ":id", $id, PDO::PARAM_INT );
			
			$result = $statement->execute();
			
			if ( $result ) {
				
				$this->message->createMessage( MessageType::Success, "Data succesvol verwijdert" );
				
			}
			else {
				
				$this->message->createMessage( MessageType::Error, "Er is iets mis gegaan bij het bijwerken van de database tijdens het verwijderen. ");
				
			}
			
		}
		else {
			
			$this->message->createMessage( MessageType::Notification, "Er zijn geen gegevens gevonden met het opgegeven ID" );
			
		}
		
	}
	
	public function returnData( \PDOStatement $statement, $result ) {
		
		$data = [];
		
		if ( $result ) {
			
			$data = $statement->fetchAll( PDO::FETCH_ASSOC );
			
		}
		
		return $data;
		
	}
	
}