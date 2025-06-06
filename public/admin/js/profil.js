function viewProfile(id){
    $.ajax({
        url: "/admin/profile/" + id,
        type: "GET",
        dataType: "json",
        success: function(response){
            console.log(response);
            $('#modalProfil').modal('show');

            $('#nama_profil').val(response.nama_user).data('user-id', id);
            $('#email_profil').val(response.email);
            // $('#username_profil').val(response.username);
            $('#no_telp_profil').val(response.no_hp);
            $('#alamat_profil').val(response.alamat);
            // $('#password_profil').val(response.password);
            
           
            if(response.foto != null) {
                $('#foto_profil').attr('src', `/storage/${response.nama_user}/fotoProfil/${response.foto}`);
            } 
            if (response.role == 2 || response.role == 3) {
                $('#aspekSection').hide();
            }
            // Load data aspek default (pedagogik)
            $('#user_id').val(id);
            loadAspekDataProfil(id, '1');
        }
    });
}

function cekAspek() {
    const jenisAspek = document.getElementById("jenis_aspek").value;
    const tahun = new Date().getFullYear(); // Atau ambil dari input lain
    const userId = $('#user_id_cek'); // Ganti dengan user ID aktif, bisa didapat via blade / session
    
    $.ajax({
        url: "guru/aspek/cekAspek",
        type: "POST",
        data: {
            jenis : jenisAspek , 
            tahun : tahun , 
            user_id : userId ,
        } , 
        dataType: "json",
        success: function(response){
            console.log(response);
           
        }
    });

   
  }
  

function updateProfile() {
    let formData = new FormData($('#formProfil')[0]);
    let userId = $('#nama_profil').data('user-id');
    formData.append('user_id', userId);

    $.ajax({
        url: '/admin/profile/update',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message
                });
                
                viewProfile(userId);
            }
        },
        error: function(xhr, status, error) {
            let errorMessage = 'Terjadi kesalahan saat memperbarui profil';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: errorMessage
            });
        }
    });
}

// Update preview foto saat file dipilih
$('#upload_foto').on('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#foto_profil').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    }
});

function changePassword(){
    let data = JSON.parse(row);
    console.log(data);
}

$(document).ready(function() {
    $('#filterAspekProfil').on('change', function() {
        let userId = $('#nama_profil').data('user-id');
        if (userId) {
            loadAspekDataProfil(userId, $(this).val());
        }
    });

    $('#formTambahAspek').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let userId = $('#nama_profil').data('user-id');
        formData.append('user_id', userId);

        $.ajax({
            url: '/guru/aspek/store',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success == true) {  
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data aspek berhasil ditambahkan'
                    });
                    $('#modalTambahAspek').modal('hide');
                    $('#formTambahAspek')[0].reset();
                    // Reload tabel aspek
                    loadAspekDataProfil(userId, $('#filterAspekProfil').val());
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat menambahkan data'
                });
            }
        });
    });

    // Ketika modal tambah aspek ditutup, reset form
    $('#modalTambahAspek').on('hidden.bs.modal', function () {
        $('#formTambahAspek')[0].reset();
    });

    // Handler untuk perubahan file
    $('#file_aspek').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $('#file_name').val(fileName);
    });

    // Handler untuk upload foto


    // Hover effect untuk foto profil
    $('label[for="upload_foto"]').hover(
        function() {
            $(this).find('.position-absolute').css('opacity', '1');
            $(this).find('img').css('opacity', '0.7');
        },
        function() {
            $(this).find('.position-absolute').css('opacity', '0');
            $(this).find('img').css('opacity', '1');
        }
    );
});

function formatTanggalIndo(tanggal) {
  const hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  const bulan = [
    'Januari','Februari','Maret','April','Mei','Juni',
    'Juli','Agustus','September','Oktober','November','Desember'
  ];

  const date = new Date(tanggal);
  const namaHari = hari[date.getDay()];
  const namaBulan = bulan[date.getMonth()];
  const tgl = date.getDate();
  const tahun = date.getFullYear();

  return `${namaHari}, ${tgl} ${namaBulan} ${tahun}`;
}

