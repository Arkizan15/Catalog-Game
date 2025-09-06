<?php

class User_Library_model {
    private $table = 'user_library';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Tambah game ke library user
    public function addToLibrary($userId, $gameId) {
        // Check if already exists
        if ($this->isGameInLibrary($userId, $gameId)) {
            return false; // Already in library
        }
        
        $query = "INSERT INTO " . $this->table . " (user_id, game_id) VALUES (:user_id, :game_id)";
        
        $this->db->query($query);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':game_id', $gameId);
        
        $this->db->execute();
        
        return $this->db->rowCount() > 0;
    }

    // Hapus game dari library user
    public function removeFromLibrary($userId, $gameId) {
        $query = "DELETE FROM " . $this->table . " WHERE user_id = :user_id AND game_id = :game_id";
        
        $this->db->query($query);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':game_id', $gameId);
        
        $this->db->execute();
        
        return $this->db->rowCount() > 0;
    }

    // Cek apakah game sudah ada di library user
    public function isGameInLibrary($userId, $gameId) {
        $query = "SELECT id FROM " . $this->table . " WHERE user_id = :user_id AND game_id = :game_id LIMIT 1";
        
        $this->db->query($query);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':game_id', $gameId);
        
        $this->db->execute();
        
        return $this->db->rowCount() > 0;
    }

    // Get semua games di library user
    public function getUserLibrary($userId) {
        $query = "SELECT g.*, ul.added_at 
                  FROM " . $this->table . " ul 
                  JOIN games g ON ul.game_id = g.id 
                  WHERE ul.user_id = :user_id 
                  ORDER BY ul.added_at DESC";
        
        $this->db->query($query);
        $this->db->bind(':user_id', $userId);
        
        return $this->db->resultSet();
    }

    // Get jumlah games di library user
    public function getLibraryCount($userId) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE user_id = :user_id";
        
        $this->db->query($query);
        $this->db->bind(':user_id', $userId);
        
        $result = $this->db->single();
        
        return $result['total'] ?? 0;
    }

    // Get games terpopuler (yang paling banyak di library users)
    public function getPopularGames($limit = 10) {
        $query = "SELECT g.*, COUNT(ul.game_id) as popularity_count 
                  FROM games g 
                  LEFT JOIN " . $this->table . " ul ON g.id = ul.game_id 
                  GROUP BY g.id 
                  ORDER BY popularity_count DESC, g.judul ASC 
                  LIMIT :limit";
        
        $this->db->query($query);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        
        return $this->db->resultSet();
    }

    // Get library stats untuk user
    public function getLibraryStats($userId) {
        $query = "SELECT 
                    COUNT(*) as total_games,
                    COUNT(CASE WHEN ul.added_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 END) as recent_additions,
                    MIN(ul.added_at) as first_game_added,
                    MAX(ul.added_at) as last_game_added
                  FROM " . $this->table . " ul 
                  WHERE ul.user_id = :user_id";
        
        $this->db->query($query);
        $this->db->bind(':user_id', $userId);
        
        return $this->db->single();
    }

    // Clear semua library user (untuk admin/cleanup)
    public function clearUserLibrary($userId) {
        $query = "DELETE FROM " . $this->table . " WHERE user_id = :user_id";
        
        $this->db->query($query);
        $this->db->bind(':user_id', $userId);
        
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    // Get users yang memiliki game tertentu
    public function getUsersByGame($gameId) {
        $query = "SELECT u.id, u.username, ul.added_at 
                  FROM " . $this->table . " ul 
                  JOIN users u ON ul.user_id = u.id 
                  WHERE ul.game_id = :game_id 
                  ORDER BY ul.added_at DESC";
        
        $this->db->query($query);
        $this->db->bind(':game_id', $gameId);
        
        return $this->db->resultSet();
    }
}