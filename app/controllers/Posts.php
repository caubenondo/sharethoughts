<?php
class Posts extends Controller{
    public function __construct(){
        if(!isLoggedIn()){
            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index(){
        // GET posts
        $posts= $this->postModel->getPosts();
       
        $data = [
            'posts'=> $posts
        ];

        $this->view('posts/index',$data);
    }

    public function add(){
       
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            //sanitize the post
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data=[
                'title' => trim($_POST['title']),
                'body'=> trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' =>'',
                'body_err' =>''
            ];

            //validate data
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter the title post';
            }
            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter the body text';
            }

            // make sure no errors
            if(empty($data['title_err']) && empty($data['body_err'])){
                //valid
                if ($this->postModel->addPost($data)) {
                    flash('post_message', 'Your Post has added to the boards');
                    redirect('posts');
                }
                else{
                    die('SOMETHING WENT WRONG');
                }
            }
            else{
                // load view with errors
                $this->view('posts/add',$data);
            }
        } else{
            $data=[
                'title'=>'',
                'body'=>''];
            $this->view('posts/add',$data);
        }
    }

    public function show($id){
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);
        $data=[
            'post' =>$post,
            'user' =>$user
        ];
        $this->view('posts/show',$data);
    }

    public function edit($id){
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            //sanitize the post
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data=[
                'title' => trim($_POST['title']),
                'body'=> trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' =>'',
                'body_err' =>'',
                'id'=>$id
            ];

            //validate data
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter the title post';
            }
            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter the body text';
            }

            // make sure no errors
            if(empty($data['title_err']) && empty($data['body_err'])){
                //valid
                if ($this->postModel->updatePost($data)) {
                    flash('post_message', 'Your Post has been Updated');
                    redirect('posts/show/'.$id);
                }
                else{
                    die('SOMETHING WENT WRONG');
                }
            }
            else{
                // load view with errors
                $this->view('posts/edit',$data);
            }
        } else{
            // get exisitng post from model
            $post = $this->postModel->getPostById($id);
            // check for owner
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }
            $data=[
                'id'=>$id,
                'title'=>$post->title,
                'body'=>$post->body];
            $this->view('posts/edit',$data);
        }
    }

    public function delete($id){
        if ($_SERVER['REQUEST_METHOD']=='POST') {
             // get exisitng post from model
             $post = $this->postModel->getPostById($id);
             // check for owner
             if ($post->user_id != $_SESSION['user_id']) {
                 redirect('posts');
             }
             
            if ($this->postModel->deletePost($id)) {
                flash('post_message','Post has removed');
                redirect('posts');
            }
            else{
                die('SOMETHING WENT WRONG AT DELETE REQUEST');
            }
        }else{
            redirect('posts');
        }
    }
}