<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 1-10-2017
 * Time: 09:57
 */

namespace app\services;

use app\services\libraries\MessageType;
use app\services\support\Str;

abstract class BaseModel {
    
    protected static $table;
    
    protected static $rules;
    
    protected static $columns;
    
    public function __construct() {
        self::$table = ( self::$table != "" ) ? self::$table : Str::snake( (new \ReflectionClass($this))->getShortName() . 's' );
    }
    
    public static function all() {
        Database::table( self::$table )
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
            Message::createMessage(MessageType::Error,
                    "Er is geen waarde verwijdert, mogelijk is er wat verkeerd gegaan in de database of bestaat het opgegeven ID niet.");
        }
    }
    
}