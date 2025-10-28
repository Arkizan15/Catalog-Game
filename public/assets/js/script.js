$(function () {
  // Event tombol Tambah Data
  $('.tombolTambahData').on('click', function () {
    $('#formModalLabel').html('Tambah Data Mahasiswa');
    $('.modal-footer button[type="submit"]').html('Tambah Data');
    $('.modal-body form').attr('action', 'http://localhost/phpmvc/public/mahasiswa/tambah');

    // Kosongkan semua input
    $('#id').val('');
    $('#nama').val('');
    $('#nim').val('');
    $('#jurusan').val('');
  });

  // Event tombol Ubah Data
  $('.tampilModalUbah').on('click', function () {
    $('#formModalLabel').html('Ubah Data Mahasiswa');
    $('.modal-footer button[type="submit"]').html('Ubah Data');
    $('.modal-body form').attr('action', 'http://localhost/phpmvc/public/mahasiswa/ubah');

    const id = $(this).data('id');

    $.ajax({
      url: 'http://localhost/phpmvc/public/mahasiswa/getUbah',
      data: { id: id },
      method: 'post',
      dataType: 'json',
      success: function (data) {
        $('#id').val(data.id);
        $('#nama').val(data.nama);
        $('#nim').val(data.nim);
        $('#jurusan').val(data.jurusan);
      },
      error: function (xhr, status, error) {
        console.error("AJAX Gagal:", status, error);
      }
    });
  });
});
