<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 20-9-2017
 * Time: 00:43
 */

namespace app\services\support;

class Str {
    
    public static function snake( $value, $delimiter = '_' )
    {
       return strtolower( preg_replace('/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $delimiter, $value ) );
    }
    
}