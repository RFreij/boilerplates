<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 22-5-2017
 * Time: 13:25
 */

namespace app\services;

use app\services\libraries\MessageType;

class Message {
	
	private $messages = [];
	
	public function __construct () {
		
		/*
		 * If session has messages add them to message array
		 */
		if ( ! empty( $_SESSION[ 'messages' ] ) ) {
			$this->messages = $_SESSION[ 'messages' ];
		}
		
	}
	
	public function createMessage ( $type, $message ) {
		
		/*
		 * Add new message to array
		 */
		$this->messages[] = [
				"type"    => $type,
				"message" => $message
		];
		
		/*
		 * Synchronize messages session
		 */
		$_SESSION[ 'messages' ] = $this->messages;
		
	}
	
	public function createDatabaseError () {
		
		/*
		 * Create default message when something is going wrong in the database so the user does not see unexplaineble errors
		 */
		$this->createMessage(
				MessageType::Error,
				"Er is iets mis gegaan bij het bijwerken van de database."
		);
		
	}
	
	/**
	 * @return array
	 */
	public function getMessages () {
		
		return $this->messages;
		
	}
	
	/**
	 * @return array
	 */
	public function getErrors () {
		
		$errors = [];
		
		foreach ( $this->messages as $message ) {
			
			if ( $message[ 'type' ] == MessageType::Error ) {
				$errors[] = $message[ 'message' ];
			}
			
		}
		
		return $errors;
		
	}
	
	/**
	 * @return array
	 */
	public function getSuccess () {
		
		$success = [];
		
		foreach ( $this->messages as $message ) {
			
			if ( $message[ 'type' ] == MessageType::Success ) {
				$success[] = $message[ 'message' ];
			}
			
		}
		
		return $success;
		
	}
	
	/**
	 * @return array
	 */
	public function getNotifications () {
		
		$notifications = [];
		
		foreach ( $this->messages as $message ) {
			
			if ( $message[ 'type' ] == MessageType::Notification ) {
				$notifications[] = $message[ 'message' ];
			}
			
		}
		
		return $notifications;
		
	}
	
	public function clear () {
		
		unset( $_SESSION[ 'messages' ] );
		
	}
}