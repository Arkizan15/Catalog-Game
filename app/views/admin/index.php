<!DOCTYPE html>
<html lang="en">
<head>
  <title>Manage Games | Admin Panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?= BASEURL?>assets/img/images_admin/logo-icon.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="<?= BASEURL?>assets/fonts/tabler-icons.min.css">
  <link rel="stylesheet" href="<?= BASEURL?>assets/fonts/feather.css">
  <link rel="stylesheet" href="<?= BASEURL?>assets/fonts/fontawesome.css">
  <link rel="stylesheet" href="<?= BASEURL?>assets/fonts/material.css">
  <link rel="stylesheet" href="<?= BASEURL?>assets/css/admin_css/style.css">
  <link rel="stylesheet" href="<?= BASEURL?>assets/css/admin_css/style-preset.css">
</head>
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="dark">

<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>

<?php include '../app/views/admin/sidebar.php'; ?>
<?php include '../app/views/admin/header.php'; ?>

<div class="pc-container">
  <div class="pc-content">
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h5 class="m-b-10">Game Management Dashboard</h5>
            </div>
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= BASEURL?>admin">Admin</a></li>
              <li class="breadcrumb-item" aria-current="page">Dashboard</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Dashboard Stats -->
    
    <!-- Divider -->
    <div class="row my-4">
      <div class="col-12">
        <hr>
        <h4 class="mb-3">All Games Management</h4>
      </div>
    </div>

    <!-- Add Game Button -->
    <div class="row mb-3">
      <div class="col-12">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGameModal">
          <i class="ti ti-plus"></i> Add New Game
        </button>
      </div>
    </div>

    <!-- Games List -->
    <div class="row">
      <?php if (isset($data['games']) && !empty($data['games'])): ?>
        <?php foreach ($data['games'] as $game): ?>
          <div class="col-md-6 col-lg-4 mb-3">
            <div class="card game-card">
              <?php if (!empty($game['image_path'])): ?>
                <img src="<?= BASEURL?>uploads/games/<?= htmlspecialchars($game['image_path']); ?>"
                     class="card-img-top"
                     alt="<?= htmlspecialchars($game['judul']); ?>"
                     style="height: 200px; object-fit: cover;"
                     onerror="this.onerror=null; this.src='<?= BASEURL?>assets/img/default.jpg';">
              <?php else: ?>
                <img src="<?= BASEURL?>assets/img/default.jpg"
                     class="card-img-top"
                     alt="Default Game Image"
                     style="height: 200px; object-fit: cover;">
              <?php endif; ?>
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($game['judul']); ?></h5>
                <p class="card-text text-muted small mb-2">
                  <i class="ti ti-calendar"></i> <?= htmlspecialchars($game['rilis']); ?>
                </p>
                <p class="card-text">
                  <span class="badge bg-primary"><?= htmlspecialchars($game['genre']); ?></span>
                </p>
                <p class="card-text text-muted small">
                  <i class="ti ti-device-gamepad"></i> <?= htmlspecialchars($game['platform']); ?>
                </p>
                <p class="card-text text-muted small">
                  <i class="ti ti-building"></i> <?= htmlspecialchars($game['developer']); ?>
                </p>
                <p class="card-text small"><?= substr(htmlspecialchars($game['description']), 0, 100); ?>...</p>
                <div class="d-flex gap-2">
                  <button class="btn btn-sm btn-warning" onclick="editGame(<?= $game['id']; ?>)">
                    <i class="ti ti-edit"></i> Edit
                  </button>
                  <button class="btn btn-sm btn-danger" onclick="deleteGame(<?= $game['id']; ?>, '<?= htmlspecialchars(addslashes($game['judul'])); ?>')">
                    <i class="ti ti-trash"></i> Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="alert alert-info">No games found. Add your first game!</div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Modal Add Game -->
