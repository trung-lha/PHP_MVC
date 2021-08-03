<?php

class Controller {
    public function model($model){
        if (file_exists(_DIR_ROOT.'/app/models/ProductModel.php')){
            require_once _DIR_ROOT.'/app/models/ProductModel.php';
            if (class_exists($model)){
                return new $model();
            }
        }
        return false;
    }

    public function render($view, $data=[]) {
        extract($data);
        if (file_exists('app/views/'.$view.'.php')){
            require_once 'app/views/'.$view.'.php';
        }
    }
}