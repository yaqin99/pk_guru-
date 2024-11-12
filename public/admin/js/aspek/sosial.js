function getSosial(){
    $("#tabel_sosial").dataTable().fnDestroy();

   var table = $('#tabel_sosial').DataTable({
     processing: true,
     serverSide: true,
     ajax: "/aspek/sosial",
     columns: [
         {data: null,"sortable": false, 
            render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
           }  },
         {data: 'nama_user', name: 'nama_user'},
         {data: 'nama_sosial', name: 'nama_sosial'},
         {data: 'dokumen', name: 'dokumen'},
         
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

   $(document).ready(function(){
    getSosial();
    $('#fileSosial').change(function(e){
        var fileName = e.target.files[0].name;
        $('#namaFileSosial').val(fileName);
  
    });
    $('#fileSosial_edit').change(function(e){
        var fileName = e.target.files[0].name;
        $('#namaFileSosial_edit').val(fileName);
  
    });

    $('#buttonTambahSosial_edit').click(function(e) {
        e.preventDefault();
        $('#editSosial').modal({"backdrop": "static"})
    
        //define variable
        let nama_Sosial   = $('#nama_sosial_edit').val();
        let id   = $('#idSosial_edit').val();
        let token   = $('#token_sosial_edit').val();
       
                
        var file_data = $('#fileSosial_edit').prop('files')[0];
        var form_data = new FormData();
        form_data.append('dokumen', file_data);
        form_data.append('id', id);
        form_data.append('nama_sosial', nama_Sosial);
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
            title: "Konfirmasi Perubahan Sosial?",
            text: "Data Akan Langsung Dirubah Pada Tabel!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
    
                    url: `/aspek/sosial/editSosial`,
                    type: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: form_data,
                    enctype: 'multipart/form-data',
    
                    success:function(response){
                        swalWithBootstrapButtons.fire({
                            title: "Berhasil!",
                            text: "Data Sosial Telah Dirubah",
                            icon: "success"
                          });
                         $('#nama_sosial_edit').val('');
                         $('#namaFileSosial_edit').val('');

                          getSosial()
     
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
                text: "Data Sosial Tidak Dirubah",
                icon: "error"
              });
            }
          });
    
    
    });
    $('#buttonTambahSosial').click(function(e) {
        e.preventDefault();
        $('#addSosial').modal({"backdrop": "static"})
    
        //define variable
        let nama_Sosial   = $('#nama_sosial').val();
        let namaFileSosial   = $('#namaFileSosial').val();
        let token   = $('#token_sosial').val();
       
                
        var file_data = $('#fileSosial').prop('files')[0];
        var form_data = new FormData();
        form_data.append('dokumen', file_data);
        form_data.append('nama_sosial', nama_Sosial);
        form_data.append('namaFileSosial', namaFileSosial);
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
            title: "Konfirmasi Tambah Sosial?",
            text: "Data Akan Langsung Ditambahkan Pada Tabel!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
    
                    url: `/aspek/sosial/addSosial`,
                    type: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: form_data,
                    enctype: 'multipart/form-data',
    
                    success:function(response){
                        swalWithBootstrapButtons.fire({
                            title: "Berhasil!",
                            text: "Data Sosial Telah Ditambahkan",
                            icon: "success"
                          });
                          $('#nama_sosial').val('');
                          $('#namaFileSosial').val('');

                          getSosial()
     
                    },
                    error:function(error){
                        
                      
        
                    }
        
                });
    
    
              
            } else if (
              /* Read more about handling dismissals below */
              result.dismiss === Swal.DismissReason.cancel
            ) {
              $('#nama_sosial').val('');
              $('#namaFileSosial').val('');
              
              swalWithBootstrapButtons.fire({
                title: "Batal",
                text: "Data Sosial Tidak Ditambah",
                icon: "error"
              });
            }
          });
    
    
    });
  });

  function addSosialFile(){
    $('#fileSosial').click();
  
  }
  function editSosialFile(){
    $('#fileSosial_edit').click();
  
  }

  function deleteSosial(id ){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: "Konfirmasi Penghapusan Sosial?",
        text: "Data Yang Dihapus Tidak Dapat Dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({

                url: `/aspek/sosial/deleteSosial/${id}`,
                type: "GET",
                cache: false,
                data: {
                    id:id , 
                },
                success:function(response){
                    swalWithBootstrapButtons.fire({
                        title: "Berhasil!",
                        text: "Data Sosial Telah Terhapus",
                        icon: "success"
                      });
                       getSosial()
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
            text: "Data Sosial Tidak Terhapus",
            icon: "error"
          });
        }
      });




    
}

function editSosial(row){
  let data = JSON.parse(row) ; 
  console.log(data)
  $('#namaFileSosial_edit').val(data.dokumen);
  $('#idSosial_edit').val(data.id);
  
  $('#nama_sosial_edit').val(data.nama_sosial);
  $('#editSosial').modal('show');

 
}