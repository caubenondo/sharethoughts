<?php
/* 
    Base controller
    Loads the models and views

*/

class Controller{
    // load model
    public function model($model){
        // require model file
        require_once '../app/models/'.$model.'.php';

        // instantiate model
        return new $model();
    }

    //load View
    public function view($view, $data=[]){
        //check for view file
        if (file_exists('../app/views/'.$view.'.php')) {
            require_once '../app/views/'.$view.'.php';
        }
        else{
            //View does not exist
            die('view does not exist');
        }
    }
}