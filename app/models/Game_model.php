<?php

class Game_model {
    private $table = 'games';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllGames() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id ASC";
        
        $this->db->query($query);
        
        return $this->db->resultSet();
    }

    public function getGameById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        
        $this->db->query($query);
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }

    public function getGameBySlug($slug) {
        // Convert slug back to title untuk pencarian
        $title = $this->slugToTitle($slug);
        
        $query = "SELECT * FROM " . $this->table . " WHERE judul LIKE :title LIMIT 1";
        
        $this->db->query($query);
        $this->db->bind(':title', '%' . $title . '%');
        
        return $this->db->single();
    }

    public function addGame($data) {
        $query = "INSERT INTO " . $this->table . " (judul, rilis, genre, platform, description, developer) 
                  VALUES (:judul, :rilis, :genre, :platform, :description, :developer)";
        
        $this->db->query($query);
        $this->db->bind(':judul', $data['judul']);
        $this->db->bind(':rilis', $data['rilis']);
        $this->db->bind(':genre', $data['genre']);
        $this->db->bind(':platform', $data['platform']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':developer', $data['developer']);
        
        $this->db->execute();
        
        return $this->db->rowCount() > 0;
    }

    public function updateGame($data) {
        $query = "UPDATE " . $this->table . " SET 
                  judul = :judul, 
                  rilis = :rilis, 
                  genre = :genre, 
                  platform = :platform, 
                  description = :description, 
                  developer = :developer 
                  WHERE id = :id";
        
        $this->db->query($query);
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

    public function deleteGame($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind(':id', $id);
        
        $this->db->execute();
        
        return $this->db->rowCount() > 0;
    }

    // Helper function untuk mengubah title menjadi slug
    public function titleToSlug($title) {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Mapping khusus untuk beberapa game
        $mapping = [
            'a-space-for-the-unbound' => 'astfu',
            'fire-emblem-three-houses' => 'fe3',
            'persona-3-reload' => 'persona3',
            'persona-5' => 'persona5',
            'stardew-valley' => 'stardew',
            'tekken-8' => 'tekken',
            'until-then' => 'until-then'
        ];
        
        return isset($mapping[$slug]) ? $mapping[$slug] : $slug;
    }

    // Helper function untuk mengubah slug menjadi title
    private function slugToTitle($slug) {
        // Mapping khusus
        $mapping = [
            'astfu' => 'A Space For The Unbound',
            'fe3' => 'Fire Emblem',
            'persona3' => 'Persona 3 Reload',
            'persona5' => 'Persona 5',
            'stardew' => 'Stardew Valley',
            'tekken' => 'Tekken 8',
            'until-then' => 'Until Then'
        ];
        
        if (isset($mapping[$slug])) {
            return $mapping[$slug];
        }
        
        // Convert slug biasa ke title
        $title = str_replace('-', ' ', $slug);
        return ucwords($title);
    }

    // Get game image path
    public function getGameImage($title) {
        // Mapping gambar berdasarkan judul
        $imageMapping = [
            'A Space For The Unbound' => 'ASTFU.jpg',
            'Celeste' => 'celeste.png',
            'Hollow Knight' => 'hollow_knight.png',
            'Minecraft' => 'minecraft.jpg',
            'OMORI' => 'omori.jpg',
            'Persona 3 Reload' => 'persona3.jpg',
            'Persona 5' => 'persona5.png',
            'Stardew Valley' => 'stardew.jpg',
            'Tekken 8' => 'tekken.webp',
            'Ultraman Fighting Evolution 3' => 'ultraman.jpg',
            'Undertale' => 'undertale.png',
            'Until Then' => 'until_then.jpg',
            'Fire Emblem: Three Houses' => 'fe3.jpg'
        ];
        
        return isset($imageMapping[$title]) ? $imageMapping[$title] : 'default.jpg';
    }
}