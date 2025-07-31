<div class="container mt-5">
  <?php if ($data['mhs']) : ?>
    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title"><?= $data['mhs']['nama']; ?></h5>
        <h6 class="card-subtitle mb-2 text-body-secondary"><?= $data['mhs']['nim']; ?></h6>
        <p class="card-text"><?= $data['mhs']['jurusan']; ?></p>
        <a href="<?= BASEURL; ?>/mahasiswa" class="card-link">Kembali</a>
      </div>
    </div>
  <?php else : ?>
    <div class="alert alert-danger">Data mahasiswa tidak ditemukan.</div>
    <a href="<?= BASEURL; ?>/mahasiswa" class="btn btn-primary mt-2">Kembali</a>
  <?php endif; ?>
</div>
