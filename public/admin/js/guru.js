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
         {data: 'email', name: 'email'},
         {data: 'alamat', name: 'alamat'},
         {data: 'kelas', name: 'kelas'},
         {data: 'mapel', name: 'mapel'},
         {data: 'poin', name: 'poin'},
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

   let currentGuruId = null;
   let chartGuru = null;
   
   function viewGrafik(row) {
    const data = JSON.parse(row);
    currentGuruId = data.id;

    // Set default tipe & aspek
    $('#filterGrafik').val('kompetensi');
    $('#filterAspek').val('1'); // default pedagogik
    $('#wrapSubFilter').show();
    $('#wrapDateFilter').hide();

    $('#grafikGuru').modal('show');

    // Langsung load chart default 1
    reloadChart();
}

// Event filter tipe grafik
$('#filterGrafik').on('change', function () {
    if (!currentGuruId) return;

    const tipe = $(this).val();

    if (tipe === 'kompetensi') {
        $('#wrapSubFilter').slideDown();
        $('#wrapDateFilter').slideUp();
    } else if (tipe === 'kehadiran') {
        $('#wrapSubFilter').slideUp();
        $('#wrapDateFilter').slideDown();
    } else {
        $('#wrapSubFilter').slideUp();
        $('#wrapDateFilter').slideUp();
    }

    reloadChart();
});

// Event ganti aspek → reload chart
$(document).on('change', '#filterAspek', function () {
  if (!currentGuruId) return;
  const newAspek = $(this).val();
  console.log("Aspek diganti ke:", newAspek);
  reloadChart(newAspek);
});

// Event tanggal untuk kehadiran
$('#startDate, #endDate').on('change', function () {
    if (!currentGuruId) return;
    reloadChart();
});

function reloadChart(aspekOverride = null) {
  const tipe = $('#filterGrafik').val();
  const aspek = (tipe === 'kompetensi') 
      ? (aspekOverride !== null ? aspekOverride : $('#filterAspek').val()) 
      : null;

  const start = (tipe === 'kehadiran') ? $('#startDate').val() : null;
  const end = (tipe === 'kehadiran') ? $('#endDate').val() : null;

  console.log("Reload chart dengan aspek:", aspek);

  loadGrafikData(currentGuruId, tipe, aspek, start, end);
}


   function loadGrafikData(id, tipe, aspek = null, start = null, end = null) {
       $.ajax({
           url: `/guru/grafikData/${id}`,
           type: "GET",
           data: {
               type: tipe,
               aspek: aspek,
               start: start,
               end: end
           },
           dataType: "json",
           success: function (response) {
               const ctx = document.getElementById('chartPerforma').getContext('2d');
               if (chartGuru) chartGuru.destroy();
   
               const gradient = ctx.createLinearGradient(0, 0, 0, 400);
               gradient.addColorStop(0, 'rgba(54, 162, 235, 0.6)');
               gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');
   
               let yMax = 100;
               if (tipe === 'kinerja') yMax = 50;
               if (tipe === 'kehadiran') yMax = 31;
   
               chartGuru = new Chart(ctx, {
                   type: 'line',
                   data: {
                       labels: response.labels,
                       datasets: [{
                           label: `Performa Guru - ${tipe}${aspek ? ' - ' + aspek : ''}`,
                           data: response.data,
                           fill: true,
                           backgroundColor: gradient,
                           borderColor: 'rgba(54, 162, 235, 1)',
                           borderWidth: 2,
                           tension: 0.4,
                           pointRadius: 5,
                           pointHoverRadius: 8
                       }]
                   },
                   options: {
                       responsive: true,
                       scales: {
                           y: {
                               beginAtZero: true,
                               max: yMax,
                               title: {
                                   display: true,
                                   text: tipe === 'kehadiran' ? 'Jumlah Kehadiran (hari)' : 'Skor'
                               }
                           },
                           x: {
                               title: {
                                   display: true,
                                   text: tipe === 'kehadiran' ? 'Bulan' : 'Tahun'
                               }
                           }
                       }
                   }
               });
           }
       });
   }
   

