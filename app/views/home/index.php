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
                    Ini adalah website katalog game-game yang pernah dimainkan oleh saya (Arkan Rifqy F.), website ini berdasarkan opini pribadi saya.
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
    <div class="section">
      <div class="section-header">
        <h2>Most Liked</h2>
        <a href="#">Show more</a>
      </div>
      <div class="game-list">
        <div class="game-card">
          <div class="placeholder-image"><img src="<?=BASEURL;?>/img/hollow_knight.png" alt=""></div>
        </div>
        <div class="game-card">
          <div class="placeholder-image"><img src="<?=BASEURL;?>/img/celeste.png" alt=""></div>
        </div>
        <div class="game-card">
          <div class="placeholder-image"><img src="<?=BASEURL;?>/img/tekken.webp" alt=""></div>
        </div>
        <div class="game-card">
          <div class="placeholder-image"><img src="<?=BASEURL;?>/img/ASTFU.jpg" alt=""></div>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="section-header">
        <h2>Pixel Games</h2>
        <a href="#">Show more</a>
      </div>
      <div class="game-list">
        <div class="game-card">
          <div class="placeholder-image"><img src="<?=BASEURL;?>/img/ASTFU.jpg" alt=""></div>
        </div>
        <div class="game-card">
          <div class="placeholder-image"><img src="<?=BASEURL;?>/img/until_then.jpg" alt=""></div>
        </div>
        <div class="game-card">
          <div class="placeholder-image"><img src="<?=BASEURL;?>/img/omori.jpg" alt=""></div>
        </div>
        <div class="game-card">
          <div class="placeholder-image"><img src="<?=BASEURL;?>/img/minecraft.jpg" alt=""></div>
        </div>
      </div>
    </div>
  </div>

    <script src="<?= BASEURL;?>/js/teaser.js"></script>
</body>
</html>