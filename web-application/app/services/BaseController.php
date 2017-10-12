<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 2-10-2017
 * Time: 18:35
 */

namespace app\services;

use app\services\libraries\ResponseType;

class BaseController {
    
    /**
     * @param string $view
     * @param array  $stack
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
        
        if (isset($stack[ 'title' ])) {
            unset ($stack[ 'title' ]);
        }
        
        $template = new Template();
        $template->render($view);
        
    }
    
    /**
     * @param mixed  $data
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