function showResetPoinGuru() {
  Swal.fire({
    title: 'Fitur Reset Poin Guru',
    html: `
        <div style="text-align: left;">
            <p><strong>Perhatian!</strong> Fitur ini akan:</p>
            <ul style="padding-left: 1.2em;">
                <li>Mengubah semua poin akun guru menjadi <strong>0</strong></li>
                <li>Hanya digunakan di awal tahun pembelajaran baru</li>
                <li><span style="color: red;">Tidak dapat dibatalkan</span> setelah dijalankan</li>
            </ul>
            <hr>
            <p><strong>Apakah Anda yakin ingin melanjutkan?</strong></p>
            <div style="display: flex; justify-content: center; gap: 20px; margin-top: 10px;">
                <label style="display: flex; align-items: center;">
                    <input type="radio" name="konfirmasi" value="ya" style="margin-right: 5px;">
                    Ya, saya yakin
                </label>
                <label style="display: flex; align-items: center;">
                    <input type="radio" name="konfirmasi" value="tidak" style="margin-right: 5px;">
                    Tidak, batalkan
                </label>
            </div>
        </div>
    `,
    icon: 'info',
    confirmButtonText: 'Lanjutkan',
    confirmButtonColor: '#3085d6',
    showCancelButton: true,
    cancelButtonText: 'Tutup',
    cancelButtonColor: '#d33',
    focusConfirm: false,
    preConfirm: () => {
        const selected = document.querySelector('input[name="konfirmasi"]:checked');
        if (!selected || selected.value !== 'ya') {
            Swal.showValidationMessage('Silakan pilih "Ya, saya yakin" untuk melanjutkan.');
            return false;
        }
        return true;
    }
}).then((result) => {
    if (result.isConfirmed) {
        // SweetAlert kedua - Konfirmasi akhir
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Semua poin guru akan direset menjadi 0!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#95a5a6',
            confirmButtonText: 'Ya, Reset Sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim AJAX request reset poin
                $.ajax({
                    url: '/admin/guru/reset-poin',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
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
   getGuru();

   $('#formAbsensiManual').on('submit', function(e) {
    e.preventDefault();
    
    const form = $(this);
    const formData = form.serialize();
  
    $.ajax({
      url: '{{ route("absensi.admin.tambah") }}',
      method: 'POST',
      data: formData,
      success: function(res) {
        // Tutup modal dan kasih notifikasi
        $('#modalAbsensiManual').modal('hide');
        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: 'Absensi berhasil ditambahkan!',
          timer: 1500,
          showConfirmButton: false
        });
        
        // Bisa lo refresh tabel absensi di sini kalau mau
        // contoh: reloadDataAbsensi();
      },
      error: function(xhr) {
        console.error(xhr);
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: 'Terjadi kesalahan saat menyimpan data.'
        });
      }
    });
  });


   $('.select2').select2({
    dropdownParent: $('#modalAbsensiManual'),
    width: '100%'
  });

   $('#filterGrafik').on('change', function () {
    const selected = $(this).val();

    if (selected === 'kompetensi') {
        $('#wrapSubFilter').slideDown();
    } else {
        $('#wrapSubFilter').slideUp();
    }
});

// Trigger saat halaman pertama kali load
$('#filterGrafik').trigger('change');

});

$(document).ready(function() {
  $('#tabel_aspek').DataTable();
});

// Tambahkan variabel global untuk menyimpan ID guru
window.currentGuruId = null;

function viewAspek(row) {
  let data = JSON.parse(row); 
  window.currentGuruId = data.id;
  console.log({
    data_id : data.id , 
    aspek : $('#filterAspek').val() , 
    nama_user : data.nama_user ,
  });
  
    loadAspekData(data.id, $('#filterAspek').val() , data.nama_user);
}

