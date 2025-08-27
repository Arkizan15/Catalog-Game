 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?=BASEURL;?>/css/navbar.css">
 </head>
 <body>
    <nav class="navbar">
            <ul class="nav-menu">
                <li><a href="<?=BASEURL;?>">Home</a></li>
                <li><a href="<?=BASEURL;?>/catalog">Games</a></li>
                <li><a href="<?=BASEURL;?>">Saved</a></li>
            </ul>
            
                <i class="akun bi bi-person-circle" onclick="openAccount()"></i>
                
    <div id="profileModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>Nama Akun</h2>
      <p>Ini adalah deskripsi singkat akun. Bisa berupa bio, email, atau info lain.</p>
    </div>
  </div>
        </nav>

    <script src="<?=BASEURL;?>/js/navbar.js"></script>
 </body>
 </html>
 