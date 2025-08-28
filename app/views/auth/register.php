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
            overflow: hidden; /* hilangkan scroll */
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
            padding: 25px 30px; /* lebih kecil biar muat */
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 350px; /* diperkecil */
            position: relative;
            z-index: 2;
        }

        .brand-title {
            font-size: 22px;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-title {
            font-size: 20px;
            margin-bottom: 15px;
        }

        input {
            font-size: 14px !important;
        }

        .btn {
            font-size: 14px;
            padding: 8px 12px;
        }

        .password-requirements {
            font-size: 11px;
            margin-bottom: 10px;
            padding: 8px;
        }

        /* particle random posisi */
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

    <!-- pakai bootstrap flex agar pas tengah -->
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="register-container">
            <div class="text-center mb-3">
                <h1 class="brand-title">Kiki's Catalog Game</h1>
            </div>

            <h2 class="form-title text-center">Daftar Akun</h2>

            <form>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Pilih username unik">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control form-control-sm" placeholder="Min. 6 karakter">
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control form-control-sm" placeholder="Ulangi password">
                </div>

                
                <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
            </form>

            <div class="text-center mt-3">
                <small>Sudah punya akun? <a href="<?= BASEURL; ?>\auth\login.php">Login</a></small>
            </div>
        </div>
    </div>
</body>
</html>
