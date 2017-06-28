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
use app\services\Database AS DB;
use app\services\libraries\MessageType;
use app\services\Message;
use \PDO;

class Model {
	
	/** @var  DB */
	protected $db;
	/** @var ServiceLoader */
	protected $loader;
	/** @var Message */
	public $message;
	
	const TABLENAME = "";
	
	/**
	 * Model constructor.
	 *
	 * @param ServiceLoader $load
	 */
	function __construct( ServiceLoader $load ) {
		
		$this->db      = $load->get( 'Database' );
		$this->message = $load->get( 'Message' );
		$this->loader  = $load;
		
	}
	
	/**
	 * @return array|mixed
	 */
	public function fetchAll() {
		
		$this->db->query( "SELECT * FROM `" . $this::TABLENAME . "`" );
		
		return $this->db->fetchAll();
		
	}
	
	/**
	 * @param $id
	 *
	 * @return array|mixed
	 */
	public function fetchSingle( $id ) {
		
		$this->db->query( "SELECT * FROM `" . $this::TABLENAME . "` WHERE `id` = :id" );
		$this->db->bind( ":id", $id );
		
		return $this->db->single();
		
	}
	
	/**
	 * @param $id
	 */
	public function delete( $id ) {
		
		$this->db->query( "SELECT * FROM `" . $this::TABLENAME . "` WHERE `id` = :id" );
		$this->db->bind( ":id", $id );
		
		$this->db->execute();
		
		if ( $this->db->countRows() > 0 ) {
			
			$this->db->query( "DELETE FROM `" . $this::TABLENAME . "` WHERE `id` = :id" );
			
			$this->db->bind(":id", $id );
			$result = $this->db->execute();
			
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
	 * @param $sql
	 *
	 * @return bool|mixed
	 */
	public function executeSafeQuery( $query, $single = false ) {
		
		$result = $this->db->query( $query );
		
		if ( $result ) {
			switch ( $single ) {
				case true:
					return $this->db->single();
					break;
				default:
					return $this->db->all();
					break;
			}
		}
		else {
			$this->message->createDatabaseError();
		}
		
		return false;
		
	}
	
}