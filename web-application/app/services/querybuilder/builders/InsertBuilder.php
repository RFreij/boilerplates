<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 4-6-2017
 * Time: 09:49
 */

namespace app\services\querybuilder\builders;

use app\services\Database;

class InsertBuilder extends AbstractBuilder {
	
	public function __construct( $tablename ) {
		$this->tablename = $tablename;
		$this->query = "INSERT INTO $tablename ";
	}
	
	public function build() {
		
		$columns = implode(", ", $this->columns);
		$placeholders = implode(", ", $this->placeholders);
		
		$this->query .= " ( $columns ) VALUES ( $placeholders ) ";
		
		if ( !empty( $this->where ) ) {
			$this->query .= $this->where;
		}
		
		if ( !empty( $this->order_by ) ) {
			$this->query .= $this->order_by;
		}
		
		if ( !empty( $this->limit ) ) {
			$this->query .= $this->limit;
		}
		
		return $this;
	}
	
}