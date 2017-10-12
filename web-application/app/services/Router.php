<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 20-4-2017
 * Time: 10:27
 */

namespace app\services;

use app\services\libraries\ParamType;
use Exception;

class Router {
    
    private $routes = [];
    private $notFound;
    /** @var Resolve */
    private $resolve;
    
    /**
     * Router constructor.
     *
     */
    public function __construct () {
        
        $this->resolver = new Resolve();
        $this->notFound = function ( $route ) {
            
            throw new Exception( "Geen route gevonden op deze url en request method. Url: " . $route[0] . ", Request Method: " . $_SERVER['REQUEST_METHOD'] . "." );
        };
    }
    
    /**
     * @param $url
     * @param $callback
     */
    public function get( $url, $callback ) {
        $this->routes[] = [
                'url' => $url,
                'callback' => $callback,
                'request_method' => "GET"
        ];
    }
    
    /**
     * @param $url
     * @param $callback
     */
    public function post( $url, $callback ) {
        $this->routes[] = [
                'url' => $url,
                'callback' => $callback,
                'request_method' => "POST"
        ];
    }
    
    /**
     * @param $url
     * @param $callback
     */
    public function put( $url, $callback ) {
        $this->routes[] = [
                'url' => $url,
                'callback' => $callback,
                'request_method' => "PUT"
        ];
    }
    
    /**
     * @param $url
     * @param $callback
     */
    public function delete( $url, $callback ) {
        $this->routes[] = [
                'url' => $url,
                'callback' => $callback,
                'request_method' => "DELETE"
        ];
    }
    
    /**
     * @param $action
     */
    public function setNotFound ( $action ) {
        
        $this->notFound = $action;
    }
    
    /**
     * @return mixed
     */
    public function dispatch () {
        
        $_SERVER['REQUEST_METHOD'] = ( isset( $_POST['_method'] ) ) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];
        $uri = ( !empty( $_SERVER['REQUEST_URI'] ) ) ? $_SERVER['REQUEST_URI'] : "/";
        
        foreach ( $this->routes as $route => $options ) {
            
            if ( $_SERVER['REQUEST_METHOD'] == ( $options['request_method'] ) ) {
                
                if ( preg_match( "%{(.*)}%", $options['url'], $matches ) ) {
                    $expression = $this->getExpression( $matches );
                    $options['url']        = str_replace( "{" . $expression[ 0 ] . "}", $expression[ 1 ], $options['url'] );
                };
                
                if ( preg_match( "%^" . $options['url'] . "$%", $uri, $matches ) ) {
                    
                    if (is_callable($options[ 'callback' ])) {
                        return $options[ 'callback' ]();
                    }
                    
                    $actionArray = explode('@', $options[ 'callback' ]);
                    $controller  = 'app\\controllers\\' . $actionArray[ 0 ];
                    $method      = (isset($actionArray[ 1 ])) ? $actionArray[ 1 ] : "";
                    
                    if (empty($method)) {
                        switch ($options[ 'request_method' ]) {
                            case 'GET':
                                $method = "index";
                                break;
                            
                            case 'POST':
                                $method = "store";
                                break;
                            
                            case 'PUT':
                                $method = "update";
                                break;
                            
                            case 'DELETE':
                                $method = "destroy";
                                break;
                            
                            default:
                                $method = "index";
                                break;
                        }
                    }
                    
                    $param = (isset($matches[ 1 ])) ? $matches[ 1 ] : "";
                    
                    return $this->resolver->resolve( $controller, $method, $param );
                    
                }
                
            }
            
        }
        
        return call_user_func( $this->notFound, [ $_SERVER[ 'REQUEST_URI' ] ] );
        
    }
    
    /**
     * @param $matches
     *
     * @return array|string
     */
    public function getExpression ( $matches ) {
        
        switch ( $matches[ 1 ] ) {
            
            case 'id':
                return [ 'id', ParamType::INTEGER ];
                break;
            
            case 'name':
                return ['name', ParamType::NAME];
                break;
            
            case 'title':
                return ['title', ParamType::TITLE];
                break;
            
            default:
                return ParamType::INTEGER;
                break;
            
        }
        
    }
    
}