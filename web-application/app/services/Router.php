<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 20-4-2017
 * Time: 10:27
 */

namespace app\services;

use app\controllers\DefaultController;
use app\ServiceLoader;

class Router {
	
	private $controller;
	private $action;
	private $item_id;
	private $model;
	private $tablename;
	private $params;
	
	function __construct() {
		
		//Fallback action is "index"
		$this->action = "index";
		
		//Import statically added routes
		$static_routes = "web/routes.php";
		if ( file_exists( $static_routes ) ) {
			
			include_once ( $static_routes );
			
			if ( !empty ( $routes ) ) {
			
				foreach ( $routes as $route ) {
					
					
					echo preg_match_all( "%{(.*)}%", $route['path'], $matches );
					print_r($matches);
					
					if ( $_SERVER['REQUEST_URI'] == $route['path'] ) {
						
						$this->model = 'app\\models\\' . explode( "Controller", $route['controller'] )[0];
						$this->tablename = explode( "Controller", $route['controller'] )[0] . "s";
						$this->controller = 'app\\controllers\\' . $route['controller'];
						
						if ( isset( $route['action'] ) && !empty( $route['action'] ) ) {
							
							$this->action = $route['action'];
							
						}
						
						if ( isset( $route['params'] ) && !empty ($route['params'] ) ) {
							
							$this->params = $route['params'];
							
						}
						
					}
					
				}
			 
			}
		
		}
	
	}
	
	public function getController() {
		
		if ( class_exists( $this->controller ) ) {
			
			return $this->controller;
			
		}
		else {
			
			$this->model = '\\app\\models\\Fallback';
			$this->controller = '\\app\\controllers\\FallbackController';
			
			
		}
		
		return $this->controller;
		
	}
	
	public function getItemId() {
		
		if ( !empty ( $this->item_id ) ) {
			
			return $this->item_id;
			
		}
		else {
			
			return false;
			
		}
		
	}
	
	public function getModel() {
		
		return $this->model;
		
	}
	
	public function getAction() {
		
		return $this->action;
		
	}
	
	public function getParameters() {
		
		return $this->params;
		
	}
	
	public function getTableName() {
		
		return $this->tablename;
		
	}
	
}