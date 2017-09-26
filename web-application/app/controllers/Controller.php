<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 11-5-2017
 * Time: 13:27
 */

namespace app\controllers;

use app\services\libraries\ResponseType;
use app\services\Message;
use app\services\Template;

abstract class Controller {
    
    /**
     * @return bool
     */
    public function isPost() {
        
        return ($_SERVER[ 'REQUEST_METHOD' ] == "POST") ? true : false;
    }
    
    /**
     * @param       $view
     * @param array $data
     */
    public function render($view, $stack = []) {
        
        $view = str_replace('.', '/', $view);
        $view = 'public/views/' . $view . '.php';
        
        $stack[ 'messages' ][ 'errors' ]        = Message::getErrors();
        $stack[ 'messages' ][ 'notifications' ] = Message::getNotifications();
        $stack[ 'messages' ][ 'success' ]       = Message::getSuccess();
        $stack[ 'title' ]                       = (isset($stack[ 'title' ])) ? $stack[ 'title' ] : "";
        $stack[ 'description' ]                 = (isset($stack[ 'description' ])) ? $stack[ 'description' ] : "";
        
        extract($stack);
        
        Message::clear();
        
        if (isset($data[ 'title' ])) {
            unset ($data[ 'title' ]);
        }
        
        $template = new Template();
        $template->render( $view );
        
    }
    
    /**
     * @param        $data
     * @param int    $status
     * @param string $type
     *
     * @return void
     */
    public function response($data, $type = ResponseType::JSON, $status = 200) {
        
        if (is_string($data)) {
            $data = ['msg' => $data];
        }
        
        http_response_code($status);
        header('Content-Type: ' . $type . '; charset=utf-8');
        header('status-code:' . $status);

        echo(json_encode($data));
        
    }
    
}