<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 29-6-2017
 * Time: 07:09
 */

namespace app\services\querybuilder\builders;

interface BuilderInterface {
	
	/**
	 * @param array $columns
	 * Add needed columns
	 * @return object
	 */
	public function addColumn( $columns );
	
	/**
	 * @param array $placeholders
	 * Add all placeholders
	 * @return object
	 */
	public function addPlaceholder( $placeholders );
	
	/**
	 * @param array $values
	 * Add all values
	 * @return object
	 */
	public function addValue( $values );
	
	/**
	 * @return String
	 */
	public function toString();
	
	/**
	 * @return object
	 */
	public function build();
	
	/**
	 * @return bool
	 */
	public function execute();
	
	
}