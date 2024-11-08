function getPedagogik(){
    $("#tabel_pedagogik").dataTable().fnDestroy();

   var table = $('#tabel_pedagogik').DataTable({
     processing: true,
     serverSide: true,
     ajax: "/aspek/pedagogik",
     columns: [
         {data: null,"sortable": false, 
            render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
           }  },
         {data: 'nama_user', name: 'nama_user'},
         {data: 'nama_pedagogik', name: 'nama_pedagogik'},
         {data: 'dokumen', name: 'dokumen'},
         
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

   $(document).ready(function(){
    getPedagogik();
    $('#filePedagogik').change(function(e){
        var fileName = e.target.files[0].name;
        $('#namaFilePedagogik').val(fileName);
  
    });

    $('#buttonTambahPedagogik').click(function(e) {
        e.preventDefault();
        $('#addPedagogik').modal({"backdrop": "static"})
    
        //define variable
        let nama_pedagogik   = $('#nama_pedagogik').val();
        let token   = $('#token_pedagogik').val();
       
                
        var file_data = $('#filePedagogik').prop('files')[0];
        var form_data = new FormData();
        form_data.append('dokumen', file_data);
        form_data.append('nama_pedagogik', nama_pedagogik);
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
            title: "Konfirmasi Tambah Pedagogik?",
            text: "Data Akan Langsung Ditambahkan Pada Tabel!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
    
                    url: `/aspek/pedagogik/addPedagogik`,
                    type: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: form_data,
                    enctype: 'multipart/form-data',
    
                    success:function(response){
                        swalWithBootstrapButtons.fire({
                            title: "Berhasil!",
                            text: "Data Pedagogik Telah Ditambahkan",
                            icon: "success"
                          });
                         $('#nama_pedagogik').val('');
                         $('#namaFilePedagogik').val('');

                          getPedagogik()
     
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
                text: "Data Pedagogik Tidak Ditambah",
                icon: "error"
              });
            }
          });
    
    
    });
  });

  function addPedagogikFile(){
    $('#filePedagogik').click();
  
  }