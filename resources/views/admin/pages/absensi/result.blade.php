<!DOCTYPE html>
<html>
<head>
    <title>Hasil Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1 class="mb-4">
            @if($status === 'success')
                ✅ {{ $message }}
            @else
                ⚠️ {{ $message }}
            @endif
        </h1>
        <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
    </div>
</body>
</html>