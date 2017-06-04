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
use app\services\Database;
use app\services\libraries\MessageType;
use app\services\Message;
use \PDO;

class Model {
	
	/** @var  PDO */
	protected $db;
	/** @var ServiceLoader */
	protected $loader;
	/** @var Message */
	public $message;
	/** @var Authenticate */
	public $auth;
	
	const TABLENAME = "";
	
	/**
	 * Model constructor.
	 *
	 * @param ServiceLoader $load
	 */
	function __construct ( ServiceLoader $load ) {
		
		$this->db      = $load->get( 'Database' )->db;
		$this->message = $load->get( 'Message' );
		$this->auth    = $load->get( 'Authenticate' );
		$this->loader  = $load;
		
	}
	
	/**
	 * @return array|mixed
	 */
	public function fetchAll () {
		
		$sql       = "SELECT * FROM `" . $this::TABLENAME . "`";
		$statement = $this->db->prepare( $sql );
		
		$result = $statement->execute();
		
		return $this->returnData( $statement, $result );
		
	}
	
	/**
	 * @param $id
	 *
	 * @return array|mixed
	 */
	public function fetchSingle ( $id ) {
		
		$sql       = "SELECT * FROM `" . $this::TABLENAME . "` WHERE `id` = :id";
		$statement = $this->db->prepare( $sql );
		$statement->bindValue( ":id", $id, PDO::PARAM_INT );
		
		$result = $statement->execute();
		
		return $this->returnData( $statement, $result );
		
	}
	
	/**
	 * @param $id
	 */
	public function delete ( $id ) {
		
		$sql       = "SELECT * FROM `" . $this::TABLENAME . "` WHERE `id` = :id";
		$statement = $this->db->prepare( $sql );
		
		$statement->bindValue( ":id", $id, PDO::PARAM_INT );
		$result = $statement->execute();
		
		if ( $statement->rowCount() > 0 ) {
			
			$sql       = "DELETE FROM `" . $this::TABLENAME . "` WHERE `id` = :id";
			$statement = $this->db->prepare( $sql );
			
			$statement->bindValue( ":id", $id, PDO::PARAM_INT );
			$result = $statement->execute();
			
			if ( $result ) {
				$this->message->createMessage( MessageType::Success, "Data succesvol verwijdert" );
			}
			else {
				$this->message->createMessage( MessageType::Error, "Er is iets mis gegaan bij het bijwerken van de database tijdens het verwijderen. " );
			}
			
		}
		else {
			$this->message->createMessage( MessageType::Notification, "Er zijn geen gegevens gevonden met het opgegeven ID" );
		}
		
	}
	
	/**
	 * @param \PDOStatement $statement
	 * @param               $result
	 * @param bool          $single
	 *
	 * @return array|mixed
	 */
	private function returnData ( \PDOStatement $statement, $result, $single = false ) {
		
		$data = [];
		
		if ( $result ) {
			if ( $single ) {
				$data = $statement->fetch( PDO::FETCH_ASSOC );
			}
			else {
				$data = $statement->fetchAll( PDO::FETCH_ASSOC );
			}
		}
		
		return $data;
		
	}
	
	/**
	 * @param $sql
	 *
	 * @return bool|mixed
	 */
	public function executeSafeQuery ( $sql ) {
		
		$statement = $this->db->prepare( $sql );
		$result    = $statement->execute();
		
		if ( $result ) {
			return $statement->fetch( PDO::FETCH_ASSOC );
		}
		else {
			$this->message->createDatabaseError();
		}
		
		return false;
		
	}
	
}