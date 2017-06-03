<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 2-6-2017
 * Time: 23:00
 */

namespace app\controllers;


class TestController extends Controller {
	
	const MODEL = "Test";
	
	public function index() {
		echo"hoi";
	}
	
	public function view( $id ) {
		echo $id;
	}
	
	public function name( $name ) {
		echo $name;
	}
}