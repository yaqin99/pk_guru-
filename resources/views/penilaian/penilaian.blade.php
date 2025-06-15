<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PK Guru Al - Ghazali</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/admin/images/yala.png">
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                  <div class="d-flex justify-content-center">
                                      <img src="/admin/images/yala.png" alt="" style=" 
                                        max-width:35% ; 
                                        max-height:100% ; 
                                        ">
                                  </div>
                                  <form id="formPenilaian" method="POST">
                                    @csrf
                                
                                    <div class="form-group">
                                        <label><strong>Nama Siswa</strong></label>
                                        <select name="siswa_id" id="siswa" class="form-control" required>
                                            <option value="">-- Pilih Siswa --</option>
                                            @foreach($siswas as $siswa)
                                                <option value="{{ $siswa->id }}">{{ $siswa->nama_siswa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div class="form-group">
                                        <label><strong>Guru yang Dinilai</strong></label>
                                        <select name="guru_id" id="guru" class="form-control" required>
                                            <option value="">-- Pilih Guru --</option>
                                            @foreach($gurus as $guru)
                                                <option value="{{ $guru->id }}">{{ $guru->nama_user }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div class="form-group">
                                        <label><strong>Password</strong></label>
                                        <input type="text" name="password" id="passwordSiswa" class="form-control" required>
                                    </div>
                                
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary btn-block" onclick="showPenilaianModal()">Konfirmasi</button>
                                    </div>
                                </form>
                                
                                    <div class="new-account mt-3">
                                        {{-- <p>Don't have an account? <a class="text-primary" href="./page-register.html">Sign up</a></p> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('penilaian.modalPenilaian')

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
     $(document).ready(function() {
        $('#guru').select2();
        $('#siswa').select2();

        $('#formPenilaian').on('submit', function(e) {
        e.preventDefault(); // ✅ Mencegah form submit default (POST ke /penilaian)

        showPenilaianModal(); // Panggil fungsi Ajax kamu
    });
        
    });

    function tutupPenilaian(){
        $('#modalPenilaian').modal('hide');

    }

    function showPenilaianModal() {
    let siswa = $('#siswa').val();
    let guru = $('#guru').val();
    let password = $('#passwordSiswa').val();
    $.ajax({
        url: `/openPenilaian`, // ✅ Harus sesuai route POST
        type: "POST",
        cache: false,
        data: {
            siswa: siswa,
            guru: guru,
            password: password,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response)
            if (response.success) {
                // Simpan ID siswa & guru jika ingin digunakan nanti
                $('#user_id').val(response.siswa_id);
                $('#guru_id').val(response.guru_id);

                // Tampilkan modal penilaian
                $('#modalPenilaian').modal('show');
            } else {
                console.log('gagal');
            }
        },
        error: function() {
            Swal.fire('Gagal', 'Terjadi kesalahan saat mengirim data.', 'error');
        }
    });
}


    function getKomponen(tipe) {
    $.ajax({
        url: `/getKomponen`,
        type: "POST",
        cache: false,
        data: {
            tipe: tipe,
            _token: $('meta[name="csrf-token"]').attr('content') // pastikan ada meta csrf di head
        },
        success: function(response) {
            console.log(response)
            let html = '';
            response.forEach((response, index) => {
                html += `
                   <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${response.nama_komponen}</td>
                        <td class="text-center">
                            <label>
                                <input type="radio" name="penilaian[${index}]" value="0"> 
                                <br>
                                <small>Tidak ada bukti<br>(tidak terpenuhi)</small>
                            </label>
                        </td>
                        <td class="text-center">
                            <label>
                                <input type="radio" name="penilaian[${index}]" value="1"> 
                                <br>
                                <small>Terpenuhi Sebagian</small>
                            </label>
                        </td>
                        <td class="text-center">
                            <label>
                                <input type="radio" name="penilaian[${index}]" value="2"> 
                                <br>
                                <small>Seluruhnya Terpenuhi</small>
                            </label>
                        </td>
                    </tr>

                `;
            });
            $('#tabel_komponen_aspek').html(html);
        },
        error: function(error) {
            showNotification('Gagal', 'Terjadi kesalahan saat mengambil data!', 'error');
        }
    });
}

// Ketika dropdown filter tipe aspek berubah
$('#filterAspekPenilaian').on('change', function () {
    const tipe = $(this).val();
    getKomponen(tipe);
});

// Ketika modal pertama kali dibuka, langsung tampilkan tipe 1
$('#modalPenilaian').on('shown.bs.modal', function () {
    $('#filterAspekPenilaian').val(1).trigger('change');
});

    </script>
</body>

</html>