<?php
class User_model {
    private $table = 'user';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Login
     */
    public function login($credentials, $maybePassword = null) {
        if (is_array($credentials)) {
            $username = $credentials['username'] ?? null;
            $password = $credentials['password'] ?? null;
        } else {
            $username = $credentials;
            $password = $maybePassword;
        }

        if (empty($username) || empty($password)) {
            return false;
        }

        $this->db->query("SELECT * FROM {$this->table} WHERE username = :username LIMIT 1");
        $this->db->bind(':username', $username);
        $user = $this->db->single();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }

        return false;
    }

    /**
     * Register user baru
     */
    public function register($data) {
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if (empty($username) || empty($password)) return false;
        if ($this->checkUsernameExists($username)) return false;

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->db->query("INSERT INTO {$this->table} (username, password) VALUES (:username, :password)");
        $this->db->bind(':username', $username);
        $this->db->bind(':password', $hash);
        $this->db->execute();

        return $this->db->rowCount() > 0;
    }

    /**
     * Ambil user by id
     */
    public function getUserById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Cek username ada atau tidak
     */
    public function checkUsernameExists($username) {
        $this->db->query("SELECT COUNT(*) AS cnt FROM {$this->table} WHERE username = :username");
        $this->db->bind(':username', $username);
        $row = $this->db->single();
        return isset($row['cnt']) && (int)$row['cnt'] > 0;
    }

    /**
     * Update password
     */
    public function updatePassword($userId, $newPassword) {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->db->query("UPDATE {$this->table} SET password = :pwd WHERE id = :id");
        $this->db->bind(':pwd', $hash);
        $this->db->bind(':id', $userId);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    /**
     * Get all users (untuk admin panel)
     */
    public function getAllUsers() {
        $this->db->query("SELECT id, username, is_admin FROM {$this->table} ORDER BY id ASC");
        return $this->db->resultSet();
    }

    /**
     * Toggle admin status
     */
    public function toggleAdmin($userId) {
        // Jangan biarkan admin menghapus status admin dirinya sendiri
        if ($userId == $_SESSION['user_id']) {
            return false;
        }
        
        $this->db->query("UPDATE {$this->table} SET is_admin = 1 - is_admin WHERE id = :id");
        $this->db->bind(':id', $userId);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    /**
     * Delete user (untuk admin)
     */
    public function deleteUser($userId) {
        // Jangan biarkan admin menghapus dirinya sendiri
        if ($userId == $_SESSION['user_id']) {
            return false;
        }
        
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $userId);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }
}