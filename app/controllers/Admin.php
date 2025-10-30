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
    
    // Dashboard admin
    public function index() {
        $data['title'] = 'Admin Dashboard - Manage Games';
        $data['username'] = $_SESSION['username'];

        // Load admin model
        $adminModel = $this->model('Admin_model');
        $data['games'] = $adminModel->getAllGames();
        $data['total_games'] = $adminModel->getTotalGames();
        $data['games_this_month'] = $adminModel->getGamesThisMonth();

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
    
    // ✅ ADD GAME dengan upload image
    public function addGame() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }

        try {
            // Validasi input
            $required = ['judul', 'rilis', 'genre', 'platform', 'description', 'developer'];
            foreach ($required as $field) {
                if (empty($_POST[$field])) {
                    echo json_encode(['success' => false, 'message' => "Field {$field} is required"]);
                    exit;
                }
            }

            // Validasi file upload
            if (!isset($_FILES['game_image']) || $_FILES['game_image']['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['success' => false, 'message' => 'Game image is required']);
                exit;
            }

            // Handle image upload
            $uploadResult = $this->handleImageUpload($_FILES['game_image']);
            
            if (!$uploadResult['success']) {
                echo json_encode(['success' => false, 'message' => $uploadResult['message']]);
                exit;
            }
            
            // Prepare data
            $gameData = [
                'judul' => trim($_POST['judul']),
                'rilis' => trim($_POST['rilis']),
                'genre' => trim($_POST['genre']),
                'platform' => trim($_POST['platform']),
                'description' => trim($_POST['description']),
                'developer' => trim($_POST['developer']),
                'image_path' => $uploadResult['image_path']
            ];
            
            // Insert to database
            $adminModel = $this->model('Admin_model');
            $result = $adminModel->addGame($gameData);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Game added successfully!']);
            } else {
                // Rollback: hapus file jika insert gagal
                if (file_exists('../public/uploads/games/' . $uploadResult['image_path'])) {
                    unlink('../public/uploads/games/' . $uploadResult['image_path']);
                }
                echo json_encode(['success' => false, 'message' => 'Failed to save game to database']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        exit;
    }
    
    // ✅ EDIT GAME
    public function editGame() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }

        try {
            // Validasi input
            if (empty($_POST['id'])) {
                echo json_encode(['success' => false, 'message' => 'Game ID is required']);
                exit;
            }

            $gameData = [
                'id' => $_POST['id'],
                'judul' => trim($_POST['judul']),
                'rilis' => trim($_POST['rilis']),
                'genre' => trim($_POST['genre']),
                'platform' => trim($_POST['platform']),
                'description' => trim($_POST['description']),
                'developer' => trim($_POST['developer']),
                'image_path' => ''
            ];
            
            // Jika ada upload image baru
            if (isset($_FILES['game_image']) && $_FILES['game_image']['error'] === UPLOAD_ERR_OK) {
                $adminModel = $this->model('Admin_model');
                $oldGame = $adminModel->getGameById($gameData['id']);

                // Upload image baru
                $uploadResult = $this->handleImageUpload($_FILES['game_image']);

                if ($uploadResult['success']) {
                    $gameData['image_path'] = $uploadResult['image_path'];

                    // Hapus image lama jika ada
                    if (!empty($oldGame['image_path'])) {
                        $oldImagePath = '../public/uploads/games/' . $oldGame['image_path'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                }
            }

            // Update database
            $adminModel = $this->model('Admin_model');
            $result = $adminModel->updateGame($gameData);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Game updated successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update game']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        exit;
    }
    
    // ✅ DELETE GAME
    public function deleteGame() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }

        try {
            $id = $_POST['id'] ?? null;
            
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'Game ID is required']);
                exit;
            }
            
            $adminModel = $this->model('Admin_model');
            $result = $adminModel->deleteGame($id);
            
            // Hapus file image jika ada
            if ($result['success'] && !empty($result['image_path'])) {
                $imagePath = '../public/uploads/games/' . $result['image_path'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            echo json_encode([
                'success' => $result['success'],
                'message' => $result['success'] ? 'Game deleted successfully!' : 'Failed to delete game'
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        exit;
    }
    
    // ✅ HANDLE IMAGE UPLOAD
    private function handleImageUpload($file) {
        // Validasi file upload
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'File upload error'];
        }
        
        // Validasi tipe file
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and WEBP allowed'];
        }
        
        // Validasi ukuran (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            return ['success' => false, 'message' => 'File too large. Maximum 5MB'];
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'game_' . uniqid() . '_' . time() . '.' . strtolower($extension);
        
        // Upload directory
        $uploadDir = '../public/uploads/games/';
        
        // Create directory jika belum ada
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                return ['success' => false, 'message' => 'Failed to create upload directory'];
            }
        }
        
        // Check write permission
        if (!is_writable($uploadDir)) {
            return ['success' => false, 'message' => 'Upload directory is not writable'];
        }
        
        $destination = $uploadDir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return [
                'success' => true,
                'image_path' => $filename
            ];
        }
        
        return ['success' => false, 'message' => 'Failed to move uploaded file'];
    }
    
    
public function getGame() {
    header('Content-Type: application/json');
    
    // Log untuk debugging
    error_log('getGame called with GET params: ' . print_r($_GET, true));
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Game ID is required', 'received' => $_GET]);
        exit;
    }
    
    try {
        $id = intval($_GET['id']);
        
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid Game ID']);
            exit;
        }
        
        $adminModel = $this->model('Admin_model');
        $game = $adminModel->getGameById($id);
        
        if ($game) {
            echo json_encode($game);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Game not found', 'id' => $id]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
    exit;
}
    
    // Manage user
    public function manageUser() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }

        try {
            $action = $_POST['action'] ?? null;
            $userId = $_POST['user_id'] ?? null;
            
            if (!$action || !$userId) {
                echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
                exit;
            }
            
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
            
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Action completed successfully' : 'Action failed'
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        exit;
    }
}