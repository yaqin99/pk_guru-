function getProfesional(){
    $("#tabel_profesional").dataTable().fnDestroy();

   var table = $('#tabel_profesional').DataTable({
     processing: true,
     serverSide: true,
     ajax: "/aspek/profesional",
     columns: [
         {data: null,"sortable": false, 
            render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
           }  },
         {data: 'nama_user', name: 'nama_user'},
         {data: 'nama_profesional', name: 'nama_profesional'},
         {data: 'dokumen', name: 'dokumen'},
         
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

   $(document).ready(function(){
    getProfesional();
    $('#fileProfesional').change(function(e){
        var fileName = e.target.files[0].name;
        $('#namaFileProfesional').val(fileName);
  
    });
    $('#fileProfesional_edit').change(function(e){
        var fileName = e.target.files[0].name;
        $('#namaFileProfesional_edit').val(fileName);
  
    });

    $('#buttonTambahProfesional_edit').click(function(e) {
        e.preventDefault();
        $('#editProfesional').modal({"backdrop": "static"})
    
        //define variable
        let nama_profesional   = $('#nama_profesional_edit').val();
        let id   = $('#idProfesional_edit').val();
        let token   = $('#token_profesional_edit').val();
       
                
        var file_data = $('#fileProfesional_edit').prop('files')[0];
        var form_data = new FormData();
        form_data.append('dokumen', file_data);
        form_data.append('id', id);
        form_data.append('nama_profesional', nama_profesional);
        form_data.append('_token', token);
      
       
        // console.log(form_data);
        for (var pair of form_data.entries()) {
          console.log(pair[0]+ ', ' + pair[1]); 
      }
    
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: "btn btn-success",
              cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
          });
          swalWithBootstrapButtons.fire({
            title: "Konfirmasi Perubahan Data Profesional?",
            text: "Data Akan Langsung Dirubah Pada Tabel!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
    
                    url: `/aspek/profesional/editProfesional`,
                    type: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: form_data,
                    enctype: 'multipart/form-data',
    
                    success:function(response){
                        swalWithBootstrapButtons.fire({
                            title: "Berhasil!",
                            text: "Data Profesional Telah Dirubah",
                            icon: "success"
                          });
                         $('#nama_profesional_edit').val('');
                         $('#namaFileProfesional_edit').val('');

                         getProfesional();
     
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
                text: "Data Profesional Tidak Dirubah",
                icon: "error"
              });
            }
          });
    
    
    });
    $('#buttonTambahProfesional').click(function(e) {
        e.preventDefault();
        $('#addProfesional').modal({"backdrop": "static"})
    
        //define variable
        let nama_profesional   = $('#nama_profesional').val();
        let namaFileProfesional   = $('#namaFileProfesional').val();
        let token   = $('#token_profesional').val();
       
                
        var file_data = $('#fileProfesional').prop('files')[0];
        var form_data = new FormData();
        form_data.append('dokumen', file_data);
        form_data.append('nama_profesional', nama_profesional);
        form_data.append('namaFileProfesional', namaFileProfesional);
        form_data.append('_token', token);
      
       
        // console.log(form_data);
        for (var pair of form_data.entries()) {
          console.log(pair[0]+ ', ' + pair[1]); 
      }
    
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: "btn btn-success",
              cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
          });
          swalWithBootstrapButtons.fire({
            title: "Konfirmasi Tambah Data Profesional?",
            text: "Data Akan Langsung Ditambahkan Pada Tabel!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
    
                    url: `/aspek/profesional/addProfesional`,
                    type: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: form_data,
                    enctype: 'multipart/form-data',
    
                    success:function(response){
                        swalWithBootstrapButtons.fire({
                            title: "Berhasil!",
                            text: "Data Profesional Telah Ditambahkan",
                            icon: "success"
                          });
                          $('#nama_profesional').val('');
                          $('#namaFileProfesional').val('');

                          getProfesional();
     
                    },
                    error:function(error){
                        
                      
        
                    }
        
                });
    
    
              
            } else if (
              /* Read more about handling dismissals below */
              result.dismiss === Swal.DismissReason.cancel
            ) {
              $('#nama_profesional').val('');
              $('#namaFileProfesional').val('');
              
              swalWithBootstrapButtons.fire({
                title: "Batal",
                text: "Data Profesional Tidak Ditambah",
                icon: "error"
              });
            }
          });
    
    
    });
  });

  function addProfesionalFile(){
    $('#fileProfesional').click();
  
  }
  function editProfesionalFile(){
    $('#fileProfesional_edit').click();
  
  }

  function deleteProfesional(id ){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: "Konfirmasi Penghapusan Profesional?",
        text: "Data Yang Dihapus Tidak Dapat Dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({

                url: `/aspek/profesional/deleteProfesional/${id}`,
                type: "GET",
                cache: false,
                data: {
                    id:id , 
                },
                success:function(response){
                    swalWithBootstrapButtons.fire({
                        title: "Berhasil!",
                        text: "Data Profesional Telah Terhapus",
                        icon: "success"
                      });
                       getProfesional()
                },
                error:function(error){
                    
                  
        
                }
        
            })


          
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire({
            title: "Batal",
            text: "Data Profesional Tidak Terhapus",
            icon: "error"
          });
        }
      });




    
}

function editProfesional(row){
  let data = JSON.parse(row) ; 
  console.log(data)
  $('#namaFileProfesional_edit').val(data.dokumen);
  $('#idProfesional_edit').val(data.id);
  
  $('#nama_profesional_edit').val(data.nama_profesional);
  $('#editProfesional').modal('show');

 
}