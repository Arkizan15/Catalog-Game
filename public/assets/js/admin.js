// ═══════════════════════════════════════════════════════════
// ADMIN PANEL JAVASCRIPT
// ═══════════════════════════════════════════════════════════

// Pastikan BASEURL sudah didefinisikan dari PHP
if (typeof window.BASEURL === 'undefined') {
    console.error('BASEURL is not defined!');
}

// ═══════════════════════════════════════════════════════════
// IMAGE PREVIEW - ADD FORM
// ═══════════════════════════════════════════════════════════
const addImageInput = document.querySelector('#addGameForm input[name="game_image"]');
if (addImageInput) {
    addImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('imagePreview');
        const previewImg = previewContainer.querySelector('img');
        
        if (file) {
            // Validasi ukuran file (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File terlalu besar! Maksimum 5MB');
                this.value = '';
                previewContainer.style.display = 'none';
                return;
            }
            
            // Validasi tipe file
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Tipe file tidak valid! Hanya JPG, PNG, dan WEBP yang diperbolehkan');
                this.value = '';
                previewContainer.style.display = 'none';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });
}

// ═══════════════════════════════════════════════════════════
// IMAGE PREVIEW - EDIT FORM
// ═══════════════════════════════════════════════════════════
const editImageInput = document.querySelector('#editGameForm input[name="game_image"]');
if (editImageInput) {
    editImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const currentImage = document.getElementById('current_image');
        
        if (file) {
            // Validasi ukuran file (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File terlalu besar! Maksimum 5MB');
                this.value = '';
                return;
            }
            
            // Validasi tipe file
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Tipe file tidak valid! Hanya JPG, PNG, dan WEBP yang diperbolehkan');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                currentImage.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
}

// ═══════════════════════════════════════════════════════════
// SUBMIT ADD GAME FORM
// ═══════════════════════════════════════════════════════════
const addGameForm = document.getElementById('addGameForm');
if (addGameForm) {
    addGameForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnContent = submitBtn.innerHTML;
        
        // Validasi client-side
        const requiredFields = ['judul', 'rilis', 'genre', 'platform', 'description', 'developer'];
        for (const field of requiredFields) {
            if (!formData.get(field) || formData.get(field).trim() === '') {
                alert(`Field ${field} harus diisi!`);
                return;
            }
        }
        
        // Validasi file image
        const imageFile = formData.get('game_image');
        if (!imageFile || imageFile.size === 0) {
            alert('Game image harus diupload!');
            return;
        }
        
        // Disable button dan tampilkan loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
        
        // Submit via AJAX
        fetch(window.BASEURL + 'admin/addGame', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message || 'Game berhasil ditambahkan!');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Gagal menambahkan game'));
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnContent;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnContent;
        });
    });
}


function editGame(id) {
    console.log('Edit game ID:', id); // Debug log

    if (!id) {
        alert('Game ID tidak valid');
        return;
    }

    fetch(window.BASEURL + 'admin/getGame?id=' + id)
        .then(response => {
            console.log('Response status:', response.status); // Debug log
            if (!response.ok) {
                throw new Error('Failed to fetch game data');
            }
            return response.json();
        })
        .then(game => {
            console.log('Game data:', game); // Debug log
            
            if (game.error) {
                alert('Error: ' + game.error);
                return;
            }
            
            // Populate form fields
            document.getElementById('edit_id').value = game.id;
            document.getElementById('edit_judul').value = game.judul || '';
            document.getElementById('edit_rilis').value = game.rilis || '';
            document.getElementById('edit_genre').value = game.genre || '';
            document.getElementById('edit_platform').value = game.platform || '';
            document.getElementById('edit_developer').value = game.developer || '';
            document.getElementById('edit_description').value = game.description || '';
            
            // Show current image
            const currentImage = document.getElementById('current_image');
            const editImagePreview = document.getElementById('editImagePreview');
            
            if (game.image_path) {
                currentImage.src = window.BASEURL + 'uploads/games/' + game.image_path;
                editImagePreview.style.display = 'block';
            } else {
                currentImage.src = window.BASEURL + 'assets/img/default.jpg';
                editImagePreview.style.display = 'block';
            }
            
            // Show modal
            const modalElement = document.getElementById('editGameModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat data game: ' + error.message);
        });
}

// ═══════════════════════════════════════════════════════════
// SUBMIT EDIT GAME FORM
// ═══════════════════════════════════════════════════════════
const editGameForm = document.getElementById('editGameForm');
if (editGameForm) {
    editGameForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnContent = submitBtn.innerHTML;
        
        // Validasi client-side
        const requiredFields = ['judul', 'rilis', 'genre', 'platform', 'description', 'developer'];
        for (const field of requiredFields) {
            if (!formData.get(field) || formData.get(field).trim() === '') {
                alert(`Field ${field} harus diisi!`);
                return;
            }
        }
        
        // Disable button dan tampilkan loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
        
        // Submit via AJAX
        fetch(window.BASEURL + 'admin/editGame', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message || 'Game berhasil diupdate!');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Gagal mengupdate game'));
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnContent;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnContent;
        });
    });
}

// ═══════════════════════════════════════════════════════════
// DELETE GAME
// ═══════════════════════════════════════════════════════════
function deleteGame(id, title) {
    if (!confirm(`Hapus game "${title}"?\n\nAksi ini tidak dapat dibatalkan!`)) {
        return;
    }
    
    fetch(window.BASEURL + 'admin/deleteGame', {
       method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}`
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(data.message || 'Game berhasil dihapus!');
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Gagal menghapus game'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
    });
}

// ═══════════════════════════════════════════════════════════
// HELPER FUNCTIONS
// ═══════════════════════════════════════════════════════════

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}

// Show loading overlay (optional)
function showLoading() {
    const loadingDiv = document.createElement('div');
    loadingDiv.id = 'loadingOverlay';
    loadingDiv.innerHTML = `
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                    background: rgba(0,0,0,0.7); display: flex; align-items: center; 
                    justify-content: center; z-index: 9999;">
            <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    document.body.appendChild(loadingDiv);
}

function hideLoading() {
    const loadingDiv = document.getElementById('loadingOverlay');
    if (loadingDiv) {
        loadingDiv.remove();
    }
}

// Console log untuk debugging
console.log('Admin Panel JavaScript loaded successfully');
console.log('BASEURL:', window.BASEURL);