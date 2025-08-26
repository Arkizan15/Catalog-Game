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
                <!-- Game Cards -->
                <div class="game-card" data-game="hollow-knight">
                    <div class="placeholder-image">
                        <img src="<?=BASEURL;?>/img/hollow_knight.png" alt="Hollow Knight">
                    </div>
                </div>
                <div class="game-card" data-game="celeste">
                    <div class="placeholder-image">
                        <img src="<?=BASEURL;?>/img/celeste.png" alt="Celeste">
                    </div>
                </div>
                <div class="game-card" data-game="tekken">
                    <div class="placeholder-image">
                        <img src="<?=BASEURL;?>/img/tekken.webp" alt="Tekken">
                    </div>
                </div>
                <div class="game-card" data-game="astfu">
                    <div class="placeholder-image">
                        <img src="<?=BASEURL;?>/img/ASTFU.jpg" alt="A Space For The Unbound">
                    </div>
                </div>
                <div class="game-card" data-game="undertale">
                    <div class="placeholder-image">
                        <img src="<?=BASEURL;?>/img/undertale.png" alt="Undertale">
                    </div>
                </div>
                <div class="game-card" data-game="until-then">
                    <div class="placeholder-image">
                        <img src="<?=BASEURL;?>/img/until_then.jpg" alt="Until Then">
                    </div>
                </div>
                <div class="game-card" data-game="omori">
                    <div class="placeholder-image">
                        <img src="<?=BASEURL;?>/img/omori.jpg" alt="Omori">
                    </div>
                </div>
                <div class="game-card" data-game="minecraft">
                    <div class="placeholder-image">
                        <img src="<?=BASEURL;?>/img/minecraft.jpg" alt="Minecraft">
                    </div>
                </div>
                <div class="game-card" data-game="persona3">
                    <div class="placeholder-image">
                        <img src="<?=BASEURL;?>/img/persona3.jpg" alt="Persona 3">
                    </div>
                </div>
                <div class="game-card" data-game="stardew">
                    <div class="placeholder-image">
                        <img src="<?=BASEURL;?>/img/stardew.jpg" alt="Stardew Valley">
                    </div>
                </div>
                <div class="game-card" data-game="persona5">
                    <div class="placeholder-image">
                        <img src="<?=BASEURL;?>/img/persona5.png" alt="Persona 5">
                    </div>
                </div>
                <div class="game-card" data-game="fe3">
                    <div class="placeholder-image">
                        <img src="<?=BASEURL;?>/img/fe3.jpg" alt="Fire Emblem">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Game Description Modal (Hidden by default) -->
    <div class="modal fade" id="gameModal" tabindex="-1" aria-labelledby="gameModalLabel" aria-hidden="true" style="display: none;">
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
                    <button type="button" class="btn btn-success">Add to Library</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
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