function download(id, dokumen, aspekType) {
    window.open(`/guru/download/${id}/${dokumen}/${aspekType}`, '_blank');
}


function beriNilaiAspek(item , jenis , nama_user) {
  console.log({
    item : item , 
    jenis : jenis , 
    nama_user : nama_user
  });
  if (item.nilai !== null && item.nilai !== '' && item.nilai !== 0) {
    Swal.fire({
      icon: 'info',
      title: 'Poin Sudah Diberikan',
      text: 'Poin telah diberikan sebelumnya dan tidak dapat diubah.',
      confirmButtonText: 'OK'
    });
    return; // Hentikan proses selanjutnya jika nilai sudah ada
  }
  Swal.fire({
    title: 'Tentukan Kelengkapan Dokumen Aspek Guru',
    html: `
    <div class="text-start" style="display: flex; flex-direction: column; gap: 8px;">
      <label style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
        <span style="display: flex; align-items: center; gap: 8px;">
          <input type="radio" name="kelengkapan" value="2">
          File tidak lengkap
        </span>
        <small style="color: gray;">(file kosong)</small>
      </label>
      <label style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
        <span style="display: flex; align-items: center; gap: 8px;">
          <input type="radio" name="kelengkapan" value="5">
          File kurang lengkap
        </span>
        <small style="color: gray;">(file tanpa ttd / stempel kepsek)</small>
      </label>
      <label style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
        <span style="display: flex; align-items: center; gap: 8px;">
          <input type="radio" name="kelengkapan" value="10">
          File lengkap
        </span>
        <small style="color: gray;">(file lengkap)</small>
      </label>
    </div>
  `,  
    showCancelButton: true,
    confirmButtonText: 'Kirim',
    cancelButtonText: 'Batal',
    customClass: {
      actions: 'justify-content-start', // Tombol rata kiri
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const selected = document.querySelector('input[name="kelengkapan"]:checked');
      if (!selected) {
        Swal.fire('Peringatan', 'Silakan pilih salah satu opsi terlebih dahulu.', 'warning');
        return;
      }
      const nilai = selected.value;
      console.log('Nilai dikirim:', nilai);

      // Konfirmasi kedua
      Swal.fire({
        title: 'Konfirmasi',
        text: `Apakah Anda yakin ingin memberikan nilai ${nilai} pada aspek ini?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, kirim',
        cancelButtonText: 'Batal',
      }).then((confirmResult) => {
        if (confirmResult.isConfirmed) {
          
          $.ajax({
            url: '/guru/aspek/nilai' ,
            type: 'POST',
            data: {
                row: item,
                nilai: nilai,
                jenis: jenis,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                  loadAspekData(item.user_id, jenis, nama_user); // sesuaikan nama variabel jika perlu
                  getGuru();
                    Swal.fire(
                        'Berhasil!',
                        'Data berhasil dirubah.',
                        'success'
                    );

                   
                }
            },
            error: function(xhr, status, error) {
                Swal.fire(
                    'Gagal!',
                    'Terjadi kesalahan saat menghapus data.',
                    'error'
                );
            }
        });
          Swal.fire('Terkirim!', 'Nilai berhasil dikirim.', 'success');
        }
      });
    }
  });
}


function loadAspekData(id, aspekType, nama_user) {
  $.ajax({
      url: "/guru/nilaiAspek/" + id,
      type: "GET",
      data: { type: aspekType },
      dataType: "json",
      success: function(response) {
        console.log(response)
          let tbody = "";

          response.forEach(function(item, index) {
              let folder, namaField;

              switch(aspekType) {
                  case '1':
                      folder = 'pedagogik';
                      break;
                  case '2':
                      folder = 'kepribadian';
                      break;
                  case '3':
                      folder = 'profesional';
                      break;
                  case '4':
                      folder = 'sosial';
                      break;
                  default:
                      folder = 'pedagogik';
              }

              let tahun = new Date(item.tanggal).getFullYear();

              tbody += `<tr style="color: black;">
                  <td>${index + 1}</td>
                  <td>${item.guru.nama_user}</td>
                  <td>${item.skor ?? '-'}</td>
                  <td>${item.keterangan ?? '-'}</td>
                  <td>${item.jumlah_siswa ?? '-'}</td>
                  <td>${tahun}</td>
                 
              </tr>`;
          });

          let table = $('#tabel_aspek').DataTable();
          table.clear().destroy();
          $("#tabel_aspek tbody").html(tbody);
          $('#tabel_aspek').DataTable();
          $("#aspekGuru").modal("show");
      },
      error: function(xhr, status, error) {
          console.error("Terjadi kesalahan saat memuat data aspek:", error);
      }
  });
}


// function loadAspekData(id, aspekType, nama_user) {
//   console.log(nama_user);
//   nama_awal = nama_user;
//     $.ajax({
//         url: "/guru/aspek/" + id,
//         type: "GET",
//         data: { type: aspekType },
//         dataType: "json",
//         success: function(response) {
//             let tbody = "";
            
//             response.forEach(function(item, index) {
//                 let namaField;
//                 let typeNumber;
//                 let folder;
//                 switch(aspekType) {
//                     case '1':
//                         namaField = item.nama_pedagogik;
//                         typeNumber = 1;
//                         folder = 'pedagogik';
//                         nama_user = nama_user;
//                         break;
//                     case '2':
//                         namaField = item.nama_kepribadian;
//                         typeNumber = 2;
//                         folder = 'kepribadian';
//                         nama_user = nama_user;
//                         break;
//                     case '3':
//                         namaField = item.nama_profesional;
//                         typeNumber = 3;
//                         folder = 'profesional';
//                         nama_user = nama_user;
//                         break;
//                     case '4':
//                         namaField = item.nama_sosial;
//                         typeNumber = 4;
//                         folder = 'sosial';
//                         nama_user = nama_user;
//                         break;
//                     default:
//                         namaField = item.nama_pedagogik;
//                         typeNumber = 1;
//                         folder = 'pedagogik';
//                         nama_user = nama_user;
//                 }

//               tbody += `<tr style="color: black;">
//                     <td>${index + 1}</td>
//                     <td>${namaField}</td>
//                     <td>${item.dokumen}</td>
//                     <td>${item.nilai == null || item.nilai == '' ? '' : item.nilai}</td>
//                     <td>${formatTanggalIndo(item.tanggal)}</td>
//                     <td>
//                        <div class="btn-group">
//                           <a class="btn btn-primary btn-sm text-light mr-2" target="_blank" href="/storage/${nama_user}/${folder}/${item.dokumen}"><i class="bi bi-download"></i></a>
// <a class="btn btn-warning btn-sm text-light" onclick='beriNilaiAspek(${JSON.stringify(item)} , ${aspekType} , ${JSON.stringify(nama_user)} )' href="javascript:void(0)">
//     <i class="bi bi-pencil-square"></i>
// </a>                       </div>
//                     </td>
//                 </tr>`;
//             });
            
//             let table = $('#tabel_aspek').DataTable();
//             table.clear().destroy();
//             $("#tabel_aspek tbody").html(tbody);
//             $('#tabel_aspek').DataTable();
//             $("#aspekGuru").modal("show");
//         },
//         error: function(xhr, status, error) {
//             console.error("Terjadi kesalahan: ", error);
//         }
//     });
// }

// Event listener untuk perubahan filter tidak perlu diubah karena sudah menggunakan window.currentGuruId
$(document).ready(function() {
    $('#filterAspek').on('change', function() {
        
        if (window.currentGuruId) {
            loadAspekData(window.currentGuruId, $(this).val() , nama_awal);
        }
    });
});
