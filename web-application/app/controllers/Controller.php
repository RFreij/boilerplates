<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 11-5-2017
 * Time: 13:27
 */

/*
 * Do not edit this file
 */

namespace app\controllers;


use app\services\Router;
use app\models\Model;


class Controller {
	
	const MODEL = "Model";
	
	/** @var Model */
	protected $model;
	
	public function __construct( $loader ) {
		
		$model = 'app\\models\\'. $this::MODEL;
		
		if ( class_exists( $model ) ) {
			$this->model = new $model( $loader );
		}
		
	}
	
	public function isPost() {
		return ( $_SERVER['REQUEST_METHOD'] == "POST" ) ? true : false;
	}
	
	public function render( $view, $data = [] ) {
		
		$view = str_replace('.', '/', $view );
		$view = 'public/views/' . $view . '.php';
		
		if ( file_exists( $view ) ) {
			
			$data['messages']['errors'] = $this->model->message->getErrors();
			$data['messages']['notifications'] = $this->model->message->getNotifications();
			$data['messages']['success'] = $this->model->message->getSuccess();
			
			
			extract( $data );
			
			$this->model->message->clear();
			
			if ( isset( $data['title'] ) ) unset ( $data['title'] );
			
			include_once( 'public/template/index.php' );
			
		}
		else {
			
			echo "View file not found";
			
		}
		
	}
	
}
/*
 * Do not edit this file
 */