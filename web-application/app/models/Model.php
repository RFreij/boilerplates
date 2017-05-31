<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 22-5-2017
 * Time: 09:14
 */

namespace app\models;

use \PDO;

class Model {

	protected $db;
	public $message;
	
	function __construct( $services ) {
	
		$this->db = $services['db'];
		$this->message = $services['message'];
		
		
	}
	
	public function fetchAllData( $table ) {
		
		$sql = "SELECT * FROM `" . $table . "`";
		$statement = $this->db->prepare( $sql );
		
		$result = $statement->execute();
		
		return $this->returnData( $statement, $result );
		
	}
	
	/*
	 * param String table: naam tabel ( enkelvoud van Class )
	 * param Integer id: id dat in controller gevalideerd is met filter_input
	 */
	public function fetchDataWithId( $table, $id ) {
		
		$sql = "SELECT * FROM `" . $table . "` WHERE `id` = :id";
		$statement = $this->db->prepare( $sql );
		$statement->bindValue( ":id", $id, PDO::PARAM_INT );
		
		$result = $statement->execute();
		
		return $this->returnData( $statement, $result );
		
	}
	
	public function deleteData( $table, $id ) {
		
		$sql = "SELECT * FROM `" . $table . "` WHERE `id` = :id";
		$statement = $this->db->prepare( $sql );
		
		$statement->bindValue( ":id", $id, PDO::PARAM_INT );
		
		$result = $statement->execute();
		
		$data = $this->returnData( $statement, $result );
		
		if ( count( $data ) > 0 ) {
			
			$sql = "DELETE FROM `" . $table . "` WHERE `id` = :id";
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