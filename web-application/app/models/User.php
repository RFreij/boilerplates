<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 2-6-2017
 * Time: 23:47
 */

namespace app\models;

use app\services\libraries\MessageType;
use app\services\libraries\UserType;
use \PDO;

class User extends Model {
	
	const TABLENAME = "users";
	
	private $username;
	private $admin = false;
	
	public function setUsername( $username ) {
		$this->username = $username;
	}
	
	public function isAdmin() {
		return ( $this->admin == true ) ? true : false;
	}
	
	public function isLoggedIn() {
		return ( $_SESSION['user']['logged_in'] == true ) ? true : false;
	}
	
	public function getUser() {
		
		$sql = "SELECT * FROM `" . $this::TABLENAME . "` WHERE `username` = :username";
		$statement = $this->db->prepare( $sql );
		
		$statement->bindvalue( ":username", $this->username, PDO::PARAM_STR );
		
		$result = $statement->execute();
		
		if ( $result ) {
			return ( $statement->rowCount() > 0 ) ? $statement->fetch( PDO::FETCH_ASSOC ) : false;
		}
		else {
			$this->message->createMessage( MessageType::Error, "Er is iets fout gegaan bij het ophalen van gegevens uit de database" );
		}
		
		return false;
		
	}
	
}