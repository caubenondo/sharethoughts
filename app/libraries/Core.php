<?php
/* 
    App Core Class
        watch and change the URL
        create URL and loads core controller
        URL FORMAT - /controller/method/params
*/

class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params =[];

    public function __construct(){
        //echo for string, print_r for array
        //print_r ($this ->getUrl());

       $url = $this->getUrl();

       // look in controller for first value
       if (file_exists('../app/controllers/' .ucwords($url[0]).'.php')) {
           // if exist then set it as controller
           $this->currentController = ucwords($url[0]);

           //unset 0 index
           unset($url[0]);

           //otherwise just use the default controller
       }

       //require the controller relative to the global folder
       require_once '../app/controllers/'.$this->currentController.'.php';

       // instantiate controller class
       $this->currentController = new $this->currentController;

       //check for second part of url
       if(isset($url[1])){
           // check to see if the method exists in controller
           if (method_exists($this->currentController, $url[1])) {
               $this->currentMethod = $url[1];
               unset($url[1]);
           }
       }
       
       // Get params
       $this->params = $url ? array_values($url) :[];
       // call a callback with array of params
       call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    // grab the URL param
    public function getUrl(){
        
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'],'/');
            // filter out characters that the url shouldnt have
            $url = filter_var($url, FILTER_SANITIZE_URL);

            //break into array
            $url = explode('/',$url);
            return $url;
        }
    }
}