<?php

class Home extends Controller {
    public function index(){
        $auth = new Auth();
        $auth->checkAuth();
        
        $data['judul'] = 'Home';
        $data['nama'] = $this->model('User_model')->getUser();
        $data['user'] = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
        
        $this->view('templates/navbar', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer', $data);
    }
}