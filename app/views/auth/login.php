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

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 400px;
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