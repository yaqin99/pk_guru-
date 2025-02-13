function viewProfile(id){
    $.ajax({
        url: "/admin/profile/" + id,
        type: "GET",
        dataType: "json",
        success: function(response){
            console.log(response);
            $('#nama_profil').val(response.nama_user).data('user-id', id);
            $('#email_profil').val(response.email);
            // $('#username_profil').val(response.username);
            $('#no_telp_profil').val(response.no_hp);
            $('#alamat_profil').val(response.alamat);
            // $('#password_profil').val(response.password);
            $('#modalProfil').modal('show');
            // Load data aspek default (pedagogik)
            loadAspekDataProfil(id, '1');
        }
    });
}

function editProfile(){
    let data = JSON.parse(row);
    console.log(data);
}

function changePassword(){
    let data = JSON.parse(row);
    console.log(data);
}

$(document).ready(function() {
    $('#filterAspekProfil').on('change', function() {
        let userId = $('#nama_profil').data('user-id'); // Pastikan untuk menyimpan user_id saat viewProfile
        if (userId) {
            loadAspekDataProfil(userId, $(this).val());
        }
    });
});

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



