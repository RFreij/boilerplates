<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 20-4-2017
 * Time: 10:27
 */

namespace app\services;

use app\controllers\Controller;
use app\models\Model;
use \PDO;
use app\controllers\DefaultController;
use app\controllers\FallbackController;
use app\models\Fallback;
use app\ServiceLoader;

class Router {
	
	private $loader;
	private $path;
	private $id;
	
	public function __construct( ServiceLoader $loader ) {
	
		$this->loader = $loader;
		$uri = preg_match_all( "%^(\D*)\/?(\d+)?$%", $_SERVER['REQUEST_URI'], $matches );
		
		
		print_r($matches);
		$this->path = $matches[1][0];
		$this->id = $matches[2][0];
		
	}
	
	public function dispatch() {
		
		$db = $this->loader->get('Database')->db;
		
		$sql = "SELECT * FROM `routes`";
		$statement = $db->prepare( $sql );
		
		$result = $statement->execute();
		
		if ( $result ) {
			
			$routes = $statement->fetchAll( PDO::FETCH_ASSOC );
			
			if ( count( $routes ) > 0 ) {
				
				foreach ( $routes as $route ) {
					
					if ( $route['path'] == $this->path ) {
						
						$model = 'app\\models\\'. $route['controller'];
						$tablename = strtolower( $route['controller'].'s');
						$controller = 'app\\controllers\\'. $route['controller'].'Controller';
						
						$action = $route['action'];
						
						if ( class_exists( $controller ) ) {
							if ( class_exists( $model ) ) {
								
								$model = new Model( $this->loader, $tablename );
								$controller = new $controller( $model );
								
								if ( method_exists( $controller, $action ) ) {
									if ( is_int( $this->id ) ) {
										$controller->$action( $this->id );
										break;
									}
									else {
										$controller->$action();
										break;
									}
								}
								
							}
						}
						else {
						
							$controller = 'app\\controllers\\FallbackController';
							$controller = new $controller();
							
							$controller->index();
							break;
						
						}
						
					}
					
				}
				
			}
			
		}
		
	}
	
}