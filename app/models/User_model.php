<?php
class User_model {
    // sesuaikan dengan dump SQL: tabel bernama `user`
    private $table = 'user';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Login
     * Menerima either:
     *  - array ['username'=>..., 'password'=>...]  (dipakai bila controller pass $_POST)
     *  - atau dua parameter (username, password)
     * Mengembalikan user array jika berhasil, false jika gagal.
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
            // password di DB sudah di-hash (lihat dump: bcrypt hash)
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }

        return false;
    }

    /**
     * Register user baru
     * $data = ['username'=>..., 'password'=>... , 'confirm'=>..., 'email'=>...] (email optional)
     * Mengembalikan inserted rowCount (1 jika sukses) atau false.
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

    /** Ambil user by id */
    public function getUserById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /** Cek username ada atau tidak */
    public function checkUsernameExists($username) {
        $this->db->query("SELECT COUNT(*) AS cnt FROM {$this->table} WHERE username = :username");
        $this->db->bind(':username', $username);
        $row = $this->db->single();
        return isset($row['cnt']) && (int)$row['cnt'] > 0;
    }

    /** Optional: update password (hashing done here) */
    public function updatePassword($userId, $newPassword) {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->db->query("UPDATE {$this->table} SET password = :pwd WHERE id = :id");
        $this->db->bind(':pwd', $hash);
        $this->db->bind(':id', $userId);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }
}
