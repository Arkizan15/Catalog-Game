<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?> - Kiki's Catalog Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=BASEURL;?>css\register.css">
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
        <div class="register-container">
            <div class="text-center mb-4">
                <h1 class="brand-title">Kiki's Catalog Game</h1>
                <p class="text-muted">Bergabunglah dengan komunitas gamer</p>
            </div>

            <h2 class="form-title text-center">Daftar Akun</h2>

            <?php if (!empty($data['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($data['error']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASEURL; ?>auth/register">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Pilih username unik" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password" required>
                </div>

                <div class="password-requirements bg-light rounded">
                    <b>Persyaratan:</b>
                    <ul class="mb-0">
                        <li>Username 3-50 karakter (huruf, angka, underscore)</li>
                        <li>Password minimal 6 karakter</li>
                        <li>Konfirmasi password harus sama</li>
                    </ul>
                </div>

                <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
            </form>

            <div class="text-center mt-3">
                <small>Sudah punya akun? <a href="<?= BASEURL; ?>auth">Login</a></small>
            </div>
        </div>
    </div>
</body>
</html>