function loadAspekDataProfil(id, aspekType) {
    $.ajax({
        url: "/guru/aspek/" + id,
        type: "GET",
        data: { type: aspekType },
        dataType: "json",
        success: function(response) {
            let tbody = "";
            let nama_user = $('#nama_profil').val();
            
            response.forEach(function(item, index) {
                let namaField;
                let folder;
                switch(aspekType) {
                    case '1':
                        namaField = item.nama_pedagogik;
                        folder = 'pedagogik';
                        break;
                    case '2':
                        namaField = item.nama_kepribadian;
                        folder = 'kepribadian';
                        break;
                    case '3':
                        namaField = item.nama_profesional;
                        folder = 'profesional';
                        break;
                    case '4':
                        namaField = item.nama_sosial;
                        folder = 'sosial';
                        break;
                    default:
                        namaField = item.nama_pedagogik;
                        folder = 'pedagogik';
                }

                tbody += `<tr style="color: black;">
                    <td>${index + 1}</td>
                    <td>${namaField}</td>
                    <td>${item.dokumen}</td>
                    <td>${item.nilai === null || item.nilai === '' ? '' : item.nilai}</td>
                    <td>${formatTanggalIndo(item.tanggal)}</td>
                    <td>
                       <div class="btn-group">
                          <button class="btn btn-warning btn-sm" onclick="editAspek(${JSON.stringify(item).replace(/"/g, '&quot;')}, '${aspekType}')">
                            <i class="bi bi-pencil"></i>
                          </button>
                          <button class="btn btn-danger btn-sm ml-1" onclick="deleteAspek(${JSON.stringify(item).replace(/"/g, '&quot;')}, '${aspekType}')">
                            <i class="bi bi-trash"></i>
                          </button>
                       </div>
                    </td>
                </tr>`;
            });
            
            let table = $('#tabel_aspek_profil').DataTable();
            table.clear().destroy();
            $("#tabel_aspek_profil tbody").html(tbody);
            $('#tabel_aspek_profil').DataTable();
        },
        error: function(xhr, status, error) {
            console.error("Terjadi kesalahan: ", error);
        }
    });
}

function editAspek(item, aspekType) {
    console.log(item.tanggal)
    $('#tanggal').val(item.tanggal);
    $('#modalTambahAspek').modal('show');
    $('#jenis_aspek').val(aspekType);
    $('#aspek_id').val(item.id);
    if(aspekType == 1){
        $('#keterangan_aspek').val(item.nama_pedagogik);
    }else if(aspekType == 2){
        $('#keterangan_aspek').val(item.nama_kepribadian);
    }else if(aspekType == 3){
        $('#keterangan_aspek').val(item.nama_profesional);
    }else if(aspekType == 4){
        $('#keterangan_aspek').val(item.nama_sosial);
    }
    // Update file name display
    $('#file_name').val(item.dokumen);
    
    // File tidak wajib saat edit
    $('#file_aspek').prop('required', false);
    
    // Disable jenis aspek saat edit
    $('#jenis_aspek').attr('disabled', true);
}

function deleteAspek(row, aspekType) {
   console.log(row);
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/guru/aspek/delete' ,
                type: 'POST',
                data: {
                    row: row,
                    aspekType: aspekType,
                   
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        Swal.fire(
                            'Terhapus!',
                            'Data berhasil dihapus.',
                            'success'
                        );
                        // Reload tabel
                        let userId = $('#nama_profil').data('user-id');
                        loadAspekDataProfil(userId, aspekType);
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
        }
    });
}

// Modifikasi fungsi simpanAspek untuk menangani edit dan tambah
function simpanAspek() {
    let formData = new FormData($('#formTambahAspek')[0]);
    let userId = $('#nama_profil').data('user-id');
    let aspekId = $('#aspek_id').val();
    let aspekType = $('#jenis_aspek').val();
    let url =  '/guru/aspek/store';
    let method = aspekId ? 'POST' : 'POST';

    // Pastikan user_id ditambahkan ke formData
    formData.append('user_id', userId);
    formData.append('jenis_aspek', aspekType);

    $.ajax({
        url: url,
        type: method,
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: aspekId ? 'Data aspek berhasil diperbarui' : 'Data aspek berhasil ditambahkan'
                });
                $('#modalTambahAspek').modal('hide');
                $('#formTambahAspek')[0].reset();
                $('#file_info').remove();
                $('#aspek_id').val('');
                $('#file_aspek').prop('required', true);
                loadAspekDataProfil(userId, $('#filterAspekProfil').val());
            }
        },
        error: function(xhr, status, error) {
            if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.status === 'duplikat') {
                let jenisAspek = $('#jenis_aspek option:selected').text(); // ambil label aspek
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Duplikat',
                    html: `Data aspek <b>${jenisAspek}</b> sudah pernah ditambahkan untuk tahun pelajaran ini.<br>Setiap aspek hanya dapat ditambahkan <b>1 kali per tahun</b>.`
                });
            } else {
                console.log(status, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat menyimpan data.'
                });
            }
        }
    });
    
}

// Modifikasi reset form
$('#modalTambahAspek').on('hidden.bs.modal', function () {
    $('#formTambahAspek')[0].reset();
    $('#file_name').val('');
    $('#aspek_id').val('');
    $('#file_aspek').prop('required', true);
    $('#jenis_aspek').attr('disabled', false);
});

function showModalTambahAspek(user_id) {
    // Reset form dan tampilkan modal
    $('#formTambahAspek')[0].reset();
    $('#file_name').val('');
    $('#user_id_cek').val(user_id);
    $('#aspek_id').val('');
    $('#file_aspek').prop('required', true);
    $('#jenis_aspek').attr('disabled', false);
    
    // Set jenis aspek sesuai dengan yang dipilih di filter
    $('#jenis_aspek').val($('#filterAspekProfil').val());
    
    // Tampilkan modal
    $('#modalTambahAspek').modal('show');
}
