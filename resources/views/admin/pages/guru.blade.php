@extends('admin.layout')
@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <h2 class="card-title ">Data Guru</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabel_guru" class="display" style="width:100%; align-item:center;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>Nip</th>
                                <th>Nomer Handphone</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Kelas</th>
                                <th>Mapel</th>
                                <th>Poin</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
   
</div>
<script>



function dataKemajuanSekolah() {
    const tahun = $('#filterTahun').val();
    $('#kemajuanSekolah').modal('show');

    $.ajax({
        url: '/sekolah/grafik',
        type: 'GET',
        data: { tahun: tahun },
        dataType: 'json',
        success: function(response) {
            // Hapus chart lama
            [window.chartMurid, window.chartGuru, window.chartStatusGuru].forEach(c => {
    if (c instanceof Chart) c.destroy();
});

            // === Chart Murid (Line Gradient) ===
            const ctxMurid = document.getElementById('chartMurid').getContext('2d');
            const gradientMurid = ctxMurid.createLinearGradient(0, 0, 0, 300);
            gradientMurid.addColorStop(0, 'rgba(54, 162, 235, 0.6)');
            gradientMurid.addColorStop(1, 'rgba(54, 162, 235, 0)');

            chartMurid = new Chart(ctxMurid, {
                type: 'line',
                data: {
                    labels: response.siswa_per_tahun.labels,
                    datasets: [{
                        label: 'Jumlah Murid',
                        data: response.siswa_per_tahun.data,
                        fill: true,
                        backgroundColor: gradientMurid,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                },
                options: { responsive: true }
            });

            // === Chart Guru (Line Gradient) ===
            const ctxGuru = document.getElementById('chartGuru').getContext('2d');
            const gradientGuru = ctxGuru.createLinearGradient(0, 0, 0, 300);
            gradientGuru.addColorStop(0, 'rgba(255, 99, 132, 0.6)');
            gradientGuru.addColorStop(1, 'rgba(255, 99, 132, 0)');

            chartGuru = new Chart(ctxGuru, {
                type: 'line',
                data: {
                    labels: response.guru_per_tahun.labels,
                    datasets: [{
                        label: 'Jumlah Guru',
                        data: response.guru_per_tahun.data,
                        fill: true,
                        backgroundColor: gradientGuru,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                },
                options: { responsive: true }
            });

            // === Chart Status Guru (Pie) ===
            const ctxStatus = document.getElementById('chartStatusGuru').getContext('2d');
            chartStatusGuru = new Chart(ctxStatus, {
                type: 'pie',
                data: {
                    labels: Object.keys(response.status_guru),
                    datasets: [{
                        data: Object.values(response.status_guru),
                        backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
                    }]
                },
                options: { responsive: true }
            });

            // === Indeks Kemajuan ===
            const muridTahunTerbaru = response.siswa_per_tahun.data.slice(-1)[0];
            const muridTahunLalu = response.siswa_per_tahun.data.slice(-2)[0];
            const guruTahunTerbaru = response.guru_per_tahun.data.slice(-1)[0];
            const guruTahunLalu = response.guru_per_tahun.data.slice(-2)[0];

            let indeks = 'Tetap';
            if (muridTahunTerbaru > muridTahunLalu && guruTahunTerbaru >= guruTahunLalu) {
                indeks = 'Meningkat';
                $('#indeksKemajuan').css('background', '#d4edda').css('color', '#155724');
            } else if (muridTahunTerbaru < muridTahunLalu) {
                indeks = 'Menurun';
                $('#indeksKemajuan').css('background', '#f8d7da').css('color', '#721c24');
            }

            $('#indeksKemajuan').text(indeks);
        }
    });
}


function setLokasiSekolah() {
  Swal.fire({
    icon: 'warning',
    title: 'Atur Lokasi Sekolah',
    text: 'Dengan melakukan aksi ini akan mengatur lokasi sekolah di lokasi Anda saat ini. Guru hanya akan bisa absen tidak lebih dari 20 meter dari lokasi ini.',
    showCancelButton: true,
    confirmButtonText: 'Ya, atur lokasi',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function (position) {
            let accuracy = position.coords.accuracy; // akurasi dalam meter
            let lat = position.coords.latitude.toFixed(8);
            let lng = position.coords.longitude.toFixed(8);

            // Kalau akurasi di atas 50 meter, kasih peringatan
            if (accuracy > 50) {
              Swal.fire({
                icon: 'warning',
                title: 'Lokasi Kurang Akurat',
                text: 'Akurasi lokasi: ' + accuracy.toFixed(2) + ' meter. Coba nyalakan GPS atau pindah ke area terbuka.',
                confirmButtonText: 'Coba Lagi'
              });
              return;
            }

            $.ajax({
              url: '/admin/lokasi-sekolah/set',
              type: 'POST',
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {
                lat: lat,
                lng: lng
              },
              success: function () {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil!',
                  text: 'Lokasi sekolah berhasil disimpan.',
                  timer: 2000,
                  showConfirmButton: false
                });
              },
              error: function () {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal!',
                  text: 'Tidak dapat menyimpan lokasi sekolah.'
                });
              }
            });
          },
          function () {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'Gagal mendapatkan lokasi. Pastikan GPS aktif dan izin lokasi diberikan.'
            });
          },
          {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
          }
        );
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Browser Anda tidak mendukung Geolocation.'
        });
      }
    }
  });
}



function tambahAbsensiGuru() {
  // Reset value inputan di modal
  $('#modalAbsensiManual select[name="user_id"]').val('').trigger('change');
  $('#modalAbsensiManual select[name="keterangan"]').val('').trigger('change');

  // Tampilkan modal
  $('#modalAbsensiManual').modal('show');

  // Inisialisasi ulang select2 setelah modal muncul
  setTimeout(() => {
      $('#modalAbsensiManual .select2').select2({
          dropdownParent: $('#modalAbsensiManual'),
          width: '100%'
      });
  }, 300); // Tunggu sedikit biar modal ke-render sempurna
}

function submitAbsensiManual() {
  var form = $('#formAbsensiManual');
  var formData = form.serialize();

  $.ajax({
    url: '/admin/absensi/tambah',
    type: 'POST',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: formData,
    success: function(response) {
      if (response.success) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: response.message || 'Absensi berhasil disimpan.',
          confirmButtonText: 'OK'
        }).then(() => {
          // Tutup modal
          $('#modalAbsensiManual').modal('hide');
          
          // Reset form
          form[0].reset();

          // Reload DataTable jika ada
          if ($.fn.DataTable.isDataTable('#tabel_absensi')) {
            $('#tabel_absensi').DataTable().ajax.reload();
          }
        });
      } else {
        Swal.fire({
          icon: 'warning',
          title: 'Gagal!',
          text: response.message || 'Gagal menyimpan absensi.'
        });
      }
    },
    error: function(xhr) {
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'Terjadi kesalahan saat menyimpan absensi.'
      });
    }
  });
}
</script>
@include('admin.modals.guru.aspek')
@include('admin.modals.guru.penilaian')
@include('admin.modals.guru.grafik')
@include('admin.modals.addGuru')
@include('admin.modals.editGuru')
@include('admin.modals.guru.addAbsensi')
@include('admin.modals.guru.kemajuan')
@endsection