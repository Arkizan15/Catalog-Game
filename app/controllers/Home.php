<?php

class Home extends Controller {
    public function index(){
        $data['judul'] = 'Home';
        $data['nama'] = $this->model('User_model')->getUser();
        $this->view('templates/navbar', $data);
        $this->view('home/index', $data);
        $this->view('home/teaser', $data);
        $this->view('templates/footer');

    }
}