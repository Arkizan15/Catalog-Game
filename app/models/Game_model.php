<?php

class Game_model {
    private $table = 'games';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Ambil semua game
    public function getAllGames() {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $this->db->resultSet();
    }

    // Get total games count
    public function getTotalGames() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    // Get games added this month (fallback to count all if created_at doesn't exist)
    public function getGamesThisMonth() {
        try {
            $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
            $result = $this->db->single();
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            // If created_at column doesn't exist, return 0
            return 0;
        }
    }

    // Ambil game berdasarkan ID
    public function getGameById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Ambil game berdasarkan slug (URL-friendly)
    public function getGameBySlug($slug) {
        $title = $this->slugToTitle($slug);
        $this->db->query("SELECT * FROM {$this->table} WHERE judul LIKE :judul LIMIT 1");
        $this->db->bind(':judul', '%' . $title . '%');
        return $this->db->single();
    }

    // Tambah game baru (dengan upload image)
    public function addGame($data) {
        $query = "INSERT INTO {$this->table} 
                  (judul, rilis, genre, platform, description, developer, image_path) 
                  VALUES 
                  (:judul, :rilis, :genre, :platform, :description, :developer, :image_path)";
        
        $this->db->query($query);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':rilis', $data['rilis']);
        $this->db->bind(':genre', $data['genre']);
        $this->db->bind(':platform', $data['platform']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':developer', $data['developer']);
        $this->db->bind(':image_path', $data['image_path'] ?? '');
        
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    // Update data game
    public function updateGame($data) {
        $query = "UPDATE {$this->table}
                  SET judul = :judul, 
                      rilis = :rilis, 
                      genre = :genre, 
                      platform = :platform,
                      description = :description, 
                      developer = :developer";
        
        // Jika ada image baru, update juga
        if (!empty($data['image_path'])) {
            $query .= ", image_path = :image_path";
        }
        
        $query .= " WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':rilis', $data['rilis']);
        $this->db->bind(':genre', $data['genre']);
        $this->db->bind(':platform', $data['platform']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':developer', $data['developer']);
        
        if (!empty($data['image_path'])) {
            $this->db->bind(':image_path', $data['image_path']);
        }
        
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    // Hapus game
    public function deleteGame($id) {
        // Get image path first untuk delete file
        $game = $this->getGameById($id);
        
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();
        
        return [
            'success' => $this->db->rowCount() > 0,
            'image_path' => $game['image_path'] ?? null
        ];
    }

    // Search games
    public function searchGames($keyword) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE judul LIKE :keyword 
                  OR genre LIKE :keyword 
                  OR developer LIKE :keyword 
                  ORDER BY id DESC";
        
        $this->db->query($query);
        $this->db->bind(':keyword', "%{$keyword}%");
        return $this->db->resultSet();
    }

    // ========== SLUG CONVERTER ==========

    public function titleToSlug($title) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = trim($slug, '-');

        $mapping = [
            'a-space-for-the-unbound' => 'astfu',
            'fire-emblem-three-houses' => 'fe3',
            'persona-3-reload' => 'persona3',
            'persona-5' => 'persona5',
            'stardew-valley' => 'stardew',
            'tekken-8' => 'tekken',
            'until-then' => 'until-then',
            'blasphemous-2' => 'bp2',
            'ultraman-fighting-evolution-3' => 'fe3'
        ];

        return $mapping[$slug] ?? $slug;
    }

    private function slugToTitle($slug) {
        $mapping = [
            'astfu' => 'A Space For The Unbound',
            'fe3' => 'Ultraman Fighting Evolution 3',
            'persona3' => 'Persona 3 Reload',
            'persona5' => 'Persona 5',
            'stardew' => 'Stardew Valley',
            'tekken' => 'Tekken 8',
            'until-then' => 'Until Then',
            'bp2' => 'Blasphemous 2'
        ];

        if (isset($mapping[$slug])) return $mapping[$slug];

        $title = str_replace('-', ' ', $slug);
        return ucwords($title);
    }

    // ========== GAMBAR GAME ==========

    public function getGameImage($title, $imagePath = null) {
        // Prioritas 1: Jika ada image_path dari database
        if (!empty($imagePath)) {
            $filePath = __DIR__ . '/../../public/uploads/games/' . $imagePath;
            if (file_exists($filePath)) {
                return $imagePath; // Return filename saja
            }
        }

        // Prioritas 2: Cari di mapping
        $norm = strtolower(trim($title));
        $imageMapping = [
            'a space for the unbound' => 'ASTFU.jpg',
            'blasphemous 2' => 'bp2.jpg',
            'celeste' => 'celeste.png',
            'hollow knight' => 'hollow_knight.png',
            'minecraft' => 'minecraft.jpg',
            'omori' => 'omori.jpg',
            'persona 3 reload' => 'persona3.jpg',
            'persona 5' => 'persona5.png',
            'stardew valley' => 'stardew.jpg',
            'tekken 8' => 'tekken.webp',
            'undertale' => 'undertale.png',
            'until then' => 'until_then.jpg',
            'ultraman fighting evolution 3' => 'fe3.jpg'
        ];

        if (isset($imageMapping[$norm])) {
            return $imageMapping[$norm];
        }

        // Prioritas 3: Fallback
        return 'default.jpg';
    }
}