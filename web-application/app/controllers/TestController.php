<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 2-6-2017
 * Time: 23:00
 */

namespace app\controllers;


use app\models\Test;

class TestController extends Controller {
	
	const MODEL = "Test";
	
	public function index() {
		
		$this->model->test();
		
	}
	
	public function view( $id ) {
		echo $id;
	}
	
	public function name( $name ) {
		echo $name;
	}
}