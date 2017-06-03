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
use app\services\Authenticate;
use app\services\libraries\MessageType;
use app\services\Message;
use \PDO;

class Model {
	
	private $user;
	protected $db;
	protected $auth;
	public $message;
	
	const TABLENAME = "";
	
	function __construct( ServiceLoader $load ) {
	
		$this->db = $load->get('Database')->db;
		$this->message = $load->get('Message');
		$this->auth = $load->get('Authenticate');
		
		if ( isset( $_SESSION['user'] ) && is_object( $_SESSION['user'] ) ) {
			$this->user = $_SESSION['user'];
		}
		
	}
	
	public function getUser() {
		return ( isset( $this->user ) && is_a( $this->user, "User" ) ) ? $this->user : false;
	}
	
	public function fetchAll() {
		
		$sql = "SELECT * FROM `" . $this::TABLENAME . "`";
		$statement = $this->db->prepare( $sql );
		
		$result = $statement->execute();
		
		return $this->returnData( $statement, $result );
		
	}
	
	/*
	 * param String table: naam tabel ( enkelvoud van Class )
	 * param Integer id: id dat in controller gevalideerd is met filter_input
	 */
	public function fetchSingle( $id ) {
		
		$sql = "SELECT * FROM `" . $this::TABLENAME . "` WHERE `id` = :id";
		$statement = $this->db->prepare( $sql );
		$statement->bindValue( ":id", $id, PDO::PARAM_INT );
		
		$result = $statement->execute();
		
		return $this->returnData( $statement, $result );
		
	}
	
	public function delete( $id ) {
		
		$sql = "SELECT * FROM `" . $this::TABLENAME . "` WHERE `id` = :id";
		$statement = $this->db->prepare( $sql );
		
		$statement->bindValue( ":id", $id, PDO::PARAM_INT );
		
		$result = $statement->execute();
		
		if ( $statement->rowCount() > 0 ) {
			
			$sql = "DELETE FROM `" . $this::TABLENAME . "` WHERE `id` = :id";
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
	
	public function executeSafeQuery( $sql ) {
	
		$statement = $this->db->prepare( $sql );
		
		$result = $statement->execute();
		
		if ( $result ) {
			return $statement->fetch( PDO::FETCH_ASSOC );
		}
		else {
			$this->message->createDatabaseError();
		}
	
		return false;
		
	}
	
}