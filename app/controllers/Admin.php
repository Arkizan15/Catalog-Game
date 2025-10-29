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

        // Load model game
        $gameModel = $this->model('Game_model');
        $data['games'] = $gameModel->getAllGames();
        $data['total_games'] = $gameModel->getTotalGames();
        $data['games_this_month'] = $gameModel->getGamesThisMonth();

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
    
    // Add game dengan upload image
    public function addGame() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uploadResult = $this->handleImageUpload($_FILES['game_image'] ?? null);
            
            if (!$uploadResult['success']) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false, 
                    'message' => $uploadResult['message']
                ]);
                exit;
            }
            
            $gameData = [
                'judul' => $_POST['judul'] ?? '',
                'rilis' => $_POST['rilis'] ?? '',
                'genre' => $_POST['genre'] ?? '',
                'platform' => $_POST['platform'] ?? '',
                'description' => $_POST['description'] ?? '',
                'developer' => $_POST['developer'] ?? '',
                'image_path' => $uploadResult['image_path']
            ];
            
            $gameModel = $this->model('Game_model');
            $result = $gameModel->addGame($gameData);
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Game added successfully!' : 'Failed to add game'
            ]);
            exit;
        }
    }
    
    // Edit game
    public function editGame() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $gameData = [
                'id' => $_POST['id'] ?? null,
                'judul' => $_POST['judul'] ?? '',
                'rilis' => $_POST['rilis'] ?? '',
                'genre' => $_POST['genre'] ?? '',
                'platform' => $_POST['platform'] ?? '',
                'description' => $_POST['description'] ?? '',
                'developer' => $_POST['developer'] ?? '',
                'image_path' => ''
            ];
            
            // Jika ada upload image baru
            if (isset($_FILES['game_image']) && $_FILES['game_image']['error'] == 0) {
                // Hapus image lama
                $gameModel = $this->model('Game_model');
                $oldGame = $gameModel->getGameById($gameData['id']);
                if (!empty($oldGame['image_path'])) {
                    $oldImagePath = '../public/uploads/games/' . $oldGame['image_path'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                // Upload image baru
                $uploadResult = $this->handleImageUpload($_FILES['game_image']);
                if ($uploadResult['success']) {
                    $gameData['image_path'] = $uploadResult['image_path'];
                }
            }
            
            $gameModel = $this->model('Game_model');
            $result = $gameModel->updateGame($gameData);
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Game updated successfully!' : 'Failed to update game'
            ]);
            exit;
        }
    }
    
    // Delete game
    public function deleteGame() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            
            if (!$id) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Invalid game ID']);
                exit;
            }
            
            $gameModel = $this->model('Game_model');
            $result = $gameModel->deleteGame($id);
            
            // Hapus file image jika ada
            if ($result['success'] && !empty($result['image_path'])) {
                $imagePath = '../public/uploads/games/' . $result['image_path'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $result['success'],
                'message' => $result['success'] ? 'Game deleted successfully!' : 'Failed to delete game'
            ]);
            exit;
        }
    }
    
    // Handle image upload
    private function handleImageUpload($file) {
        if (!$file || $file['error'] !== 0) {
            return ['success' => false, 'message' => 'No file uploaded or upload error'];
        }
        
        // Validasi tipe file
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and WEBP allowed'];
        }
        
        // Validasi ukuran (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            return ['success' => false, 'message' => 'File too large. Maximum 5MB'];
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('game_') . '_' . time() . '.' . $extension;
        
        // Upload directory
        $uploadDir = '../public/uploads/games/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $destination = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return [
                'success' => true,
                'image_path' => $filename
            ];
        }
        
        return ['success' => false, 'message' => 'Failed to move uploaded file'];
    }
    
    // Get game data for editing (AJAX)
    public function getGame() {
        if (isset($_GET['id'])) {
            $gameModel = $this->model('Game_model');
            $game = $gameModel->getGameById($_GET['id']);
            
            header('Content-Type: application/json');
            echo json_encode($game);
            exit;
        }
    }
    
    // Manage user
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