function getPelaksanaan(){
    $("#tabel_program").dataTable().fnDestroy();

   var table = $('#tabel_program').DataTable({
     processing: true,
     serverSide: true,
     ajax: "/program",
     columns: [
         {data: null,"sortable": false, 
            render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
           }  },
         {data: 'nama_program', name: 'nama_program'},
         {data: 'poin', name: 'poin'},
         {data: 'pelaksanaan', name: 'pelaksanaan'},
     
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

$( document ).ready(function() {     
   getPelaksanaan();

   $('#simpanProgram').click(function(e) {
    e.preventDefault();

    
    var form_data = new FormData($('#formProgram')[0]);  

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: "Konfirmasi Perubahan Data Aspek?",
        text: "Data Akan Langsung Ditambahkan Pada Tabel!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Simpan",
        cancelButtonText: "Batal",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({

                url: `/addProgram`,
                type: "POST",
                cache: false,
                data: form_data, 
                processData: false, 
                contentType: false, 
                headers:{
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
                success:function(response){
                    swalWithBootstrapButtons.fire({
                        title: "Berhasil!",
                        text: "Data Program Telah Dirubah",
                        icon: "success"
                      });
                    $('#formProgram')[0].reset();
                    getPelaksanaan();
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
            text: "Data Program Tidak Dirubah",
            icon: "error"
          });
        }
      });


});

});