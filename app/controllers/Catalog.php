<?php

class Catalog extends Controller {
    
    public function index() {
        $data['judul'] = 'Game Catalog';
        $data['games'] = $this->model('Game_model')->getAllGames();
        
        $this->view('templates/navbar', $data);
        $this->view('catalog/index', $data);
        $this->view('templates/footer');
    }
    
    public function getGameData($gameId = null) {
        header('Content-Type: application/json');
        
        if (!$gameId) {
            http_response_code(400);
            echo json_encode(['error' => 'Game ID is required']);
            return;
        }
        
        $gameModel = $this->model('Game_model');
        
        // Coba cari berdasarkan ID dulu
        if (is_numeric($gameId)) {
            $game = $gameModel->getGameById($gameId);
        } else {
            // Jika bukan numeric, coba cari berdasarkan slug
            $game = $gameModel->getGameBySlug($gameId);
        }
        
        if ($game) {
            // Format data untuk frontend
            $gameData = [
                'id' => $game['id'],
                'title' => $game['judul'],
                'genre' => $game['genre'],
                'developer' => $game['developer'],
                'releaseDate' => $game['rilis'],
                'platform' => $game['platform'],
                'description' => $game['description'],
                'image' => 'assets/img/' . $gameModel->getGameImage($game['judul']),
                'slug' => $gameModel->titleToSlug($game['judul'])
            ];
            
            echo json_encode($gameData);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Game not found']);
        }
    }
    
    public function addToLibrary() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $gameId = $_POST['gameId'] ?? '';
            $userId = $_SESSION['user_id'] ?? null;
            
            if ($userId && $gameId) {
                $libraryModel = $this->model('User_Library_model');
                
                // Cek apakah game sudah ada di library
                if ($libraryModel->isGameInLibrary($userId, $gameId)) {
                    echo json_encode(['status' => 'warning', 'message' => 'Game sudah ada di library Anda']);
                    return;
                }
                
                // Tambahkan game ke library
                if ($libraryModel->addToLibrary($userId, $gameId)) {
                    echo json_encode(['status' => 'success', 'message' => 'Game berhasil ditambahkan ke library']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan game ke library']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Invalid request atau belum login']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
        }
    }
    
    // Method untuk admin - tambah game
    public function addGame() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'judul' => $_POST['judul'] ?? '',
                'rilis' => $_POST['rilis'] ?? '',
                'genre' => $_POST['genre'] ?? '',
                'platform' => $_POST['platform'] ?? '',
                'description' => $_POST['description'] ?? '',
                'developer' => $_POST['developer'] ?? ''
            ];
            
            $gameModel = $this->model('Game_model');
            
            if ($gameModel->addGame($data)) {
                echo json_encode(['status' => 'success', 'message' => 'Game berhasil ditambahkan']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan game']);
            }
        }
    }
    
    // Method untuk admin - update game
    public function updateGame() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $_POST['id'] ?? '',
                'judul' => $_POST['judul'] ?? '',
                'rilis' => $_POST['rilis'] ?? '',
                'genre' => $_POST['genre'] ?? '',
                'platform' => $_POST['platform'] ?? '',
                'description' => $_POST['description'] ?? '',
                'developer' => $_POST['developer'] ?? ''
            ];
            
            $gameModel = $this->model('Game_model');
            
            if ($gameModel->updateGame($data)) {
                echo json_encode(['status' => 'success', 'message' => 'Game berhasil diperbarui']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui game']);
            }
        }
    }
    
    // Method untuk admin - hapus game
    public function deleteGame($gameId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $gameModel = $this->model('Game_model');
            
            if ($gameModel->deleteGame($gameId)) {
                echo json_encode(['status' => 'success', 'message' => 'Game berhasil dihapus']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus game']);
            }
        }
    }
}