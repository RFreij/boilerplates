<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 20-9-2017
 * Time: 03:02
 */

namespace app\controllers;

class AppController {
    
    public function index() {
        echo "index";
        echo '
        <form action="/web-application/23" method="post">
        <input type="hidden" name="_method" value="DELETE"/>
        <input type="submit" value="submit" />
        </form>';
    }
    
    public function show($id) {
        echo "show" . $id;
    }
    
    public function store() {
        echo "store";
    }
    
    public function update() {
        echo "update";
    }
    
    public function destroy() {
        echo "destroy";
    }
    
    public function create() {
        echo "create";
    }
    
    public function edit($id) {
        echo "edit" . $id;
    }
    
}