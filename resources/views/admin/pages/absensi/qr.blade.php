<!DOCTYPE html>
<html>
<head>
    <title>QR Absensi Guru</title>
</head>
<body style="text-align:center; font-family:sans-serif;">
    <h2>Scan untuk Absen</h2>
    <p>Scan QR ini menggunakan HP yang sudah login ke sistem</p>
    <div>
        {!! QrCode::size(300)->generate(route('absen.scan')) !!}
    </div>
    <p><strong>{{ route('absen.scan') }}</strong></p>
</body>
</html>