<div class="modal fade" id="addGameModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Game</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="addGameForm" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Game Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="judul" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Release Date <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="rilis" placeholder="29 Oktober 2025" required>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Genre <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="genre" placeholder="Action, RPG, Strategy" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Platform <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="platform" placeholder="PC, PS5, Xbox" required>
            </div>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Developer <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="developer" required>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control" name="description" rows="4" required></textarea>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Game Image <span class="text-danger">*</span></label>
            <input type="file" class="form-control" name="game_image" accept="image/*" required>
            <small class="text-muted">Max 5MB. Allowed: JPG, PNG, WEBP</small>
          </div>
          
          <div id="imagePreview" class="mb-3" style="display: none;">
            <label class="form-label">Preview:</label>
            <img src="" alt="Preview" style="max-width: 100%; height: auto; border-radius: 8px; border: 2px solid #444;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy"></i> Save Game
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Game -->
<div class="modal fade" id="editGameModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Game</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editGameForm" enctype="multipart/form-data">
        <input type="hidden" name="id" id="edit_id">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Game Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="judul" id="edit_judul" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Release Date <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="rilis" id="edit_rilis" required>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Genre <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="genre" id="edit_genre" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Platform <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="platform" id="edit_platform" required>
            </div>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Developer <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="developer" id="edit_developer" required>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control" name="description" id="edit_description" rows="4" required></textarea>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Game Image (Optional - leave empty to keep current)</label>
            <input type="file" class="form-control" name="game_image" accept="image/*">
            <small class="text-muted">Max 5MB. Allowed: JPG, PNG, WEBP</small>
          </div>
          
          <div id="editImagePreview" class="mb-3">
            <label class="form-label">Current Image:</label>
            <img src="" alt="Current Image" id="current_image" style="max-width: 100%; height: auto; border-radius: 8px; border: 2px solid #444;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning">
            <i class="ti ti-device-floppy"></i> Update Game
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<footer class="pc-footer">
  <div class="footer-wrapper container-fluid">
    <div class="row">
      <div class="col-sm my-1">
        <p class="m-0">Admin Panel - Kiki's Catalog Game</p>
      </div>
    </div>
  </div>
</footer>

<!-- ✅ Scripts -->
<script src="<?= BASEURL?>assets/js/js_admin/plugins/popper.min.js"></script>
<script src="<?= BASEURL?>assets/js/js_admin/plugins/bootstrap.min.js"></script>
<script src="<?= BASEURL?>assets/js/js_admin/plugins/simplebar.min.js"></script>
<script src="<?= BASEURL?>assets/js/js_admin/fonts/custom-font.js"></script>
<script src="<?= BASEURL?>assets/js/js_admin/pcoded.js"></script>
<script src="<?= BASEURL?>assets/js/js_admin/plugins/feather.min.js"></script>

<!-- ✅ Define BASEURL for JavaScript -->
<script>
    window.BASEURL = '<?= BASEURL ?>';
</script>

<!-- ✅ Load Admin JavaScript -->
<script src="<?= BASEURL?>assets/js/admin.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize admin panel functions after DOM is loaded and pcoded.js is ready
    setTimeout(function() {
        try {
            if (typeof layout_change === 'function') layout_change('dark');
            if (typeof change_box_container === 'function') change_box_container('false');
            if (typeof layout_rtl_change === 'function') layout_rtl_change('false');
            if (typeof preset_change === 'function') preset_change("preset-1");
            // Skip font_change to avoid null reference errors
            // if (typeof font_change === 'function') font_change("Public-Sans");
        } catch (e) {
            console.warn('Admin panel initialization warning:', e.message);
        }
    }, 200);
});

// Override pcoded.js logo paths to use correct paths
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        try {
            // Override logo paths in pcoded.js
            const logoElements = document.querySelectorAll('.logo-lg, .logo-icon');
            logoElements.forEach(function(el) {
                if (el.src && el.src.includes('logo-white.svg')) {
                    el.src = '<?= BASEURL?>assets/img/images_admin/logo-white.svg';
                }
            });
        } catch (e) {
            console.warn('Logo override warning:', e.message);
        }
    }, 500);
});

// Fix null reference error in pcoded.js
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        try {
            // Ensure elements exist before calling setAttribute
            const elements = document.querySelectorAll('.pc-sidebar .m-header .logo-lg, .navbar-brand .logo-lg, .auth-main.v1 .auth-sidefooter img, .footer-top .footer-logo');
            elements.forEach(function(el) {
                if (el && el.setAttribute) {
                    el.setAttribute('src', '<?= BASEURL?>assets/img/images_admin/logo-white.svg');
                }
            });
        } catch (e) {
            console.warn('Logo fix warning:', e.message);
        }
    }, 300);
});
</script>



</body>
</html>