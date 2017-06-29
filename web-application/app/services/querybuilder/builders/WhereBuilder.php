<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 4-6-2017
 * Time: 09:46
 */

namespace app\services\querybuilder\builders;

class WhereBuilder {
	
	protected $query;
	protected $values = [];
	protected $placeholders = [];
	
	public function start() {
		
		return " WHERE ";
	}
	
	public function where( $column, $value, $op = null ) {
		
		$query = "";
		
		if ( $value != null ) {
			
			switch ( $op ) {
				
				case '=':
				case '!=':
				case 'LIKE':
					$query = "{$column} {$op} {$value} ";
					break;
				default:
					$query = "{$column} = {$value} ";
					break;
				
			}
			
		}
		
		return $query;
	}
	
}