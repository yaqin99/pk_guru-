$(document).ready(function (){

    $('#simpan').click(function(e) {
        e.preventDefault();
        $('#addGuru').modal({"backdrop": "static"})

        //define variable
        let nama   = $('#nama').val();
        let nip   = $('#nip').val();
        let no_hp   = $('#no_hp').val();
        let alamat   = $('#alamat').val();
        let email   = $('#email').val();
        let username   = $('#username').val();
        let password   = $('#password').val();
        
        let data = {
            _token: $('#token').val(),
            nama : nama , 
            nip : nip , 
            no_hp : no_hp , 
            alamat : alamat , 
            email : email , 
            username : username , 
            password : password , 

        }
        //ajax
        



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
                          $('#nama').val('');
                          $('#nip').val('');
                          $('#no_hp').val('');
                          $('#alamat').val('');
                          $('#email').val('');
                          $('#username').val('');
                          $('#password').val('');
                           getGuru()
                    },
                    error:function(error){
                        
                      
        
                    }
        
                });
    
    
              
            } else if (
              /* Read more about handling dismissals below */
              result.dismiss === Swal.DismissReason.cancel
            ) {
              $('#nama').val('');
              $('#nip').val('');
              $('#no_hp').val('');
              $('#alamat').val('');
              $('#email').val('');
              $('#username').val('');
              $('#password').val('');
              swalWithBootstrapButtons.fire({
                title: "Batal",
                text: "Data Guru Tidak Ditambah",
                icon: "error"
              });
            }
          });


    });

})