function editGuru (data){
    let fixedData =  JSON.parse(data)
    $('#editGuru').modal('show')

    $('#nama_edit').val(fixedData.nama_user);
    $('#nip_edit').val(fixedData.nip);
    $('#no_hp_edit').val(fixedData.no_hp);
    $('#alamat_edit').val(fixedData.alamat);
    $('#email_edit').val(fixedData.email);
    $('#id_guru').val(fixedData.id);
   
    

}
$(document).ready(function (){

    $('#simpan_edit').click(function(e) {
        e.preventDefault();

        //define variable
       let nama = $('#nama_edit').val();
       let nip =   $('#nip_edit').val();
       let no_hp = $('#no_hp_edit').val();
       let alamat =  $('#alamat_edit').val();
       let email = $('#email_edit').val();
       let id =  $('#id_guru').val();
        
        let data = {
            _token: $('#tokenEdit').val(),
            nama : nama , 
            nip : nip , 
            no_hp : no_hp , 
            alamat : alamat , 
            email : email , 
            id:id , 
            

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
            title: "Konfirmasi Perubahan Data?",
            text: "Data akan Dirubah Pada Tabel!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({

                    url: `/editGuru`,
                    type: "PUT",
                    cache: false,
                    data: data,
                    success:function(response){
                        $('#editGuru').modal('hide');
        
                        swalWithBootstrapButtons.fire({
                            title: "Berhasil!",
                            text: "Data Guru Telah Diubah",
                            icon: "success"
                          });
                           getGuru()
                    },
                    error:function(error){
                        
                      
        
                    }
        
                });
    
    
              
            } else if (
              /* Read more about handling dismissals below */
              result.dismiss === Swal.DismissReason.cancel
            ) {
              swalWithBootstrapButtons.fire({
                title: "Batal",
                text: "Data Guru Tidak Dirubah",
                icon: "error"
              });
            }
          });

       

    });

})