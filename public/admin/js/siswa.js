function getSiswa(){
    $("#tabel_siswa").dataTable().fnDestroy();

   var table = $('#tabel_siswa').DataTable({
     processing: true,
     serverSide: true,
     ajax: "/siswa",
     columns: [
         {data: null,"sortable": false, 
            render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
           }  },
         {data: 'nama_siswa', name: 'nama_siswa'},
         {data: 'kelas', name: 'kelas'},
         {data: 'no_absen', name: 'no_absen'},
         {data: 'angkatan', name: 'angkatan'},
         {data: 'no_hp', name: 'no_hp'},
         {data: 'status', name: 'status'},
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

$( document ).ready(function() {     
   getSiswa()
   $('#tabel_siswa').DataTable();


    $('#kelas').on('change', function () {
    var kelas = $(this).val();

    if (kelas) {
        $.ajax({
            url: '/siswa/cek-absen-terakhir',
            type: 'GET',
            data: { kelas: kelas },
            success: function (response) {
                // isi otomatis input no_absen dengan absen berikutnya
                $('#no_absen').val(response.no_absen_berikutnya);
            },
            error: function () {
                alert('Gagal mengambil data nomor absen');
            }
        });
    } else {
        $('#no_absen').val('');
    }
    });



   

  $('#simpanSiswa').on('click', function () {
    const data = {
        id_siswa: $('#id_siswa').val(),
        nama_siswa: $('#nama_siswa').val(),
        kelas: $('#kelas').val(),
        no_absen: $('#no_absen').val(),
        no_hp: $('#no_hp').val(),
        angkatan: $('#angkatan').val(),
        _token: $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        url: '/siswa/addSiswa',
        method: 'POST',
        data: data,
        success: function (res) {
            if (res.success) {
                Swal.fire('Sukses', res.message, 'success');
                $('#addSiswa').modal('hide');
                getSiswa()                // Bisa reload table data siswa kalau kamu pakai datatable
            } else {
                Swal.fire('Gagal', res.message, 'error');
            }
        },
        error: function (xhr) {
            let msg = 'Terjadi kesalahan.';
            if (xhr.responseJSON?.message) {
                msg = xhr.responseJSON.message;
            }
            Swal.fire('Gagal', msg, 'error');
        }
    });
});

  




});

function showAddSiswa (){

    $('#formAddDataSiswa')[0].reset();
    $('#id_siswa').val('');
    $('#judulFormSiswa').text('Form Tambah Data Siswa');
    $('#simpanSiswa').text('Simpan');
    $('#kelas').trigger('change'); // ini yang penting bro!

    $('#addSiswa').modal('show');


}
function editSiswa (row){
    let data = JSON.parse(row);
    $.ajax({
      url: `/siswa/getSiswa/${data.id}`,
      method: 'GET',
      success: function (response) {
          if (response.success) {
              const siswa = response.data;

              $('#id_siswa').val(siswa.id);
              $('#nama_siswa').val(siswa.nama_siswa);
              $('#kelas').val(siswa.kelas);
              $('#no_absen').val(siswa.no_absen);
              $('#no_hp').val(siswa.no_hp);
              $('#angkatan').val(siswa.angkatan);

              $('#judulFormSiswa').text('Form Edit Data Siswa');
              $('#simpanSiswa').text('Update');

              $('#addSiswa').modal('show');
          }
      },
      error: function (xhr) {
          Swal.fire('Gagal', 'Data siswa tidak ditemukan!', 'error');
      }
  });


}

function kirimWa(data) {
    let siswa = JSON.parse(data);

    $.ajax({
        url: `/siswa/kirimWa/${siswa.id}`,
        method: 'GET',
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: `Pesan telah berhasil dikirim ke siswa atas nama ${siswa.nama_siswa}`
                });
            } else {
                Swal.fire('Gagal', 'Gagal mengirim pesan WhatsApp.', 'error');
            }
        },
        error: function () {
            Swal.fire('Gagal', 'Terjadi kesalahan saat menghubungi server.', 'error');
        }
    });
}


function deleteSiswa(id) {
  Swal.fire({
      title: 'Yakin ingin menghapus data ini?',
      text: "Data yang dihapus tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus!'
  }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({
              url: `/siswa/delete/${id}`,
              type: 'DELETE',
              data: {
                  _token: $('meta[name="csrf-token"]').attr('content')
              },
              success: function (res) {
                  Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                  getSiswa(); // Refresh data, misalnya datatable atau tampilan siswa
              },
              error: function () {
                  Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
              }
          });
      }
  });
}


function sendWaAllSiswa() {
  Swal.fire({
      title: 'Kirim WhatsApp ke Semua Siswa Aktif?',
      text: "Pesan akan dikirim ke semua nomor siswa yang aktif!",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Kirim',
      cancelButtonText: 'Batal'
  }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({
              url: '/siswa/kirim-wa-semua',
              type: 'POST',
              data: {
                  _token: $('meta[name="csrf-token"]').attr('content'),
              },
              success: function (res) {
                  if (res.success) {
                      Swal.fire('Terkirim!', res.message, 'success');
                  } else {
                      Swal.fire('Gagal!', res.message, 'error');
                  }
              },
              error: function () {
                  Swal.fire('Error', 'Gagal menghubungi server.', 'error');
              }
          });
      }
  });
}



function ubahStatus(id) {
  $.ajax({
      url: '/siswa/cek-status', // Route ini untuk ambil status sekarang
      type: 'GET',
      data: { id: id },
      success: function (res) {
          const isAktif = res.status == 1;
          const textConfirm = isAktif
              ? 'Nonaktifkan siswa ini?'
              : 'Aktifkan kembali siswa ini?';
          const textInfo = isAktif
              ? 'Siswa tidak akan muncul sebagai aktif lagi.'
              : 'Siswa akan diaktifkan kembali.';

          Swal.fire({
              title: textConfirm,
              text: textInfo,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Ya, lanjutkan!'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '/siswa/ubah-status',
                      type: 'POST',
                      data: {
                          _token: $('meta[name="csrf-token"]').attr('content'),
                          id: id
                      },
                      success: function (res) {
                          Swal.fire('Berhasil!', res.message, 'success');
                          getSiswa();
                      },
                      error: function () {
                          Swal.fire('Error', 'Terjadi kesalahan saat proses.', 'error');
                      }
                  });
              }
          });
      },
      error: function () {
          Swal.fire('Gagal', 'Gagal mengambil status siswa.', 'error');
      }
  });
}




