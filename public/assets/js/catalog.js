// Global variable untuk menyimpan data game saat ini
let currentGameData = null;

// Initialize the catalog when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeCatalog();
});

// Initialize catalog functionality
function initializeCatalog() {
    const gameCards = document.querySelectorAll('.game-card');
    
    // Add click event listeners to all game cards
    gameCards.forEach(card => {
        card.addEventListener('click', function() {
            const gameId = this.getAttribute('data-game');
            showGameModal(gameId);
        });
        
        // Add hover effect
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.3)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 8px 32px rgba(0, 0, 0, 0.3)';
        });
    });
}

// Show game modal with game data from database
function showGameModal(gameId) {
    // Show loading indicator
    showLoading(true);

    // Get BASEURL from window object and trim trailing slash
    const baseUrl = (window.BASEURL || '').replace(/\/$/, '');

    // Fetch game data from server
    fetch(`${baseUrl}/catalog/getGameData/${gameId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}, url: ${response.url}`);
            }
            return response.json();
        })
        .then(game => {
            // Hide loading indicator
            showLoading(false);

            // Validate required properties
            if (!game || !game.id) {
                throw new Error('Invalid game data received from server');
            }

            // Store current game data globally
            currentGameData = game;

            // Populate modal with game data
            document.getElementById('gameModalLabel').textContent = game.title || 'Unknown Game';

            // Fix image path - remove leading slash from game.image if present
            const imagePath = game.image ? game.image.replace(/^\//, '') : 'default.jpg';
            const fullImageUrl = `${baseUrl}/${imagePath}`;
            document.getElementById('gameImage').src = fullImageUrl;
            document.getElementById('gameImage').alt = game.title || 'Game Image';

            // Add error handler for image loading
            document.getElementById('gameImage').onerror = function() {
                this.src = `${baseUrl}/assets/img/default.jpg`;
                console.warn(`Failed to load image: ${fullImageUrl}, using fallback`);
            };

            document.getElementById('gameGenre').textContent = game.genre || 'N/A';
            document.getElementById('gameDeveloper').textContent = game.developer || 'N/A';
            document.getElementById('gameReleaseDate').textContent = game.releaseDate || 'N/A';
            document.getElementById('gamePlatform').textContent = game.platform || 'N/A';
            document.getElementById('gameDescription').textContent = game.description || 'Tidak ada deskripsi tersedia.';

            // Show the modal using Bootstrap
            const gameModal = new bootstrap.Modal(document.getElementById('gameModal'));
            gameModal.show();
        })
        .catch(error => {
            // Hide loading indicator
            showLoading(false);

            console.error('Error fetching game data:', error);
            alert(`Gagal memuat data game (ID: ${gameId}). Error: ${error.message}. Periksa koneksi dan BASEURL.`);
        });
}

// Show/hide loading indicator
function showLoading(show) {
    const loadingIndicator = document.getElementById('loadingIndicator');
    if (loadingIndicator) {
        if (show) {
            loadingIndicator.classList.remove('d-none');
        } else {
            loadingIndicator.classList.add('d-none');
        }
    }
}

// Add to library function
function addToLibrary() {
    if (!currentGameData) {
        alert('Data game tidak tersedia.');
        return;
    }
    
    const baseUrl = window.BASEURL || '';
    
    // Show loading
    showLoading(true);
    
    // Send POST request to add game to library
    fetch(`${baseUrl}catalog/addToLibrary`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `gameId=${encodeURIComponent(currentGameData.id)}`
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(result => {
        showLoading(false);
        
        if (result.status === 'success') {
            
            // Close modal after successful addition
            const gameModal = bootstrap.Modal.getInstance(document.getElementById('gameModal'));
            if (gameModal) {
                gameModal.hide();
            }
        } else {
            alert(result.message || 'Gagal menambahkan game ke library.');
        }
    })
    .catch(error => {
        showLoading(false);
        console.error('Error adding to library:', error);
        alert('Terjadi kesalahan. Pastikan Anda sudah login dan coba lagi.');
    });
}

// Close modal function
function closeGameModal() {
    const gameModal = bootstrap.Modal.getInstance(document.getElementById('gameModal'));
    if (gameModal) {
        gameModal.hide();
    }
    currentGameData = null;
}

// Event listener untuk ketika modal ditutup
document.getElementById('gameModal').addEventListener('hidden.bs.modal', function() {
    currentGameData = null;
});

// Error handling untuk gambar yang gagal dimuat
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.game-card img');
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.src = (window.BASEURL || '') + '/img/default.jpg';
            this.alt = 'Image not found';
        });
    });
});

// Fungsi untuk refresh data games (jika diperlukan)
function refreshGames() {
    location.reload();
}