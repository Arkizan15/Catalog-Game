const modal = document.getElementById("profileModal");

// Mobile menu functionality
function toggleMobileMenu() {
    const navMenu = document.getElementById('navMenu');
    const toggle = document.querySelector('.mobile-menu-toggle');
    
    navMenu.classList.toggle('active');
    toggle.classList.toggle('active');
    
    // Toggle burger animation
    const lines = toggle.querySelectorAll('.burger-line');
    if (toggle.classList.contains('active')) {
        lines[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
        lines[1].style.opacity = '0';
        lines[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
    } else {
        lines[0].style.transform = 'none';
        lines[1].style.opacity = '1';
        lines[2].style.transform = 'none';
    }
}

// Close mobile menu when clicking on a link
function closeMobileMenu() {
    const navMenu = document.getElementById('navMenu');
    const toggle = document.querySelector('.mobile-menu-toggle');
    
    if (navMenu && navMenu.classList.contains('active')) {
        navMenu.classList.remove('active');
        toggle.classList.remove('active');
        
        // Reset burger lines
        const lines = toggle.querySelectorAll('.burger-line');
        lines[0].style.transform = 'none';
        lines[1].style.opacity = '1';
        lines[2].style.transform = 'none';
    }
}

// Profile modal functions
function openAccount() {
    document.getElementById('profileModal').style.display = 'flex';
    closeMobileMenu(); // Close mobile menu if open
}

function openModal() {
    modal.style.display = "flex";
}

function closeModal() {
    document.getElementById('profileModal').style.display = 'none';
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
            <div class="modal-actions">
                <a href="${window.BASEURL || ''}library" class="btn btn-primary">My Library</a>
                <a href="${window.BASEURL || ''}auth/logout" class="btn btn-danger">Logout</a>
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
    const modal = document.getElementById('profileModal');
    const navMenu = document.getElementById('navMenu');
    
    // Close modal if clicking outside
    if (event.target == modal) {
        modal.style.display = 'none';
    }
    
    // Close mobile menu if clicking outside
    if (!event.target.closest('.navbar') && navMenu && navMenu.classList.contains('active')) {
        closeMobileMenu();
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        if (modal.style.display === 'flex') {
            closeModal();
        }
        const navMenu = document.getElementById('navMenu');
        if (navMenu && navMenu.classList.contains('active')) {
            closeMobileMenu();
        }
    }
});

// Handle window resize
window.addEventListener('resize', function() {
    const navMenu = document.getElementById('navMenu');
    const toggle = document.querySelector('.mobile-menu-toggle');
    
    // Close mobile menu on desktop
    if (window.innerWidth > 768 && navMenu && navMenu.classList.contains('active')) {
        closeMobileMenu();
    }
});

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add click handler to account icon
    const accountIcon = document.querySelector('.akun');
    if (accountIcon) {
        accountIcon.addEventListener('click', openAccount);
    }
    
    // Add click handlers to nav links for mobile
    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });
    
    // Handle touch events for mobile
    let touchStartY = 0;
    let touchEndY = 0;
    
    document.addEventListener('touchstart', e => {
        touchStartY = e.changedTouches[0].screenY;
    });
    
    document.addEventListener('touchend', e => {
        touchEndY = e.changedTouches[0].screenY;
        // Optional: Add swipe gestures for mobile menu
    });
});