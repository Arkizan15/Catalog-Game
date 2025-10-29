<!DOCTYPE html>
<html lang="en">
<head>
  <title>User Management | Admin Panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?= BASEURL?>assets/img/images_admin/favicon.svg" type="image/x-icon">
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
              <h5 class="m-b-10">User Management</h5>
            </div>
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= BASEURL?>admin">Admin</a></li>
              <li class="breadcrumb-item" aria-current="page">Users</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5>All Users</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (isset($data['users']) && !empty($data['users'])): ?>
                    <?php foreach ($data['users'] as $user): ?>
                      <tr>
                        <td><?= htmlspecialchars($user['id']); ?></td>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td>
                          <?php if ($user['is_admin'] == 1): ?>
                            <span class="badge bg-warning">Admin</span>
                          <?php else: ?>
                            <span class="badge bg-primary">User</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php if ($user['id'] != $_SESSION['user_id']): ?>
                            <button 
                              class="btn btn-sm btn-warning" 
                              onclick="toggleAdmin(<?= $user['id']; ?>, '<?= htmlspecialchars($user['username']); ?>')">
                              <i class="ti ti-shield"></i> Toggle Admin
                            </button>
                            <button 
                              class="btn btn-sm btn-danger" 
                              onclick="deleteUser(<?= $user['id']; ?>, '<?= htmlspecialchars($user['username']); ?>')">
                              <i class="ti ti-trash"></i> Delete
                            </button>
                          <?php else: ?>
                            <span class="text-muted">Current User</span>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="4" class="text-center">No users found</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
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

<script src="<?= BASEURL?>assets/js/plugins/popper.min.js"></script>
<script src="<?= BASEURL?>assets/js/plugins/simplebar.min.js"></script>
<script src="<?= BASEURL?>assets/js/plugins/bootstrap.min.js"></script>
<script src="<?= BASEURL?>assets/js/fonts/custom-font.js"></script>
<script src="<?= BASEURL?>assets/js/pcoded.js"></script>
<script src="<?= BASEURL?>assets/js/plugins/feather.min.js"></script>

<script>layout_change('dark');</script>
<script>change_box_container('false');</script>
<script>layout_rtl_change('false');</script>
<script>preset_change("preset-1");</script>
<script>font_change("Public-Sans");</script>

<script>
function toggleAdmin(userId, username) {
  if (confirm(`Toggle admin status for ${username}?`)) {
    fetch('<?= BASEURL?>admin/manageUser', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `action=toggle_admin&user_id=${userId}`
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('User status updated!');
        location.reload();
      } else {
        alert('Failed to update user status');
      }
    });
  }
}

function deleteUser(userId, username) {
  if (confirm(`Delete user ${username}? This action cannot be undone!`)) {
    fetch('<?= BASEURL?>admin/manageUser', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `action=delete&user_id=${userId}`
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('User deleted successfully!');
        location.reload();
      } else {
        alert('Failed to delete user');
      }
    });
  }
}
</script>

</body>
</html>