<?php

class Users extends Controller{
    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function register() {
        //check for POST
        if($_SERVER['REQUEST_METHOD']=='POST') {
            // Process Form when there is post method passed in
             
            //sanitize POST data to the string
             $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
             //init data
             $data = [
                'name' => trim($_POST['name']),
                'name_err' => '',
                'email' =>  trim($_POST['email']),
                'email_err'=>'',
                'password'=> trim($_POST['password']),
                'confirm_password'=> trim($_POST['confirm_password']), 
                'password_err'=>'',
                'confirm_password_err'=> ''
             ];

             // validate Email
             if (empty($data['email'])) {
                 $data['email_err'] = 'Please enter email';
             } else{
                //check email exist
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err']='Email is already taken';
                }
             }

              // validate name
              if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
              }
            //validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }else if(strlen($data['password'])<6){
                $data['password_err'] = 'password must be at least 6 chars';
            }

            //validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'please confirm password';
            }else {
                if ($data['password']!= $data['confirm_password']) {
                    $data['confirm_password_err'] = 'passwords do not match';
                }
            }

            // make sure errors are empty
            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
            //validated
              
                //hash Password
                $data['password']=password_hash($data['password'], PASSWORD_DEFAULT);

                //Register User
                if($this->userModel->register($data)){
                   flash('register_success', 'Congratulation! You are registered. You can log in with your email and password.');
                    redirect('users/login');
                }else{
                    die('SOMETHING WHEN WRONG');
                }

            } else{
                // load view with errors
                $this->view('users/register',$data);
            }
            

        } else {
            // load form when there is not post method
            //echo 'load form';
            
            //init data
            $data = [
                'name' => '',
                'name_err' => '',
                'email' =>  '',
                'email_err'=>'',
                'password'=> '',
                'confirm_password'=> '', 
                'password_err'=>'',
                'confirm_password_err'=> ''
            ];

            //load view
            $this->view('users/register',$data);

        }
    }

    public function login(){
        //check for POST
        if($_SERVER['REQUEST_METHOD']=='POST'){
            // Process Form when there is post method passed in
            //sanitize POST data to the string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //init data
            $data = [      
               'email' =>  trim($_POST['email']),
               'email_err'=>'',
               'password'=> trim($_POST['password']),
               'password_err'=>'',
            ];

            // validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }
           //validate password
           if (empty($data['password'])) {
               $data['password_err'] = 'Please enter password';
           }

           // CHECK FOR USER/EMAIL verify
           if ($this->userModel->findUserByEmail($data['email'])) {
               //user found and valid
               // check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'],$data['password']);

                if ($loggedInUser) {
                    // create session
                    $this->createUserSession($loggedInUser);
                }
                else{
                    $data['password_err']='password is incorrect';
                    $this->view('users/login',$data);
                }

           }else{
               $data['email_err'] = 'No User with email found';
           }
       
           // make sure errors are empty
           if (empty($data['email_err'])  && empty($data['password_err'])) {
           //validate
               die('SUCCESS');
           } else{
               // load view with errors
               $this->view('users/login',$data);
           }
           
            
        } else {
            // load form when there is not post method
            //echo 'load form';
            
            $data = [
              
                'email' => '',
                'email_err'=>'',
                'password'=>'',
                'password_err'=>'',
              
            ];

            //load view
            $this->view('users/login',$data);

        }
    }
    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_email'] = $user->email;

        redirect('posts');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        session_destroy();

        redirect('users/login');
    }

  
}