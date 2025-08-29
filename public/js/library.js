// Global variables
let allGames = [];
let currentGameData = null;

// Initialize library functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeLibrary();
});

function initializeLibrary() {
    // Store all games for filtering
    const gameItems = document.querySelectorAll('.game-item');
    allGames = Array.from(gameItems);
    
    // Initialize search functionality
    initializeSearch();
    
    // Initialize sort functionality
    initializeSort();
    
    // Initialize error handling for images
    initializeImageErrorHandling();
}

// Search functionality
function initializeSearch() {
    const searchInput = document.getElementById('searchLibrary');
    const clearButton = document.getElementById('clearSearch');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterGames(searchTerm);
            
            // Show/hide clear button
            if (clearButton) {
                clearButton.style.display = searchTerm ? 'block' : 'none';
            }
        });
    }
    
    if (clearButton) {
        clearButton.addEventListener('click', function() {
            if (searchInput) {
                searchInput.value = '';
                filterGames('');
                this.style.display = 'none';
            }
        });
    }
}

// Sort functionality
function initializeSort() {
    const sortSelect = document.getElementById('sortLibrary');
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            sortGames(this.value);
        });
    }
}

// Filter games based on search term
function filterGames(searchTerm) {
    allGames.forEach(game => {
        const title = game.dataset.title || '';
        const genre = game.dataset.genre || '';
        const developer = game.dataset.developer || '';
        
        const matchesSearch = title.includes(searchTerm) || 
                            genre.includes(searchTerm) || 
                            developer.includes(searchTerm);
        
        if (matchesSearch) {
            game.classList.remove('hidden');
        } else {
            game.classList.add('hidden');
        }
    });
    
    // Show message if no results
    updateNoResultsMessage();
}

// Sort games
function sortGames(sortBy) {
    const container = document.getElementById('gamesContainer');
    if (!container) return;
    
    const sortedGames = [...allGames].sort((a, b) => {
        switch(sortBy) {
            case 'title':
                return a.dataset.title.localeCompare(b.dataset.title);
            case 'title-desc':
                return b.dataset.title.localeCompare(a.dataset.title);
            case 'genre':
                return a.dataset.genre.localeCompare(b.dataset.genre);
            case 'developer':
                return a.dataset.developer.localeCompare(b.dataset.developer);
            case 'recent':
            default:
                return new Date(b.dataset.added) - new Date(a.dataset.added);
        }
    });
    
    // Reorder DOM elements
    sortedGames.forEach(game => {
        container.appendChild(game);
    });
}

// Update no results message
function updateNoResultsMessage() {
    const visibleGames = allGames.filter(game => !game.classList.contains('hidden'));
    const container = document.getElementById('gamesContainer');
    
    // Remove existing no results message
    const existingMessage = document.querySelector('.no-results-message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    if (visibleGames.length === 0 && container) {
        const message = document.createElement('div');
        message.className = 'col-12 text-center no-results-message';
        message.innerHTML = `
            <div class="empty-library">
                <div class="empty-icon">
                    <i class="bi bi-search"></i>
                </div>
                <h4>Tidak ada game yang ditemukan</h4>
                <p>Coba kata kunci yang berbeda atau hapus filter pencarian.</p>
            </div>
        `;
        container.appendChild(message);
    }
}

// View game details
function viewGameDetails(gameId) {
    showLoading(true);
    
    fetch(`${window.BASEURL}catalog/getGameData/${gameId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(game => {
            showLoading(false);
            currentGameData = game;
            showGameModal(game);
        })
        .catch(error => {
            showLoading(false);
            console.error('Error fetching game data:', error);
            alert('Gagal memuat detail game. Silakan coba lagi.');
        });
}

// Show game modal
function showGameModal(game) {
    // Populate modal with game data
    document.getElementById('gameModalLabel').textContent = game.title;
    document.getElementById('gameImage').src = window.BASEURL + '/' + game.image;
    document.getElementById('gameImage').alt = game.title;
    document.getElementById('gameGenre').textContent = game.genre || 'N/A';
    document.getElementById('gameDeveloper').textContent = game.developer || 'N/A';
    document.getElementById('gameReleaseDate').textContent = game.releaseDate || 'N/A';
    document.getElementById('gamePlatform').textContent = game.platform || 'N/A';
    document.getElementById('gameDescription').textContent = game.description || 'Tidak ada deskripsi tersedia.';
    
    // Show the modal
    const gameModal = new bootstrap.Modal(document.getElementById('gameModal'));
    gameModal.show();
}

// Remove game from library
function removeFromLibrary(gameId) {
    if (confirm('Apakah Anda yakin ingin menghapus game ini dari library?')) {
        showLoading(true);
        
        fetch(`${window.BASEURL}library/removeGame`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `gameId=${encodeURIComponent(gameId)}`
        })
        .then(response => response.json())
        .then(result => {
            showLoading(false);
            
            if (result.status === 'success') {
                // Remove game card from DOM
                const gameCard = document.querySelector(`[data-game="${gameId}"]`);
                if (gameCard) {
                    gameCard.remove();
                }
                
                // Update allGames array
                allGames = allGames.filter(game => 
                    game.getAttribute('data-game') !== gameId.toString()
                );
                
                // Update stats
                updateLibraryStats();
                
                // Show success message
                showNotification(result.message, 'success');
                
                // Check if library is now empty
                if (allGames.length === 0) {
                    location.reload(); // Reload to show empty state
                }
            } else {
                showNotification(result.message, 'error');
            }
        })
        .catch(error => {
            showLoading(false);
            console.error('Error removing from library:', error);
            showNotification('Terjadi kesalahan saat menghapus game dari library.', 'error');
        });
    }
}

// Remove from library via modal
function removeFromLibraryModal() {
    if (currentGameData) {
        // Close modal first
        const gameModal = bootstrap.Modal.getInstance(document.getElementById('gameModal'));
        if (gameModal) {
            gameModal.hide();
        }
        
        // Then remove from library
        removeFromLibrary(currentGameData.id);
    }
}

// Clear entire library
function clearLibrary() {
    if (confirm('Apakah Anda yakin ingin menghapus SEMUA game dari library? Tindakan ini tidak dapat dibatalkan.')) {
        showLoading(true);
        
        fetch(`${window.BASEURL}library/clearLibrary`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
        .then(response => response.json())
        .then(result => {
            showLoading(false);
            
            if (result.status === 'success' || result.status === 'info') {
                showNotification(result.message, 'success');
                // Reload page to show empty state
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(result.message, 'error');
            }
        })
        .catch(error => {
            showLoading(false);
            console.error('Error clearing library:', error);
            showNotification('Terjadi kesalahan saat membersihkan library.', 'error');
        });
    }
}

// Update library stats
function updateLibraryStats() {
    const statNumber = document.querySelector('.stat-number');
    if (statNumber) {
        statNumber.textContent = allGames.length;
    }
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

// Show notification
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Initialize image error handling
function initializeImageErrorHandling() {
    const images = document.querySelectorAll('.game-image');
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.src = window.BASEURL + '/img/default.jpg';
            this.alt = 'Image not found';
        });
    });
}

// Handle modal close
document.addEventListener('DOMContentLoaded', function() {
    const gameModal = document.getElementById('gameModal');
    if (gameModal) {
        gameModal.addEventListener('hidden.bs.modal', function() {
            currentGameData = null;
        });
    }
});