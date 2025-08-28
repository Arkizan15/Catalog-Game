<?php

class User_model {
    private $table = 'user';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUser() {
        return 'Arkan Rifqy F.';
    }

    public function register($username, $password) {
        $query = "INSERT INTO " . $this->table . " (username, password) VALUES (:username, :password)";
        
        $this->db->query($query);
        $this->db->bind(':username', htmlspecialchars(strip_tags(trim($username))));
        $this->db->bind(':password', password_hash($password, PASSWORD_DEFAULT));
        
        $this->db->execute();
        
        return $this->db->rowCount() > 0;
    }

    public function login($username, $password) {
        $query = "SELECT id, username, password FROM " . $this->table . " WHERE username = :username LIMIT 1";
        
        $this->db->query($query);
        $this->db->bind(':username', htmlspecialchars(strip_tags(trim($username))));
        
        $user = $this->db->single();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }

    public function usernameExists($username) {
        $query = "SELECT id FROM " . $this->table . " WHERE username = :username LIMIT 1";
        
        $this->db->query($query);
        $this->db->bind(':username', htmlspecialchars(strip_tags(trim($username))));
        
        $this->db->execute();
        
        return $this->db->rowCount() > 0;
    }

    public function getUserById($id) {
        $query = "SELECT id, username FROM " . $this->table . " WHERE id = :id LIMIT 1";
        
        $this->db->query($query);
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }

    public function getAllUsers() {
        $query = "SELECT id, username, created_at FROM " . $this->table . " ORDER BY created_at DESC";
        
        $this->db->query($query);
        
        return $this->db->resultSet();
    }
}