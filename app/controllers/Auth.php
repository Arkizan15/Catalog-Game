<?php

class Auth extends Controller {
    
    public function index() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . 'home');
            exit();
        }
        
        $data['judul'] = 'Login';
        $data['error'] = $_SESSION['error'] ?? '';
        $data['success'] = $_SESSION['success'] ?? '';
        unset($_SESSION['error'], $_SESSION['success']);
        
        $this->view('auth/login', $data);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $password = $_POST['password'];

            if ($this->validateLogin($username, $password)) {
                $user = $this->model('User_model')->login($username, $password);
                
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['logged_in'] = true;
                    
                    header('Location: ' . BASEURL . 'home');
                    exit();
                } else {
                    $_SESSION['error'] = 'Username atau password salah';
                }
            }
        }
        
        header('Location: ' . BASEURL . 'auth');
        exit();
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . 'home');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($this->validateRegister($username, $password, $confirm_password)) {
                $userModel = $this->model('User_model');
                
                if (!$userModel->usernameExists($username)) {
                    if ($userModel->register($username, $password)) {
                        $_SESSION['success'] = 'Registrasi berhasil. Silakan login.';
                        header('Location: ' . BASEURL . 'auth');
                        exit();
                    } else {
                        $_SESSION['error'] = 'Registrasi gagal. Silakan coba lagi.';
                    }
                } else {
                    $_SESSION['error'] = 'Username sudah digunakan';
                }
            }
        }

        $data['judul'] = 'Register';
        $data['error'] = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);
        
        $this->view('auth/register', $data);
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . 'auth');
        exit();
    }

    private function validateLogin($username, $password) {
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Username dan password wajib diisi';
            return false;
        }

        if (strlen($username) < 3) {
            $_SESSION['error'] = 'Username minimal 3 karakter';
            return false;
        }

        return true;
    }

    private function validateRegister($username, $password, $confirm_password) {
        if (empty($username) || empty($password) || empty($confirm_password)) {
            $_SESSION['error'] = 'Semua field wajib diisi';
            return false;
        }

        if (strlen($username) < 3 || strlen($username) > 50) {
            $_SESSION['error'] = 'Username harus antara 3-50 karakter';
            return false;
        }

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $_SESSION['error'] = 'Username hanya boleh menggunakan huruf, angka, dan underscore';
            return false;
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Password minimal 6 karakter';
            return false;
        }

        if ($password !== $confirm_password) {
            $_SESSION['error'] = 'Password tidak sama';
            return false;
        }

        return true;
    }

    public function checkAuth() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: ' . BASEURL . 'auth');
            exit();
        }
    }
}