<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=BASEURL;?>/css/catalog.css">
    
</head>
<body>
    <div class="judul">
        <center>
            <h1>All Games</h1>
        </center>
    </div>
    <div class="teaser-section" id="products">
        <div class="section">
            <div class="game-list">
                <!-- Game Cards - Data dari Database -->
                <?php if (!empty($data['games'])): ?>
                    <?php foreach ($data['games'] as $game): ?>
                        <?php 
                            $gameModel = new Game_model();
                            $slug = $gameModel->titleToSlug($game['judul']);
                            $imagePath = $gameModel->getGameImage($game['judul']);
                        ?>
                        <div class="game-card" data-game="<?= $game['id']; ?>" data-slug="<?= $slug; ?>">
                            <div class="placeholder-image">
                                <img src="<?=BASEURL;?>/img/<?= $imagePath; ?>" alt="<?= htmlspecialchars($game['judul']); ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Tidak ada game yang ditemukan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Game Description Modal -->
   <div class="modal fade" id="gameModal" tabindex="-1" aria-labelledby="gameModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      
      <!-- Header -->
      <div class="modal-header border-secondary">
        <h5 class="modal-title" id="gameModalLabel">Game Title</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Body -->
      <div class="modal-body">
        <div class="row align-items-start">
          
          <!-- Gambar di kiri -->
          <div class="col-md-4 mb-3 mb-md-0">
            <img id="gameImage" src="" alt="Game Image" class="img-fluid rounded shadow">
          </div>
          
          <!-- Info di kanan -->
          <div class="col-md-8">
            <div class="game-info text-start"> <!-- text-start = rata kiri -->
              <h6 class="text-primary">Genre:</h6>
              <p id="gameGenre" class="mb-2"></p>
              
              <h6 class="text-primary">Developer:</h6>
              <p id="gameDeveloper" class="mb-2"></p>
              
              <h6 class="text-primary">Release Date:</h6>
              <p id="gameReleaseDate" class="mb-2"></p>
              
              <h6 class="text-primary">Platform:</h6>
              <p id="gamePlatform" class="mb-3"></p>
              
              <h6 class="text-primary">Description:</h6>
              <p id="gameDescription" class="mb-0"></p>
            </div>
          </div>
          
        </div>
      </div>
      
      <!-- Footer -->
      <div class="modal-footer border-secondary">
        <button type="button" class="btn btn-success" onclick="addToLibrary()">Add to Library</button>
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
    
    <!-- Pass BASEURL to JavaScript -->
    <script>
        // Make BASEURL available to external JS files
        window.BASEURL = '<?=BASEURL;?>';
    </script>
    
    <!-- Game Catalog JS -->
    <script src="<?=BASEURL;?>/js/catalog.js"></script>
</body>
</html>