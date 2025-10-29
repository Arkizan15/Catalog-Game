<?php

class Library extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: ' . BASEURL . '/auth');
            exit();
        }

        $userId       = $_SESSION['user_id'];
        $libraryModel = $this->model('User_Library_model');
        $gameModel    = $this->model('Game_model');

        // Ambil game library user
        $games = $libraryModel->getUserLibrary($userId);

        // Format biar view tidak perlu instansiasi model
        $formattedGames = [];
        foreach ($games as $game) {
            $formattedGames[] = [
                'id'        => $game['id'],
                'judul'     => $game['judul'],
                'genre'     => $game['genre'],
                'developer' => $game['developer'],
                'rilis'     => $game['rilis'],
                'platform'  => $game['platform'],
                'description' => $game['description'],
                'added_at'  => $game['added_at'],
                'image'     => $gameModel->getGameImage($game['judul'], $game['image_path'] ?? null),
                'slug'      => $gameModel->titleToSlug($game['judul']),
            ];
        }

        $data = [
            'judul'    => 'My Library',
            'username' => $_SESSION['username'] ?? 'User',
            'games'    => $formattedGames,
            'stats'    => $libraryModel->getLibraryStats($userId),
        ];

        $this->view('templates/navbar', $data);
        $this->view('library/index', $data);
        $this->view('templates/footer');
    }

    public function addGame()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $gameId = $_POST['gameId'] ?? '';
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }

        if (!$gameId) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Game ID is required']);
            return;
        }

        $libraryModel = $this->model('User_Library_model');

        // Cek apakah game sudah ada
        if ($libraryModel->isGameInLibrary($userId, $gameId)) {
            echo json_encode(['status' => 'warning', 'message' => 'Game sudah ada di library Anda']);
            return;
        }

        // Tambahkan game
        if ($libraryModel->addToLibrary($userId, $gameId)) {
            echo json_encode(['status' => 'success', 'message' => 'Game berhasil ditambahkan ke library']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan game ke library']);
        }
    }

    public function removeGame()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $gameId = $_POST['gameId'] ?? '';
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }

        if (!$gameId) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Game ID is required']);
            return;
        }

        $libraryModel = $this->model('User_Library_model');

        if ($libraryModel->removeFromLibrary($userId, $gameId)) {
            echo json_encode(['status' => 'success', 'message' => 'Game berhasil dihapus dari library']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus game dari library']);
        }
    }

    public function getLibraryData()
    {
        header('Content-Type: application/json');

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'User not logged in']);
            return;
        }

        $libraryModel = $this->model('User_Library_model');
        $gameModel    = $this->model('Game_model');

        $games = $libraryModel->getUserLibrary($userId);
        $stats = $libraryModel->getLibraryStats($userId);

        // Format data untuk frontend
        $formattedGames = [];
        foreach ($games as $game) {
            $formattedGames[] = [
                'id'          => $game['id'],
                'title'       => $game['judul'],
                'genre'       => $game['genre'],
                'developer'   => $game['developer'],
                'releaseDate' => $game['rilis'],
                'platform'    => $game['platform'],
                'description' => $game['description'],
                'image'       => 'uploads/games/' . $gameModel->getGameImage($game['judul'], $game['image_path'] ?? null),
                'addedAt'     => $game['added_at'],
                'slug'        => $gameModel->titleToSlug($game['judul']),
            ];
        }

        echo json_encode([
            'games' => $formattedGames,
            'stats' => $stats,
        ]);
    }

    public function checkGameInLibrary($gameId)
    {
        header('Content-Type: application/json');

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            echo json_encode(['inLibrary' => false, 'loggedIn' => false]);
            return;
        }

        $libraryModel = $this->model('User_Library_model');
        $inLibrary    = $libraryModel->isGameInLibrary($userId, $gameId);

        echo json_encode(['inLibrary' => $inLibrary, 'loggedIn' => true]);
    }

    public function clearLibrary()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }

        $libraryModel = $this->model('User_Library_model');
        $deletedCount = $libraryModel->clearUserLibrary($userId);

        if ($deletedCount > 0) {
            echo json_encode(['status' => 'success', 'message' => "Berhasil menghapus {$deletedCount} game dari library"]);
        } else {
            echo json_encode(['status' => 'info', 'message' => 'Library sudah kosong']);
        }
    }
}
