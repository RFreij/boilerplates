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
use app\services\Database;
use app\services\libraries\MessageType;
use app\services\Message;

class Model {
	
	/** @var  Database */
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
		
		Database::table( $this::TABLENAME )
			->select( [
					"*"
			] )
			->execute();

		
		return Database::all();
		
	}
	
	/**
	 * @param $id
	 *
	 * @return array|mixed
	 */
	public function fetchSingle( $id ) {
		
		Database::table( $this::TABLENAME )
			->select([
					"*"
			])
			->where( "id", ":id" )
			->addPlaceholder([
					":id"
			])
			->addValue( [
					$id
			])
			->execute();
		
		return Database::single();
		
	}
	
	/**
	 * @param $id
	 */
	public function delete( $id ) {
		
		Database::table( $this::TABLENAME )
			->delete()
			->addColumn( "id" )
			->addPlaceholder( ":id" )
			->addValue( $id )
			->execute();
			
		if ( Database::affectedRows() > 0 ) {
			$this->message->createMessage( MessageType::Success, "Data succesvol verwijdert" );
		}
		else {
			$this->message->createMessage( MessageType::Error, "Er is geen waarde verwijdert, mogelijk is er wat verkeerd gegaan in de database of bestaat het opgegeven ID niet." );
		}
		
	}
	
}