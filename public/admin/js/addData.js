$(document).ready(function (){

  $('#simpan').click(function(e) {
    e.preventDefault();
    $('#addGuru').modal({"backdrop": "static"});

    //define variable
    let nama       = $('#nama').val();
    let nip        = $('#nip').val();
    let no_hp      = $('#no_hp').val();
    let alamat     = $('#alamat').val();
    let email      = $('#email').val();
    let mapel_add  = $('#mapel_add').val();
    let kelas_add  = $('#kelas_add').val();
    let username   = $('#username').val();
    let password   = $('#password').val();

    // field baru
    let tempat     = $('#tempat').val();
    let tanggal_lahir = $('#tanggal_lahir').val();
    let status_kepegawaian = $('#status_kepegawaian').val();

    let data = {
        _token: $('#token').val(),
        nama : nama , 
        nip : nip , 
        no_hp : no_hp , 
        alamat : alamat , 
        email : email , 
        mapel : mapel_add , 
        kelas : kelas_add , 
        username : username , 
        password : password , 
        tempat: tempat,
        tanggal_lahir: tanggal_lahir,
        status_kepegawaian: status_kepegawaian
    };

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "Konfirmasi Penambahan Data?",
        text: "Data Akan Langsung Ditambahkan Pada Tabel!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Simpan",
        cancelButtonText: "Batal",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/addGuru`,
                type: "POST",
                cache: false,
                data: data,
                success:function(response){
                    swalWithBootstrapButtons.fire({
                        title: "Berhasil!",
                        text: "Data Guru Telah Ditambahkan",
                        icon: "success"
                    });

                    // reset semua field termasuk yang baru
                    $('#nama').val('');
                    $('#nip').val('');
                    $('#no_hp').val('');
                    $('#alamat').val('');
                    $('#email').val('');
                    $('#username').val('');
                    $('#password').val('');
                    $('#mapel_add').val('');
                    $('#kelas_add').val('');
                    $('#tempat').val('');
                    $('#tanggal_lahir').val('');
                    $('#status_kepegawaian').val('');
                    
                    getGuru();
                },
                error:function(error){
                    console.error(error);
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // reset semua field termasuk yang baru
            $('#nama').val('');
            $('#nip').val('');
            $('#no_hp').val('');
            $('#alamat').val('');
            $('#email').val('');
            $('#mapel_add').val('');
            $('#kelas_add').val('');
            $('#username').val('');
            $('#password').val('');
            $('#tempat').val('');
            $('#tanggal_lahir').val('');
            $('#status_kepegawaian').val('');

            swalWithBootstrapButtons.fire({
                title: "Batal",
                text: "Data Guru Tidak Ditambah",
                icon: "error"
            });
        }
    });
});


})