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

    // Ambil game berdasarkan ID
    public function getGameById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // ✅ TAMBAH GAME BARU (dengan image_path)
    public function addGame($data) {
        $this->db->query("
            INSERT INTO {$this->table} 
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

    // ✅ UPDATE GAME (dengan optional image_path)
    public function updateGame($data) {
        // Jika ada image_path baru, update dengan image
        if (!empty($data['image_path'])) {
            $this->db->query("
                UPDATE {$this->table}
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
                UPDATE {$this->table}
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

    // ✅ DELETE GAME (return image_path untuk dihapus)
    public function deleteGame($id) {
        // Get image_path dulu sebelum delete
        $game = $this->getGameById($id);
        
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();
        
        $deleted = $this->db->rowCount() > 0;
        
        return [
            'success' => $deleted,
            'image_path' => $deleted && $game ? $game['image_path'] : null
        ];
    }

    // ✅ GET TOTAL GAMES
    public function getTotalGames() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    // ✅ GET GAMES THIS MONTH
    public function getGamesThisMonth() {
        $this->db->query("
            SELECT COUNT(*) as total 
            FROM {$this->table} 
            WHERE MONTH(STR_TO_DATE(rilis, '%d %M %Y')) = MONTH(CURRENT_DATE())
            AND YEAR(STR_TO_DATE(rilis, '%d %M %Y')) = YEAR(CURRENT_DATE())
        ");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    // Ambil game berdasarkan slug (URL-friendly)
    public function getGameBySlug($slug) {
        $title = $this->slugToTitle($slug);
        $this->db->query("SELECT * FROM {$this->table} WHERE judul LIKE :judul LIMIT 1");
        $this->db->bind(':judul', '%' . $title . '%');
        return $this->db->single();
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
            'fe3' => 'Fire Emblem',
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

    // ✅ UPDATED: GAMBAR GAME dengan prioritas image_path
    public function getGameImage($title, $image_path = null) {
        // Priority 1: Gunakan image_path dari database jika ada
        if (!empty($image_path)) {
            return $image_path;
        }
        
        // Priority 2: Fallback ke mapping lama untuk data existing
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

        // Priority 3: Coba buat filename dari title
        $fileName = strtolower(str_replace(' ', '_', $title)) . '.jpg';
        $path = __DIR__ . '/../../public/assets/img/' . $fileName;
        if (file_exists($path)) {
            return $fileName;
        }

        // Priority 4: Fallback ke default
        return 'default.jpg';
    }
}