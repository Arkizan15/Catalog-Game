<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiki's Catalog Game</title>
    <link rel="stylesheet" href="<?= BASEURL;?>/css/home.css">
    <link rel="stylesheet" href="<?= BASEURL;?>/css/teaser.css">
    <link rel="stylesheet" href="<?= BASEURL;?>/css/header.css">
    <style>
        /* Override teaser.css background for integration */
        .teaser-section {
            background: linear-gradient(135deg, #000000, #404040);
            background-attachment: fixed;
            padding: 60px 20px;
            min-height: 100vh;
            width: 100vw;
            margin: 0;
        }
        
        .teaser-section .section {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 30px;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Navbar styling */
        .navbar {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 30px 50px;
        }
        
        .nav-menu {
            display: flex;
            gap: 40px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .nav-menu li {
            position: relative;
        }
        
        .nav-menu a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: 400;
            transition: all 0.3s ease;
            padding-bottom: 5px;
        }
        
        .nav-menu a:hover {
            color: #cccccc;
        }
        
        .nav-menu .active a {
            border-bottom: 2px solid white;
        }
    </style>
</head>
<body>
    <!-- Landing Section -->
    <div class="landing-container">
        <img src="<?= BASEURL;?>/img/hollow-knight-bg.jpg" alt="Background" class="background-image">

        <!-- Navbar -->
        <nav class="navbar">
            <ul class="nav-menu">
                <li class="active"><a href="#home">Home</a></li>
                <li><a href="#games">Games</a></li>
                <li><a href="#saved">Saved</a></li>
            </ul>
        </nav>

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
                <div class="game-card featured">
                    <div class="placeholder-image">Until Then</div>
                </div>
                <div class="game-card">
                    <div class="placeholder-image">Game 2</div>
                </div>
                <div class="game-card">
                    <div class="placeholder-image">Game 3</div>
                </div>
                <div class="game-card">
                    <div class="placeholder-image">Game 4</div>
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
                    <div class="placeholder-image">Pixel Game 1</div>
                </div>
                <div class="game-card">
                    <div class="placeholder-image">Pixel Game 2</div>
                </div>
                <div class="game-card">
                    <div class="placeholder-image">Pixel Game 3</div>
                </div>
                <div class="game-card">
                    <div class="placeholder-image">Pixel Game 4</div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= BASEURL;?>/js/teaser.js"></script>
</body>
</html>