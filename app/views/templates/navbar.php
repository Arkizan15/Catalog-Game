<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
   <link rel="stylesheet" href="<?=BASEURL;?>assets/css/navbar.css">
</head>
<body>
   <nav class="navbar">
       <div class="navbar-left">
           <!-- Mobile menu toggle -->
           <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
               <div class="burger-line"></div>
               <div class="burger-line"></div>
               <div class="burger-line"></div>
           </div>
           
           <ul class="nav-menu" id="navMenu">
               <li><a href="<?=BASEURL;?>home">Home</a></li>
               <li><a href="<?=BASEURL;?>catalog">Games</a></li>
               <li><a href="<?=BASEURL;?>library">Library</a></li>
               <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                   <li><a href="<?=BASEURL;?>admin" class="admin-link">Admin Panel</a></li>
               <?php endif; ?>
           </ul>
       </div>
           
       <div class="navbar-right">
           <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
               <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                   <a href="<?=BASEURL;?>admin" class="admin-badge" title="Admin Panel">
                       <i class="bi bi-shield-check"></i>
                   </a>
               <?php endif; ?>
               <i class="akun bi bi-person-circle" onclick="openAccount()"></i>
           <?php else: ?>
               <a href="<?=BASEURL;?>auth" class="login-link">Login</a>
           <?php endif; ?>
       </div>
   </nav>

   <!-- Modal Profile -->
   <div id="profileModal" class="modal">
       <div class="modal-content">
           <span class="close" onclick="closeModal()">&times;</span>
           <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
               <h2><?= htmlspecialchars($_SESSION['username']); ?></h2>
               <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                   <span class="admin-badge-modal">Admin</span>
               <?php endif; ?>
               <p>Selamat datang di Kiki's Catalog Game!</p>
               <div class="modal-actions">
                   <a href="<?=BASEURL;?>library" class="btn btn-primary">My Library</a>
                   <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                       <a href="<?=BASEURL;?>admin" class="btn btn-warning">Admin Panel</a>
                   <?php endif; ?>
                   <a href="<?=BASEURL;?>auth/logout" class="btn btn-danger">Logout</a>
               </div>
           <?php else: ?>
               <h2>Guest User</h2>
               <p>Silakan login untuk mengakses fitur lengkap.</p>
               <div class="modal-actions">
                   <a href="<?=BASEURL;?>auth" class="btn btn-primary">Login</a>
                   <a href="<?=BASEURL;?>auth/register" class="btn btn-success">Register</a>
               </div>
           <?php endif; ?>
       </div>
   </div>

   <script src="<?=BASEURL;?>assets/js/navbar.js"></script>
</body>
</html>