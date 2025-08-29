<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiki's Catalog Game</title>
    <link rel="stylesheet" href="<?= BASEURL;?>/css/home.css">
    <link rel="stylesheet" href="<?= BASEURL;?>/css/teaser.css">
    <link rel="stylesheet" href="<?= BASEURL;?>/css/header.css">
    
</head>
<body>
    <!-- Landing Section -->
    <div class="landing-container">
        <img src="<?= BASEURL;?>/img/hollow-knight-bg.jpg" alt="Background" class="background-image">

        <!-- Navbar -->
        
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title">Kiki's Catalog Game</h1>
                <p class="hero-description">
                    Selamat datang, <?= htmlspecialchars($data['username']); ?>! Ini adalah website katalog game-game yang pernah dimainkan oleh saya (Arkan Rifqy F.), website ini berdasarkan opini pribadi saya.
                </p>
                <a href="#products" class="cta-button">Lihat produk</a>
            </div>

            <div class="hero-image">
                <div class="character-container"></div>
            </div>
        </section>

        <div class="bg-effect"></div>

        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
    </div>

    <!-- Teaser Section -->
    <div class="teaser-section" id="products">
        <?php 
        // Get games data untuk teaser sections
        $gameModel = new Game_model();
        $allGames = $gameModel->getAllGames();
        
        // Filter games untuk Most Liked (ambil 4 game pertama)
        $mostLikedGames = array_slice($allGames, 0, 4);
        
        // Filter games untuk Pixel Games (berdasarkan genre yang mengandung "Pixel Art")
        $pixelGames = array_filter($allGames, function($game) {
            return strpos(strtolower($game['genre']), 'pixel') !== false || 
                   strpos(strtolower($game['genre']), 'indie') !== false ||
                   in_array($game['judul'], ['A Space For The Unbound', 'OMORI', 'Undertale', 'Celeste']);
        });
        $pixelGames = array_slice($pixelGames, 0, 4);
        ?>
        
        <!-- Most Liked Section -->
        <div class="section">
            <div class="section-header">
                <h2>Most Liked</h2>
                <a href="<?= BASEURL; ?>catalog">Show more</a>
            </div>
            <div class="game-list">
                <?php foreach ($mostLikedGames as $game): ?>
                    <?php 
                        $slug = $gameModel->titleToSlug($game['judul']);
                        $imagePath = $gameModel->getGameImage($game['judul']);
                    ?>
                    <div class="game-card" data-game="<?= $game['id']; ?>" onclick="goToGame('<?= $game['id']; ?>')">
                        <div class="placeholder-image">
                            <img src="<?=BASEURL;?>/img/<?= $imagePath; ?>" alt="<?= htmlspecialchars($game['judul']); ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pixel Games Section -->
        <div class="section">
            <div class="section-header">
                <h2>Pixel Games</h2>
                <a href="<?= BASEURL; ?>catalog">Show more</a>
            </div>
            <div class="game-list">
                <?php foreach ($pixelGames as $game): ?>
                    <?php 
                        $slug = $gameModel->titleToSlug($game['judul']);
                        $imagePath = $gameModel->getGameImage($game['judul']);
                    ?>
                    <div class="game-card" data-game="<?= $game['id']; ?>" onclick="goToGame('<?= $game['id']; ?>')">
                        <div class="placeholder-image">
                            <img src="<?=BASEURL;?>/img/<?= $imagePath; ?>" alt="<?= htmlspecialchars($game['judul']); ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        // Pass BASEURL to JavaScript
        window.BASEURL = '<?= BASEURL; ?>';
        
        // Function to navigate to game detail in catalog page
        function goToGame(gameId) {
            window.location.href = window.BASEURL + 'catalog#game-' + gameId;
        }
        
        // Add hover effects to game cards
        document.addEventListener('DOMContentLoaded', function() {
            const gameCards = document.querySelectorAll('.game-card');
            
            gameCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.transition = 'all 0.3s ease';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Error handling untuk gambar yang gagal dimuat
            const images = document.querySelectorAll('.game-card img');
            images.forEach(img => {
                img.addEventListener('error', function() {
                    this.src = window.BASEURL + '/img/default.jpg';
                    this.alt = 'Image not found';
                });
            });
        });
    </script>
    
    <script src="<?= BASEURL;?>/js/teaser.js"></script>
</body>
</html>