<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?> - Kiki's Catalog Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/catalog.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/library.css">
</head>
<body>
    <div class="container-fluid library-container">
        <!-- Header -->
        <div class="library-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="library-title">My Library</h1>
                        <p class="library-subtitle">Welcome back, <?= htmlspecialchars($data['username']); ?>!</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="library-stats">
                            <div class="stat-item">
                                <span class="stat-number"><?= count($data['games']); ?></span>
                                <span class="stat-label">Games</span>
                            </div>
                            <?php if (!empty($data['stats']['recent_additions'])): ?>
                            <div class="stat-item">
                                <span class="stat-number"><?= $data['stats']['recent_additions']; ?></span>
                                <span class="stat-label">Recent</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Library Content -->
        <div class="library-content">
            <div class="container">
                <?php if (empty($data['games'])): ?>
                    <!-- Empty Library State -->
                    <div class="empty-library text-center">
                        <div class="empty-icon">
                            <i class="bi bi-collection"></i>
                        </div>
                        <h3>Library Kosong</h3>
                        <p>Anda belum menambahkan game apapun ke library. Mulai jelajahi katalog dan tambahkan game favorit Anda!</p>
                        <a href="<?= BASEURL; ?>catalog" class="btn btn-primary btn-lg">Jelajahi Katalog</a>
                    </div>
                <?php else: ?>
                    <!-- Filter and Sort Options -->
                    <div class="library-controls mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" id="searchLibrary" class="form-control" placeholder="Cari game di library...">
                                    <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <select class="form-select d-inline-block w-auto" id="sortLibrary">
                                    <option value="recent">Terbaru Ditambahkan</option>
                                    <option value="title">Judul A-Z</option>
                                    <option value="title-desc">Judul Z-A</option>
                                    <option value="genre">Genre</option>
                                    <option value="developer">Developer</option>
                                </select>
                                <button class="btn btn-danger ms-2" onclick="clearLibrary()">
                                    <i class="bi bi-trash"></i> Clear All
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Games Grid -->
                    <div class="library-games">
                        <div class="row" id="gamesContainer">
                            <?php foreach ($data['games'] as $game): ?>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 game-item" 
                                     data-title="<?= strtolower($game['judul']); ?>"
                                     data-genre="<?= strtolower($game['genre']); ?>"
                                     data-developer="<?= strtolower($game['developer']); ?>"
                                     data-added="<?= $game['added_at']; ?>">
                                    <div class="library-game-card">
                                        <div class="game-image-container">
                                            <img src="<?= BASEURL; ?>/img/<?= $game['image']; ?>" 
                                                 alt="<?= htmlspecialchars($game['judul']); ?>" 
                                                 class="game-image">
                                            <div class="game-overlay">
                                                <div class="game-actions">
                                                    <button class="btn btn-primary btn-sm" onclick="viewGameDetails(<?= $game['id']; ?>)">
                                                        <i class="bi bi-eye"></i> Detail
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" onclick="removeFromLibrary(<?= $game['id']; ?>)">
                                                        <i class="bi bi-trash"></i> Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="game-info">
                                            <h5 class="game-title"><?= htmlspecialchars($game['judul']); ?></h5>
                                            <p class="game-genre"><?= htmlspecialchars($game['genre']); ?></p>
                                            <p class="game-developer"><?= htmlspecialchars($game['developer']); ?></p>
                                            <small class="text-muted">
                                                Added: <?= date('d M Y', strtotime($game['added_at'])); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Game Details Modal -->
    <div class="modal fade" id="gameModal" tabindex="-1" aria-labelledby="gameModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title" id="gameModalLabel">Game Title</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="gameImage" src="" alt="Game Image" class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <div class="game-info">
                                <h6 class="text-primary">Genre:</h6>
                                <p id="gameGenre" class="mb-2"></p>
                                
                                <h6 class="text-primary">Developer:</h6>
                                <p id="gameDeveloper" class="mb-2"></p>
                                
                                <h6 class="text-primary">Release Date:</h6>
                                <p id="gameReleaseDate" class="mb-2"></p>
                                
                                <h6 class="text-primary">Platform:</h6>
                                <p id="gamePlatform" class="mb-3"></p>
                                
                                <h6 class="text-primary">Description:</h6>
                                <p id="gameDescription"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-danger" onclick="removeFromLibraryModal()">Remove from Library</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading indicator -->
    <div id="loadingIndicator" class="d-none position-fixed top-50 start-50 translate-middle">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"></script>
    
    <!-- Pass data to JavaScript -->
    <script>
        window.BASEURL = '<?= BASEURL; ?>';
        let currentGameId = null;
    </script>
    
    <!-- Library JS -->
    <script src="<?= BASEURL; ?>/js/library.js"></script>
</body>
</html>
