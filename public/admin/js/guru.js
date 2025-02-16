let nama_awal = null;
function getGuru(){
    $("#tabel_guru").dataTable().fnDestroy();

   var table = $('#tabel_guru').DataTable({
     processing: true,
     serverSide: true,
     ajax: "/guru",
     columns: [
         {data: null,"sortable": false, 
            render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
           }  },
         {data: 'nama_user', name: 'nama_user'},
         {data: 'nip', name: 'nip'},
         {data: 'no_hp', name: 'no_hp'},
         {data: 'alamat', name: 'alamat'},
         {data: 'email', name: 'email'},
         {data: 'poin', name: 'poin'},
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

function showResetPoinGuru() {
    // SweetAlert pertama - Informasi
    Swal.fire({
        title: 'Fitur Reset Poin Guru',
        html: `<div class="text-left">
                <p>Perhatian! Fitur ini akan:</p>
                <ul>
                    <li>Mengubah semua poin akun guru menjadi 0</li>
                    <li>Hanya digunakan di awal tahun pembelajaran baru</li>
                    <li>Tidak dapat dibatalkan setelah dijalankan</li>
                </ul>
               </div>`,
        icon: 'info',
        confirmButtonText: 'Lanjutkan',
        confirmButtonColor: '#3085d6',
        showCancelButton: true,
        cancelButtonText: 'Tutup',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            // SweetAlert kedua - Konfirmasi
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Semua poin guru akan direset menjadi 0!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Reset Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim request reset poin
                    $.ajax({
                        url: '/admin/guru/reset-poin',
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if(response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Poin semua guru telah direset menjadi 0',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    $('#tabel_guru').DataTable().ajax.reload();
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat mereset poin guru'
                            });
                        }
                    });
                }
            });
        }
    });
}

$( document ).ready(function() {     
   getGuru()
});

$(document).ready(function() {
  $('#tabel_aspek').DataTable();
});

// Tambahkan variabel global untuk menyimpan ID guru
window.currentGuruId = null;

function viewAspek(row) {
  let data = JSON.parse(row); 
    // Simpan ID guru ke variabel global
    window.currentGuruId = data.id;
    loadAspekData(data.id, $('#filterAspek').val() , data.nama_user);
}

function download(id, dokumen, aspekType) {
    window.open(`/guru/download/${id}/${dokumen}/${aspekType}`, '_blank');
}

function loadAspekData(id, aspekType, nama_user) {
  console.log(id, aspekType, nama_user);
  nama_awal = nama_user;
    $.ajax({
        url: "/guru/aspek/" + id,
        type: "GET",
        data: { type: aspekType },
        dataType: "json",
        success: function(response) {
            let tbody = "";
            
            response.forEach(function(item, index) {
                // Tentukan nama field yang akan ditampilkan berdasarkan tipe aspek
                let namaField;
                let typeNumber;
                let folder;
                switch(aspekType) {
                    case '1':
                        namaField = item.nama_pedagogik;
                        typeNumber = 1;
                        folder = 'pedagogik';
                        nama_user = nama_user;
                        break;
                    case '2':
                        namaField = item.nama_kepribadian;
                        typeNumber = 2;
                        folder = 'kepribadian';
                        nama_user = nama_user;
                        break;
                    case '3':
                        namaField = item.nama_profesional;
                        typeNumber = 3;
                        folder = 'profesional';
                        nama_user = nama_user;
                        break;
                    case '4':
                        namaField = item.nama_sosial;
                        typeNumber = 4;
                        folder = 'sosial';
                        nama_user = nama_user;
                        break;
                    default:
                        namaField = item.nama_pedagogik;
                        typeNumber = 1;
                        folder = 'pedagogik';
                        nama_user = nama_user;
                }

              tbody += `<tr style="color: black;">
                    <td>${index + 1}</td>
                    <td>${namaField}</td>
                    <td>${item.dokumen}</td>
                    <td>
                       <div class="btn-group">
                          <a class="btn btn-primary btn-sm text-light" target="_blank" href="/storage/${nama_user}/${folder}/${item.dokumen}"><i class="bi bi-download"></i></a>
                       </div>
                    </td>
                </tr>`;
            });
            
            let table = $('#tabel_aspek').DataTable();
            table.clear().destroy();
            $("#tabel_aspek tbody").html(tbody);
            $('#tabel_aspek').DataTable();
            $("#aspekGuru").modal("show");
        },
        error: function(xhr, status, error) {
            console.error("Terjadi kesalahan: ", error);
        }
    });
}

// Event listener untuk perubahan filter tidak perlu diubah karena sudah menggunakan window.currentGuruId
$(document).ready(function() {
    $('#filterAspek').on('change', function() {
        
        if (window.currentGuruId) {
            loadAspekData(window.currentGuruId, $(this).val() , nama_awal);
        }
    });
});
