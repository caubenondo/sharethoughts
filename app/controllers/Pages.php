<?php
class Pages extends Controller{ 
    public function __construct(){
     
    }
    public function index(){
        if (isLoggedIn()) {
            redirect('posts');
        }

        $data = [
                'title'=>'SDCCD Share Thoughts',
                'description'=>'Simple Social Network built on the Hai\'s MVC '
        ];    
        $this->view('pages/index',$data);
    }

    public function about(){
        $data = [
            'title'=>'About US',
            'description'=>'We share inputs about the education system of San Diego community colleges  '
        ];
        $this->view('pages/about', $data);
    }
}