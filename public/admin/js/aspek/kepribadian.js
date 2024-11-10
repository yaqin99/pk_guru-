function getKepribadian(){
    $("#tabel_kepribadian").dataTable().fnDestroy();

   var table = $('#tabel_kepribadian').DataTable({
     processing: true,
     serverSide: true,
     ajax: "/aspek/kepribadian",
     columns: [
         {data: null,"sortable": false, 
            render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
           }  },
         {data: 'nama_user', name: 'nama_user'},
         {data: 'nama_kepribadian', name: 'nama_kepribadian'},
         {data: 'dokumen', name: 'dokumen'},
         
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

   $(document).ready(function(){
    getKepribadian();
    $('#fileKepribadian').change(function(e){
        var fileName = e.target.files[0].name;
        $('#namaFileKepribadian').val(fileName);
  
    });
    $('#fileKepribadian_edit').change(function(e){
        var fileName = e.target.files[0].name;
        $('#namaFileKepribadian_edit').val(fileName);
  
    });

    $('#buttonTambahKepribadian_edit').click(function(e) {
        e.preventDefault();
        $('#editKepribadian').modal({"backdrop": "static"})
    
        //define variable
        let nama_Kepribadian   = $('#nama_kepribadian_edit').val();
        let id   = $('#idPegagogik_edit').val();
        let token   = $('#token_Kepribadian_edit').val();
       
                
        var file_data = $('#fileKepribadian_edit').prop('files')[0];
        var form_data = new FormData();
        form_data.append('dokumen', file_data);
        form_data.append('id', id);
        form_data.append('nama_kepribadian', nama_Kepribadian);
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
            title: "Konfirmasi Perubahan Kepribadian?",
            text: "Data Akan Langsung Dirubah Pada Tabel!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
    
                    url: `/aspek/kepribadian/editKepribadian`,
                    type: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: form_data,
                    enctype: 'multipart/form-data',
    
                    success:function(response){
                        swalWithBootstrapButtons.fire({
                            title: "Berhasil!",
                            text: "Data Kepribadian Telah Dirubah",
                            icon: "success"
                          });
                         $('#nama_kepribadian_edit').val('');
                         $('#namaFileKepribadian_edit').val('');

                          getKepribadian()
     
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
                text: "Data Kepribadian Tidak Dirubah",
                icon: "error"
              });
            }
          });
    
    
    });
    $('#buttonTambahKepribadian').click(function(e) {
        e.preventDefault();
        $('#addKepribadian').modal({"backdrop": "static"})
    
        //define variable
        let nama_Kepribadian   = $('#nama_kepribadian').val();
        let namaFileKepribadian_edit   = $('#namaFileKepribadian_edit').val();
        let token   = $('#token_kepribadian').val();
       
                
        var file_data = $('#fileKepribadian').prop('files')[0];
        var form_data = new FormData();
        form_data.append('dokumen', file_data);
        form_data.append('nama_kepribadian', nama_Kepribadian);
        form_data.append('namaFileKepribadian_edit', namaFileKepribadian_edit);
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
            title: "Konfirmasi Tambah Kepribadian?",
            text: "Data Akan Langsung Ditambahkan Pada Tabel!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
    
                    url: `/aspek/kepribadian/addKepribadian`,
                    type: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: form_data,
                    enctype: 'multipart/form-data',
    
                    success:function(response){
                        swalWithBootstrapButtons.fire({
                            title: "Berhasil!",
                            text: "Data Kepribadian Telah Ditambahkan",
                            icon: "success"
                          });
                         $('#nama_Kepribadian').val('');
                         $('#namaFileKepribadian').val('');

                          getKepribadian()
     
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
              
              swalWithBootstrapButtons.fire({
                title: "Batal",
                text: "Data Kepribadian Tidak Ditambah",
                icon: "error"
              });
            }
          });
    
    
    });
  });

  function addKepribadianFile(){
    $('#fileKepribadian').click();
  
  }
  function editKepribadianFile(){
    $('#fileKepribadian_edit').click();
  
  }

  function deleteKepribadian(id ){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: "Konfirmasi Penghapusan Kepribadian?",
        text: "Data Yang Dihapus Tidak Dapat Dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({

                url: `/aspek/kepribadian/deleteKepribadian/${id}`,
                type: "GET",
                cache: false,
                data: {
                    id:id , 
                },
                success:function(response){
                    swalWithBootstrapButtons.fire({
                        title: "Berhasil!",
                        text: "Data Kepribadian Telah Terhapus",
                        icon: "success"
                      });
                       getKepribadian()
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
            text: "Data Kepribadian Tidak Terhapus",
            icon: "error"
          });
        }
      });




    
}

function editKepribadian(row){
  let data = JSON.parse(row) ; 
  console.log(data)
  $('#namaFileKepribadian_edit').val(data.dokumen);
  $('#idPegagogik_edit').val(data.id);
  
  $('#nama_kepribadian_edit').val(data.nama_Kepribadian);
  $('#editKepribadian').modal('show');

 
}