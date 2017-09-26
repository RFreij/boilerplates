<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 22-5-2017
 * Time: 09:14
 */

namespace app\models;

use app\services\Database;
use app\services\libraries\MessageType;
use app\services\Message;
use app\services\support\Str;

abstract class Model {
 
	protected $table;
	
	public function __construct() {
        $this->table = ( $this->table != "" ) ? $this->table : Str::snake( (new \ReflectionClass($this))->getShortName() );
	}
    
    private function getAll( ) {
        
        $query = Database::table( $this->table )
                ->select( [
                        "*"
                ] )
                ->toString();
        
        return $query;
    }
    
    public static function all() {
        
        $instance = new static;
        
        return $instance->getAll( );
        
    }
	
	/**
	 * @param $id
	 *
	 * @return array|mixed
	 */
	public static function single( $id ) {
		
		Database::table( self::$table )
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
	public static function delete( $id ) {
		
		Database::table( self::$table )
			->delete()
			->addColumn( "id" )
			->addPlaceholder( ":id" )
			->addValue( $id )
			->execute();
			
		if ( Database::affectedRows() > 0 ) {
			Message::createMessage( MessageType::Success, "Data succesvol verwijdert" );
		}
		else {
			Message::createMessage( MessageType::Error, "Er is geen waarde verwijdert, mogelijk is er wat verkeerd gegaan in de database of bestaat het opgegeven ID niet." );
		}
		
	}
	
}