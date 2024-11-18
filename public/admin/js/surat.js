let hitung = 0 ; 
function pedagogik (){
  $('#btnPedagogik').attr('class' , 'btn btn-secondary')
  $('#btnKepribadian').attr('class' , 'btn btn-outline-secondary')
  $('#btnProfesional').attr('class' , 'btn btn-outline-secondary')
  $('#btnSosial').attr('class' , 'btn btn-outline-secondary')

  hitung = 1 ; 
}
function kepribadian (){
  $('#btnKepribadian').attr('class' , 'btn btn-secondary')
  $('#btnPedagogik').attr('class' , 'btn btn-outline-secondary')
  $('#btnProfesional').attr('class' , 'btn btn-outline-secondary')
  $('#btnSosial').attr('class' , 'btn btn-outline-secondary')
  hitung = 2 ; 
}
function profesional (){
  $('#btnProfesional').attr('class' , 'btn btn-secondary')
  $('#btnPedagogik').attr('class' , 'btn btn-outline-secondary')
  $('#btnKepribadian').attr('class' , 'btn btn-outline-secondary')
  $('#btnSosial').attr('class' , 'btn btn-outline-secondary')
  hitung = 3 ; 
}
function sosial (){
  $('#btnSosial').attr('class' , 'btn btn-secondary')
  $('#btnProfesional').attr('class' , 'btn btn-outline-secondary')
  $('#btnPedagogik').attr('class' , 'btn btn-outline-secondary')
  $('#btnKepribadian').attr('class' , 'btn btn-outline-secondary')
  hitung = 4 ; 
}

function cetakSurat(data){
 
  $.ajax({

    url: `/surat/cetakSurat/${data}`,
    type: "GET",
    cache: false,
    data: data,
    success:function(response){
      window.open(`/surat/cetakSurat/${data}`, '_blank');
    },
    error:function(error){

    }

});

 

};


function hitungAspek(){
  let totalSkor = $('#totalSkor').val()
  let skorMaksimal = $('#skorMaksimal').val()
  let x = totalSkor / skorMaksimal ; 
  let y = x*100 ; 
  if (hitung == 1 ) {
    $('#pedagogik').html(y.toFixed(1))
    
    $('#totalSkor').val('')
    $('#skorMaksimal').val('')
    $('#nomer').html(1)
  } 
  if (hitung == 2 ){
    $('#kepribadian').html(y.toFixed(1))
    $('#totalSkor').val('')
    $('#skorMaksimal').val('')
    $('#nomer').html(1)

  }
  if (hitung == 3 ){
    $('#profesional').html(y.toFixed(1))
    $('#totalSkor').val('')
    $('#skorMaksimal').val('')
    $('#nomer').html(1)

  }
  if (hitung == 4 ){
    $('#sosial').html(y.toFixed(1))
    $('#totalSkor').val('')
    $('#skorMaksimal').val('')
    $('#nomer').html(1)

  }
}


function setNamaSurat(){
  let tahun = new Date().getFullYear();
  let tipe = $('#tipe_surat_edit').val()
  let set = '';
  if (tipe == 1 ) {
    set = 'Surat Kinerja'+ ' ' +tahun ; 
  } 
  else {
    set = 'Surat Teguran'+ ' ' +tahun ; 

  }
  $('#nama_surat_edit').val(set)
}

function editSurat(row){
  let data = JSON.parse(row);
 $('#id_surat').val(data.id);
 $('#nama_guru_edit').val(data.user_id).trigger('change');
 $('#nama_surat_edit').val(data.nama_surat);
 $('#tipe_surat_edit').val(data.tipe).trigger('change');
 $('#tanggal_edit').val(data.tanggal);
 $('#keterangan_edit').val(data.keterangan);
 $('#editSurat').modal('show');
}

function editAspek(id){

  $.ajax({

    url: `/aspek/getAspek/${id}`,
    type: "GET",
    cache: false,
    data: {id:id},
    success:function(response){
      console.log('get aspek called');
      console.log(response[0].pedagogik);
      $('#idAspek').val(response[0].id);
      $('#pedagogik').html(response[0].pedagogik);
      $('#kepribadian').html(response[0].kepribadian);
      $('#profesional').html(response[0].profesional);
      $('#sosial').html(response[0].sosial);
      $('#surat_id').val(response[0].surat_kinerja_id);
      $('#editAspek').modal('show');

    },
    error:function(error){

    }

});
}

function getAspek(id){
  $.ajax({

    url: `/aspek/getAspek/${id}`,
    type: "GET",
    cache: false,
    data: {id:id},
    success:function(response){
      console.log('get aspek called');
      console.log(response[0].pedagogik);
      $('#idAspek').val(response[0].id);
      $('#pedagogik').html(response[0].pedagogik);
      $('#kepribadian').html(response[0].kepribadian);
      $('#profesional').html(response[0].profesional);
      $('#sosial').html(response[0].sosial);
      $('#surat_id').val(response[0].surat_kinerja_id);
    },
    error:function(error){

    }

});

}

