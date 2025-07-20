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
                                        <label><strong>Mata Pelajaran</strong></label>
                                        <select name="mapel_id" id="mapel_id" class="form-control" required>
                                            <option value="">-- Pilih Mata Pelajaran --</option>
                                            @foreach($mapels as $mapel)
                                                <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label><strong>Kelas</strong></label>
                                        <select name="kelas" id="kelas" class="form-control" required>
                                            <option value="">-- Pilih Kelas --</option>
                                            <option value="1">10</option>
                                            <option value="2">11</option>
                                            <option value="3">12</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label><strong>Guru yang Dinilai</strong></label>
                                        <select name="guru_id_penilaian" id="guru_id_penilaian" class="form-control" required>
                                            <option value="">-- Pilih Guru --</option>
                                            {{-- akan terisi otomatis via JS --}}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
     $(document).ready(function() {
        $('#guru').select2();
        $('#siswa').select2();
        $('#mapel').select2();

        $('#formPenilaian').on('submit', function(e) {
        e.preventDefault(); // ✅ Mencegah form submit default (POST ke /penilaian)

        showPenilaianModal(); 
        
        });

        $('#mapel_id, #kelas').on('change', function () {
        let mapelId = $('#mapel_id').val();
        let kelas = $('#kelas').val();

        if (mapelId && kelas) {
            $.ajax({
                url: '/get-guru-by-mapel-kelas',
                type: 'GET',
                data: {
                    mapel_id: mapelId,
                    kelas: kelas
                },
                success: function (response) {
                    $('#guru_id_penilaian').empty().append('<option value="">-- Pilih Guru --</option>');

                    if (response.length > 0) {
                        $.each(response, function (index, guru) {
                            $('#guru_id_penilaian').append(
                                `<option value="${guru.id}">${guru.nama_user}</option>`
                            );
                        });
                    } else {
                        $('#guru_id_penilaian').append('<option value="">Tidak ada guru ditemukan</option>');
                    }
                },
                error: function () {
                    alert('Gagal mengambil data guru');
                }
            });
        } else {
            $('#guru_id_penilaian').empty().append('<option value="">-- Pilih Guru --</option>');
        }
    });
        
    });

    function tutupPenilaian(){
        $('#modalPenilaian').modal('hide');

    }

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    function showPenilaianModal() {
    // Ambil nilai input
    let siswa = $('#siswa').val();
    let guru = $('#guru_id_penilaian').val();
    let mapel = $('#mapel_id').val();
    let kelas = $('#kelas').val();
    let password = $('#passwordSiswa').val();

    // Debugging ke console (bisa dihapus kalau tidak perlu)
    console.log({ siswa, guru, mapel, kelas, password });

    // Validasi: jika ada yang kosong, munculkan peringatan
    if (!siswa || !guru || !mapel || !kelas || !password) {
        Swal.fire({
            icon: 'warning',
            title: 'Lengkapi Data',
            text: 'Sebelum menilai, tolong lengkapi semua data terlebih dahulu.',
            confirmButtonText: 'Oke, saya mengerti'
        });
        return;
    }

    // Kirim AJAX jika valid
    $.ajax({
        url: '/openPenilaian',
        type: 'POST',
        data: {
            siswa: siswa,
            guru: guru,
            mapel: mapel,
            kelas: kelas,
            password: password
        },
        success: function(response) {
            if (response.success) {
                // Masukkan ID siswa dan guru ke input hidden di modal
                $('#user_id').val(response.siswa_id);
                $('#guru_id').val(response.guru_id);
                // Tampilkan modal penilaian
                $('#modalPenilaian').modal('show');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Gagal',
                    text: response.message || 'Password salah atau siswa tidak ditemukan.'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); // Debug error ke console
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Gagal mengirim data. Silakan coba lagi.'
            });
        }
    });
}


function addPenilaian() {
    const siswa_id = $('#user_id').val();
    const guru_id = $('#guru_id').val();
    const tipe_aspek = $('#filterAspekPenilaian').val();
    const _token = $('meta[name="csrf-token"]').attr('content');

    let dataPenilaian = [];

    // Ambil semua radio yang terpilih berdasarkan name
    $('#tabel_komponen_aspek tr').each(function(index, row) {
    const selected = $(row).find('input[type="radio"]:checked');

    if (selected.length > 0) {
        const nilai = selected.val();
        const komponenText = $(row).find('td:nth-child(2)').text().trim();
        const id_komponen = $(row).find('input[type="hidden"][name="id_komponen"]').val();

        dataPenilaian.push({
            id_komponen: id_komponen,
            nama_komponen: komponenText,
            nilai: nilai,
            tipe_aspek: tipe_aspek
        });
    }
});

    // Validasi jika ada komponen yang belum diisi
    const jumlahKomponen = $('#tabel_komponen_aspek tr').length;
    if (dataPenilaian.length < jumlahKomponen) {
        Swal.fire('Peringatan', 'Masih ada komponen yang belum dinilai!', 'warning');
        return;
    }

    // Kirim data ke server
    $.ajax({
    url: `/penilaianMethod`,
    type: "POST",
    data: {
        siswa_id: siswa_id,
        guru_id: guru_id,
        tipe_aspek: $('#filterAspekPenilaian').val(), // pastikan ini dikirim juga
        penilaian: dataPenilaian,
        _token: _token
    },
    success: function(response) {
        if (response.success) {
            Swal.fire('Berhasil', 'Penilaian berhasil disimpan!', 'success');
            $('#modalPenilaian').modal('hide');
            $('#formPenilaianSiswa')[0].reset();
        } else if (response.status === 'already_rated') {
            Swal.fire({
                icon: 'warning',
                title: 'Sudah Dinilai',
                html: `Anda sudah menilai guru ini untuk aspek <strong>${response.tipe}</strong> pada tahun <strong>${response.tahun}</strong>. Silakan coba lagi tahun depan.`,
            });
        } else {
            Swal.fire('Gagal', response.message || 'Terjadi kesalahan.', 'error');
        }
    },
    error: function(xhr) {
        Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan penilaian.', 'error');
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
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            let html = '';
            response.forEach((item, index) => {
                html += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>
                            ${item.nama_komponen}
                            <input type="hidden" name="id_komponen" value="${item.id}" />
                        </td>
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
        error: function(xhr) {
            Swal.fire('Gagal', 'Terjadi kesalahan saat mengambil data!', 'error');
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