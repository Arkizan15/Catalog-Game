<?php

class Admin extends Controller {
    
    public function __construct() {
        // Cek apakah user sudah login
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: ' . BASEURL . 'auth');
            exit;
        }
        
        // Cek apakah user adalah admin
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
            header('Location: ' . BASEURL . 'home');
            exit;
        }
    }
    
    // Dashboard admin (untuk menambah game)
    public function index() {
        $data['title'] = 'Admin Dashboard - Manage Games';
        $data['username'] = $_SESSION['username'];
        
        // Load model game jika sudah ada
        // $gameModel = $this->model('Game_model');
        // $data['games'] = $gameModel->getAllGames();
        
        $this->view('admin/index', $data);
    }
    
    // Manage users
    public function user() {
        $data['title'] = 'Admin - Manage Users';
        $data['username'] = $_SESSION['username'];
        
        // Load user model
        $userModel = $this->model('User_model');
        $data['users'] = $userModel->getAllUsers();
        
        $this->view('admin/user', $data);
    }
    
    // AJAX endpoint untuk menambah game (akan dipanggil dari form)
    public function addGame() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasi dan tambah game
            // $gameModel = $this->model('Game_model');
            // $result = $gameModel->addGame($_POST);
            
            // Return JSON response
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Game added successfully']);
            exit;
        }
    }
    
    // AJAX endpoint untuk edit game
    public function editGame() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasi dan edit game
            // $gameModel = $this->model('Game_model');
            // $result = $gameModel->updateGame($_POST);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Game updated successfully']);
            exit;
        }
    }
    
    // AJAX endpoint untuk delete game
    public function deleteGame($id = null) {
        if ($id && $_SERVER['REQUEST_METHOD'] == 'POST') {
            // Delete game
            // $gameModel = $this->model('Game_model');
            // $result = $gameModel->deleteGame($id);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Game deleted successfully']);
            exit;
        }
    }
    
    // AJAX endpoint untuk manage user (promote/demote admin, delete user)
    public function manageUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $action = $_POST['action'] ?? null;
            $userId = $_POST['user_id'] ?? null;
            
            $userModel = $this->model('User_model');
            
            switch ($action) {
                case 'toggle_admin':
                    $result = $userModel->toggleAdmin($userId);
                    break;
                case 'delete':
                    $result = $userModel->deleteUser($userId);
                    break;
                default:
                    $result = false;
            }
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Action completed successfully' : 'Action failed'
            ]);
            exit;
        }
    }
}