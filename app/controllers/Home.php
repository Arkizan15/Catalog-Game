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
    
    // Load games data untuk teaser sections
    $data['games'] = $this->model('Game_model')->getAllGames();
    
    // Panggil navbar, content, dan footer
    $this->view('templates/navbar', $data);
    $this->view('home/index', $data);
    $this->view('templates/footer');
}
    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . 'auth');
        exit();
    }
    
    // Method untuk mendapatkan games berdasarkan kategori (untuk AJAX jika diperlukan)
    public function getGamesByCategory($category = '') {
        header('Content-Type: application/json');
        
        $gameModel = $this->model('Game_model');
        $allGames = $gameModel->getAllGames();
        
        switch($category) {
            case 'most-liked':
                // Ambil 4 game pertama sebagai most liked
                $games = array_slice($allGames, 0, 4);
                break;
                
            case 'pixel':
                // Filter games yang mengandung pixel art atau indie
                $games = array_filter($allGames, function($game) {
                    return strpos(strtolower($game['genre']), 'pixel') !== false || 
                           strpos(strtolower($game['genre']), 'indie') !== false ||
                           in_array($game['judul'], ['A Space For The Unbound', 'OMORI', 'Undertale', 'Celeste']);
                });
                $games = array_slice($games, 0, 4);
                break;
                
            case 'rpg':
                // Filter games RPG
                $games = array_filter($allGames, function($game) {
                    return strpos(strtolower($game['genre']), 'rpg') !== false;
                });
                $games = array_slice($games, 0, 4);
                break;
                
            case 'action':
                // Filter games Action
                $games = array_filter($allGames, function($game) {
                    return strpos(strtolower($game['genre']), 'action') !== false ||
                           strpos(strtolower($game['genre']), 'fighting') !== false;
                });
                $games = array_slice($games, 0, 4);
                break;
                
            default:
                $games = array_slice($allGames, 0, 8);
                break;
        }
        
        // Format data untuk frontend
        $formattedGames = [];
        foreach($games as $game) {
            $formattedGames[] = [
                'id' => $game['id'],
                'title' => $game['judul'],
                'genre' => $game['genre'],
                'developer' => $game['developer'],
                'releaseDate' => $game['rilis'],
                'platform' => $game['platform'],
                'description' => $game['description'],
                'image' => 'img/' . $gameModel->getGameImage($game['judul']),
                'slug' => $gameModel->titleToSlug($game['judul'])
            ];
        }
        
        echo json_encode($formattedGames);
    }
}