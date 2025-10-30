<?php

class Admin_model {
    private $userTable = 'user';
    private $gamesTable = 'games';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // ===== USER MANAGEMENT =====

    // Get all users
    public function getAllUsers() {
        $this->db->query("SELECT id, username, is_admin FROM {$this->userTable} ORDER BY id ASC");
        return $this->db->resultSet();
    }

    // Toggle admin status
    public function toggleAdmin($userId) {
        // Get current status
        $this->db->query("SELECT is_admin FROM {$this->userTable} WHERE id = :id");
        $this->db->bind(':id', $userId);
        $user = $this->db->single();

        if (!$user) {
            return false;
        }

        // Toggle status
        $newStatus = $user['is_admin'] == 1 ? 0 : 1;
        $this->db->query("UPDATE {$this->userTable} SET is_admin = :status WHERE id = :id");
        $this->db->bind(':status', $newStatus);
        $this->db->bind(':id', $userId);

        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    // Delete user
    public function deleteUser($userId) {
        $this->db->query("DELETE FROM {$this->userTable} WHERE id = :id");
        $this->db->bind(':id', $userId);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    // Get user by ID
    public function getUserById($id) {
        $this->db->query("SELECT id, username, is_admin FROM {$this->userTable} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Get total users
    public function getTotalUsers() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->userTable}");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    // Get admin users count
    public function getAdminUsersCount() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->userTable} WHERE is_admin = 1");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    // Get regular users count
    public function getRegularUsersCount() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->userTable} WHERE is_admin = 0");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    // ===== GAME MANAGEMENT =====

    // Get all games
    public function getAllGames() {
        $this->db->query("SELECT * FROM {$this->gamesTable} ORDER BY id DESC");
        return $this->db->resultSet();
    }

    // Get game by ID
    public function getGameById($id) {
        $this->db->query("SELECT * FROM {$this->gamesTable} WHERE id = :id LIMIT 1");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Add new game
    public function addGame($data) {
        $this->db->query("
            INSERT INTO {$this->gamesTable}
            (judul, rilis, genre, platform, description, developer, image_path)
            VALUES
            (:judul, :rilis, :genre, :platform, :description, :developer, :image_path)
        ");

        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':rilis', $data['rilis']);
        $this->db->bind(':genre', $data['genre']);
        $this->db->bind(':platform', $data['platform']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':developer', $data['developer']);
        $this->db->bind(':image_path', $data['image_path'] ?? null);

        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    // Update game
    public function updateGame($data) {
        // Jika ada image_path baru, update dengan image
        if (!empty($data['image_path'])) {
            $this->db->query("
                UPDATE {$this->gamesTable}
                SET judul = :judul,
                    rilis = :rilis,
                    genre = :genre,
                    platform = :platform,
                    description = :description,
                    developer = :developer,
                    image_path = :image_path
                WHERE id = :id
            ");
            $this->db->bind(':image_path', $data['image_path']);
        } else {
            // Jika tidak ada image baru, update tanpa mengubah image_path
            $this->db->query("
                UPDATE {$this->gamesTable}
                SET judul = :judul,
                    rilis = :rilis,
                    genre = :genre,
                    platform = :platform,
                    description = :description,
                    developer = :developer
                WHERE id = :id
            ");
        }

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':rilis', $data['rilis']);
        $this->db->bind(':genre', $data['genre']);
        $this->db->bind(':platform', $data['platform']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':developer', $data['developer']);

        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    // Delete game
    public function deleteGame($id) {
        // Get image_path dulu sebelum delete
        $game = $this->getGameById($id);

        $this->db->query("DELETE FROM {$this->gamesTable} WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();

        $deleted = $this->db->rowCount() > 0;

        return [
            'success' => $deleted,
            'image_path' => $deleted && $game ? $game['image_path'] : null
        ];
    }

    // Get total games
    public function getTotalGames() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->gamesTable}");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    // Get games this month
    public function getGamesThisMonth() {
        $this->db->query("
            SELECT COUNT(*) as total
            FROM {$this->gamesTable}
            WHERE MONTH(STR_TO_DATE(rilis, '%d %M %Y')) = MONTH(CURRENT_DATE())
            AND YEAR(STR_TO_DATE(rilis, '%d %M %Y')) = YEAR(CURRENT_DATE())
        ");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }
}
