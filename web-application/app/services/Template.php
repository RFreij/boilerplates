<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 26-9-2017
 * Time: 22:00
 */

namespace app\services;

class Template {
    
    private $template;
    private $parsed_template;
    
    public function render( $view ) {
        
        if ( file_exists( $view ) ) {
            
            include_once('public/template/index.php');
            
        }
    
    }
    
    
    
}