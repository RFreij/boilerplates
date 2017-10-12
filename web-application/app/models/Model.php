<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 22-5-2017
 * Time: 09:14
 */

namespace app\models;

use app\services\BaseModel;

abstract class Model extends BaseModel {
    
    /**
     * @var string -- Table name in case the name is different from model name
     */
	protected $table;
    
    /**
     * @var array -- array of validation  rules
     */
	protected $rules;
    
    /**
     * @var array -- array of column fields
     */
	protected $columns;
	
}