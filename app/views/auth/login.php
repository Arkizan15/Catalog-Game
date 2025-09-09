<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?> - Kiki's Catalog Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=BASEURL;?>css\login.css">
</head>
<body>
    <div class="background-particles">
        <div class="particle" style="--rand:0.1;"></div>
        <div class="particle" style="--rand:0.3;"></div>
        <div class="particle" style="--rand:0.5;"></div>
        <div class="particle" style="--rand:0.7;"></div>
        <div class="particle" style="--rand:0.9;"></div>
    </div>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="login-container">
            <div class="text-center mb-4">
                <h1 class="brand-title">Kiki's Catalog Game</h1>
                <p class="text-muted">Masuk ke akun Anda</p>
            </div>

            <h2 class="form-title text-center">Login</h2>

            <?php if (!empty($data['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($data['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($data['success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($data['success']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASEURL; ?>auth/login">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>

            <div class="text-center mt-3">
                <small>Belum punya akun? <a href="<?= BASEURL; ?>auth/register">Daftar Sekarang</a></small>
            </div>
        </div>
    </div>
</body>
</html>