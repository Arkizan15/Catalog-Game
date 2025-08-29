const modal = document.getElementById("profileModal");

function openAccount() {
    // Bisa ditambahkan AJAX call untuk mendapatkan info user terbaru
    fetchUserInfo();
    openModal();
}

function openModal() {
    modal.style.display = "flex";
}

function closeModal() {
    modal.style.display = "none";
}

// Fungsi untuk mengambil info user dari server
function fetchUserInfo() {
    const baseUrl = window.BASEURL || '';
    
    fetch(`${baseUrl}auth/getUserInfo`)
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Failed to fetch user info');
        })
        .then(data => {
            if (data.status === 'success') {
                updateModalContent(data.user);
            }
        })
        .catch(error => {
            console.log('Using default user info');
        });
}

// Fungsi untuk update konten modal
function updateModalContent(user) {
    const modalContent = document.querySelector('#profileModal .modal-content');
    if (modalContent && user) {
        modalContent.innerHTML = `
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>${user.username || 'User'}</h2>
            <p>Bergabung sejak: ${user.created_at || 'N/A'}</p>
            <div class="user-actions">
                <button onclick="goToLibrary()" class="btn btn-primary">My Library</button>
                <button onclick="logout()" class="btn btn-danger">Logout</button>
            </div>
        `;
    }
}

// Fungsi untuk pergi ke halaman library
function goToLibrary() {
    const baseUrl = window.BASEURL || '';
    window.location.href = `${baseUrl}library`;
    closeModal();
}

// Fungsi logout
function logout() {
    const baseUrl = window.BASEURL || '';
    
    if (confirm('Apakah Anda yakin ingin logout?')) {
        fetch(`${baseUrl}auth/logout`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(() => {
            window.location.href = `${baseUrl}auth`;
        })
        .catch(error => {
            console.error('Logout error:', error);
            // Fallback: redirect anyway
            window.location.href = `${baseUrl}auth`;
        });
    }
}

// Event listeners
window.onclick = function(event) {
    if (event.target == modal) {
        closeModal();
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && modal.style.display === 'flex') {
        closeModal();
    }
});

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add click handler to account icon
    const accountIcon = document.querySelector('.akun');
    if (accountIcon) {
        accountIcon.addEventListener('click', openAccount);
    }
});