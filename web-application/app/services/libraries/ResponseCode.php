<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 1-10-2017
 * Time: 18:21
 */

namespace app\services\libraries;

class ResponseCode {
    
    // Success
    const VALID = 200;
    
    // Redirection
    const DEFINITIVE       = 301;
    const TEMPORARY_CHANGE = 302;
    
    // Request fault
    const NOT_AUTHORISED = 401;
    const FORBIDDEN      = 403;
    const NOT_FOUND      = 404;
    
}