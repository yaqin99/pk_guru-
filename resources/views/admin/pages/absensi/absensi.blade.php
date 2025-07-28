@extends('admin.layout')

@section('main')
<meta name="absen-hadir-url" content="{{ route('absen.hadir') }}">
<style>
    .bg-hadir { background-color: #4CAF50; color: white; }   /* Hijau */
    .bg-alpha { background-color: #f44336; color: white; }   /* Merah */
    .bg-sakit { background-color: #2196F3; color: white; }   /* Biru */
    .bg-izin  { background-color: #FF9800; color: white; }   /* Oranye */
    .bg-default { background-color: #e0e0e0; color: black; } /* Default abu */
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
                                'hadir' => 'bg-success text-white',
                                'alpha' => 'bg-transparent text-white',
                                'sakit' => 'bg-warning text-dark',
                                'izin'  => 'bg-primary text-white',
                                default => '',
                            };
                        @endphp
                        <div class="col border py-3 {{ $class }}" style="min-height: 70px;">
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
@endsection
