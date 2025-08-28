<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?> - Kiki's Catalog Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            overflow: hidden;
        }

        .background-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(100, 200, 255, 0.4);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
            box-shadow: 0 0 10px rgba(100, 200, 255, 0.3);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 420px;
            position: relative;
            z-index: 2;
        }

        .brand-title {
            font-size: 26px;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .alert {
            font-size: 14px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .password-requirements {
            font-size: 12px;
            margin-bottom: 15px;
            padding: 10px;
        }

        .particle {
            top: calc(100% * var(--rand));
            left: calc(100% * var(--rand));
        }
    </style>
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