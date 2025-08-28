<?php

class Home extends Controller {
    
    public function index() {
        // Cek apakah user sudah login
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: ' . BASEURL . 'auth');
            exit();
        }
        
        $data['judul'] = 'Dashboard';
        $data['username'] = $_SESSION['username'] ?? 'User';
        
        $this->view('home/index', $data);
    }
    
    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . 'auth');
        exit();
    }
}