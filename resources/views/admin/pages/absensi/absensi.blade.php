@extends('admin.layout')

@section('main')
<meta name="absen-hadir-url" content="{{ route('absen.hadir') }}">
<style>
    .bg-hadir { background-color: #4CAF50; color: white; }
    .bg-alpha { background-color: #f44336; color: white; }
    .bg-sakit { background-color: #2196F3; color: white; }
    .bg-izin  { background-color: #FF9800; color: white; }
    .bg-default { background-color: #e0e0e0; color: black; }
</style>

<div class="container">
    <h3 class="mb-4 text-center">Data Absensi Guru - Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</h3>

    <div class="mb-3 text-center">
        <span class="badge bg-success">Hadir</span>
        <span class="badge bg-danger">Alpha</span>
        <span class="badge bg-warning text-dark">Sakit</span>
        <span class="badge bg-primary">Izin</span>
    </div>

    @php
        use Carbon\Carbon;

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $firstDayOfWeek = $startOfMonth->dayOfWeekIso; // Senin = 1, Minggu = 7
        $daysInMonth = $now->daysInMonth;
    @endphp

    <div class="text-center mb-3">
        <button onclick="addAbsensi()" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Absen Hari Ini
        </button>
    </div>

    <div class="d-flex justify-content-center">
        <div class="calendar" style="width: 100%; max-width: 700px;">
            <div class="row fw-bold text-center mb-2">
                @foreach (['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $day)
                    <div class="col border py-2 bg-light">{{ $day }}</div>
                @endforeach
            </div>

            @php
                $dayCounter = 1;
                $printedDays = 0;
            @endphp

            @for ($week = 0; $week < 6 && $dayCounter <= $daysInMonth; $week++)
                <div class="row text-center">
                    @for ($day = 1; $day <= 7; $day++)
                        @php
                            $printedDays++;
                            if ($printedDays < $firstDayOfWeek || $dayCounter > $daysInMonth) {
                                echo '<div class="col border py-3" style="min-height: 70px;"></div>';
                                continue;
                            }

                            $tanggal = $now->format('Y-m') . '-' . str_pad($dayCounter, 2, '0', STR_PAD_LEFT);
                            $status = $absensi[$tanggal] ?? null;
                            $class = match($status) {
                                'hadir' => 'bg-hadir',
                                'alpha' => 'bg-alpha',
                                'sakit' => 'bg-sakit',
                                'izin'  => 'bg-izin',
                                default => 'bg-default',
                            };
                        @endphp
                        <div class="col border py-3 hari {{ $class }}" 
                             data-tanggal="{{ $tanggal }}" 
                             style="min-height: 70px; transition: background-color 0.5s ease;">
                            <div><strong>{{ $dayCounter }}</strong></div>
                            <div>{{ $status ? strtoupper($status[0]) : '-' }}</div>
                        </div>
                        @php $dayCounter++; @endphp
                    @endfor
                </div>
            @endfor
        </div>
    </div>
</div>
<script>

function addAbsensi() {
  let absenUrl = $('meta[name="absen-hadir-url"]').attr('content');

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        let lat = position.coords.latitude.toFixed(8);
        let lng = position.coords.longitude.toFixed(8);
        let accuracy = position.coords.accuracy; // meter

        // Cek akurasi lokasi
        if (accuracy > 50) {
          Swal.fire({
            icon: 'warning',
            title: 'Lokasi Kurang Akurat',
            text: 'Akurasi lokasi: ' + accuracy.toFixed(2) + ' meter. Pastikan GPS aktif dan coba lagi di area terbuka.',
            confirmButtonText: 'Coba Lagi'
          });
          return;
        }

        $.ajax({
          url: absenUrl,
          type: "POST",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            lat: lat,
            lng: lng
          },
          success: function (response) {
            if (response.status === 'already') {
              Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: response.message || 'Anda sudah absen hari ini.',
                timer: 2500,
                showConfirmButton: false
              });
              return;
            }

            if (response.status === 'error') {
              Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: response.message || 'Anda berada di luar area sekolah.',
                timer: 3000,
                showConfirmButton: true
              });
              return;
            }

            if (response.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: response.message || 'Absensi berhasil dicatat.',
                timer: 2000,
                showConfirmButton: false
              });

              // Update tampilan kalender
              let today = new Date().toISOString().split('T')[0];
              let el = $(`.hari[data-tanggal="${today}"]`);
              if (el.length) {
                el.removeClass('bg-default bg-alpha bg-sakit bg-izin')
                  .addClass('bg-hadir')
                  .find('div:last').text('H');
              }
            }
          },
          error: function (xhr) {
            Swal.fire({
              icon: 'error',
              title: 'Gagal!',
              text: xhr.responseJSON?.message || 'Terjadi kesalahan saat melakukan absensi.',
              timer: 2500,
              showConfirmButton: false
            });
          }
        });
      },
      function () {
        Swal.fire({
          icon: 'error',
          title: 'Lokasi Tidak Ditemukan',
          text: 'Pastikan GPS aktif dan izin lokasi diberikan.',
          timer: 3000,
          showConfirmButton: true
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
      title: 'Browser Tidak Mendukung',
      text: 'Perangkat Anda tidak mendukung fitur lokasi.',
      timer: 3000,
      showConfirmButton: true
    });
  }
}



</script>
@endsection