function getSurat(){
    $("#tabel_surat").dataTable().fnDestroy();

   var table = $('#tabel_surat').DataTable({
     processing: true,
     serverSide: true,
     ajax: "/surat",
     columns: [
         {data: null,"sortable": false, 
            render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
           }  },
           {data: 'nama_user', name: 'nama_user'},
           {data: 'nama_surat', name: 'nama_surat'},
           {data: 'tipe', name: 'tipe'},
           {data: 'tanggal', name: 'tanggal'},
           {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

   
   $(document).ready(function(){
    $('#editAspekButton').click(function(e) {
      e.preventDefault();

      //define variable
      let token   = $('#tokenAspek').val();
      let id   = $('#idAspek').val();
      let pedagogik   = $('#pedagogik').html();
      let kepribadian   = $('#kepribadian').html();
      let profesional   = $('#profesional').html();
      let sosial   = $('#sosial').html();
      let surat_id   = $('#surat_id').val();
      
      
      let data = {
          _token: token,
          id : id , 
          pedagogik : pedagogik , 
          kepribadian : kepribadian , 
          profesional : profesional , 
          sosial : sosial , 
         

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

                  url: `/aspek/editAspek`,
                  type: "POST",
                  cache: false,
                  data: data,
                  success:function(response){
                      swalWithBootstrapButtons.fire({
                          title: "Berhasil!",
                          text: "Data Aspek Telah Dirubah",
                          icon: "success"
                        });
                      getAspek(surat_id);
                      getSurat();
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
              text: "Data Aspek Tidak Dirubah",
              icon: "error"
            });
          }
        });


  });
    $('#buttonEdit').click(function(e) {
      e.preventDefault();

      //define variable
      let token_surat   = $('#token_surat_edit').val();
      let id   = $('#id_surat').val();
      let nama_user   = $('#nama_guru_edit').val();
      let nama_surat   = $('#nama_surat_edit').val();
      let tipe_surat   = $('#tipe_surat_edit').val();
      let tanggal   = $('#tanggal_edit').val();
      let keterangan   = $('#keterangan_edit').val();
      
      
      let data = {
          _token: token_surat,
          id : id , 
          nama_surat_edit : nama_surat , 
          nama_user : nama_user , 
          tipe_surat : tipe_surat , 
          tanggal : tanggal , 
          keterangan : keterangan , 
         

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
          title: "Konfirmasi Perubahan Data Surat?",
          text: "Data Akan Langsung Ditambahkan Pada Tabel!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Simpan",
          cancelButtonText: "Batal",
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {

              $.ajax({

                  url: `/editSurat`,
                  type: "POST",
                  cache: false,
                  data: data,
                  success:function(response){
                      swalWithBootstrapButtons.fire({
                          title: "Berhasil!",
                          text: "Data Surat Telah Dirubah",
                          icon: "success"
                        });
                        $('#nama_guru_edit').val('');
                        $('#nama_surat_edit').val('');
                        $('#tipe_surat_edit').val('');
                        $('#tanggal_edit').val('');
                        $('#keterangan_edit').val('');
                         getSurat()
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
              text: "Data Surat Tidak Dirubah",
              icon: "error"
            });
          }
        });


  });
   })



   $(document).ready(function(){
    getSurat();
    $('#nama_guru').select2();
    $('#nama_guru_edit').select2();

    $('#addSuratButton').click(function(e) {
      e.preventDefault();
      $('#addSurat').modal({"backdrop": "static"})

      //define variable
      let token_surat   = $('#token_surat').val();
      let nama_user   = $('#nama_guru').val();
      let tipe_surat   = $('#tipe_surat').val();
      let tanggal   = $('#tanggal').val();
      let keterangan   = $('#keterangan').val();
      
      
      let data = {
          _token: token_surat,
          nama_user : nama_user , 
          tipe_surat : tipe_surat , 
          tanggal : tanggal , 
          keterangan : keterangan , 
         

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
          title: "Konfirmasi Penambahan Data Surat?",
          text: "Data Akan Langsung Ditambahkan Pada Tabel!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Simpan",
          cancelButtonText: "Batal",
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {

              $.ajax({

                  url: `/addSurat`,
                  type: "POST",
                  cache: false,
                  data: data,
                  success:function(response){
                      swalWithBootstrapButtons.fire({
                          title: "Berhasil!",
                          text: "Data Surat Telah Ditambahkan",
                          icon: "success"
                        });
                        $('#nama_guru').val('0').trigger('change');
                        $('#tipe_surat').val('0').trigger('change');

                      
                        $('#tanggal').val('');
                        $('#keterangan').val('');
                         getSurat()
                  },
                  error:function(error){
                      
                    
      
                  }
      
              });
  
  
            
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
            $('#token_surat').val('');
            $('#nama_guru').val('');
            $('#tipe_surat').val('');
            $('#tanggal').val('');
            $('#keterangan').val('');
            swalWithBootstrapButtons.fire({
              title: "Batal",
              text: "Data Surat Tidak Ditambah",
              icon: "error"
            });
          }
        });


  });

    

  });




  