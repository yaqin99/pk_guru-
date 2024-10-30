function getPengajuan(){
    $("#tabel_pengajuan").dataTable().fnDestroy();

   var table = $('#tabel_pengajuan').DataTable({
     processing: true,
     serverSide: true,
     ajax: "/pengajuan",
     columns: [
         {data: null,"sortable": false, 
            render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
           }  },
         {data: 'nama_user', name: 'nama_user'},
         {data: 'nama_kegiatan', name: 'nama_kegiatan'},
         {data: 'catatan', name: 'catatan'},
         {data: 'estimasi', name: 'estimasi'},
         {data: 'jumlah_poin', name: 'jumlah_poin'},
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

$( document ).ready(function() {     
   getPengajuan()
  //  $('#guru').select2();


  $('#addPengajuanButton').click(function(e) {
    e.preventDefault();
    $('#addPengajuan').modal({"backdrop": "static"})

    //define variable
    let nama_kegiatan   = $('#nama_kegiatan').val();
    let waktu   = $('#waktu').val();
    let jumlah_poin   = $('#jumlah_poin').val();
    let rpp   = $('#rpp').val();   
    let nameData   = $('#cek').val();   
    let token = $('#token_pengajuan').val();

    let data = {
        _token: $('#token_pengajuan').val(),
        nama_kegiatan : nama_kegiatan , 
        waktu : waktu , 
        jumlah_poin : jumlah_poin , 
        rpp : rpp , 
           }
    //ajax
    
    
    
    var file_data = $('#rpp').prop('files')[0];
    var form_data = new FormData();
    form_data.append('rpp', file_data);
    form_data.append('_token', token);
    form_data.append('nama_kegiatan', nama_kegiatan);
    form_data.append('waktu', waktu);
    form_data.append('jumlah_poin', jumlah_poin);
   
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
        title: "Konfirmasi Pengajuan?",
        text: "Data Akan Langsung Ditambahkan Pada Tabel!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Simpan",
        cancelButtonText: "Batal",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({

                url: `/addPengajuan`,
                type: "POST",
                cache: false,
                processData: false,
                contentType: false,
                data: form_data,
                enctype: 'multipart/form-data',

                success:function(response){
                    swalWithBootstrapButtons.fire({
                        title: "Berhasil!",
                        text: "Data Pengajuan Telah Ditambahkan",
                        icon: "success"
                      });
                      let nama_kegiatan   = $('#nama_kegiatan').val('');
                      let waktu   = $('#waktu').val('');
                      let jumlah_poin   = $('#jumlah_poin').val('');
                      let rpp   = $('#rpp').val('');  
                      getPengajuan()
 
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

  $('#addPengajuanButton_edit').click(function(e) {
    e.preventDefault();

    //define variable

    let nama_kegiatan   = $('#nama_kegiatan_id').val();
    let waktu   = $('#waktu_id').val();
    let jumlah_poin  = $('#jumlah_poin_id').val();
  
    let rpp   = $('#rpp_id').val();
    let name   = $('#cek').val();
    let id   = $('#theId').val();
    let token = $('#token_pengajuan_id').val();

    let data = {
        _token: $('#token_pengajuan_id').val(),
        nama_kegiatan : nama_kegiatan , 
        waktu : waktu , 
        jumlah_poin : jumlah_poin , 
        rpp : rpp , 
           }
    //ajax
    
    
    
    var file_data = $('#rpp_id').prop('files')[0];
    var form_data = new FormData();
    form_data.append('rpp', file_data);
    form_data.append('rpp_name', name);
    form_data.append('id', id);
    form_data.append('_token', token);
    form_data.append('nama_kegiatan', nama_kegiatan);
    form_data.append('waktu', waktu);
    form_data.append('jumlah_poin', jumlah_poin); 
    console.log(data);
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
        title: "Konfirmasi Perubahan?",
        text: "Data Akan Langsung Dirubah Pada Tabel!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Simpan",
        cancelButtonText: "Batal",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({

                url: `/editPengajuan`,
                type: "POST",
                cache: false,
                processData: false,
                contentType: false,
                data: form_data,
                enctype: 'multipart/form-data',

                success:function(response){
                    swalWithBootstrapButtons.fire({
                        title: "Berhasil!",
                        text: "Data Pengajuan Telah Dirubah",
                        icon: "success"
                      });

                      getPengajuan()
 
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
            text: "Data Pengajuan Tidak Dirubah",
            icon: "error"
          });
        }
      });


});

});

function editPengajuan(row){
  let data = JSON.parse(row) ; 
  console.log(data)
  $('#editPengajuan').modal('show');
  $('#nama_kegiatan_id').val(data.nama_kegiatan);
  $('#waktu_id').val(data.estimasi).trigger('change');
  $('#jumlah_poin_id').val(data.jumlah_poin);
  $('#theId').val(data.id);

  $('#cek').val(data.rpp);
 
}

function changing(){
  $('#rpp_id').click();

}


$(document).ready(function(){
  $('#rpp_id').change(function(e){
      var fileName = e.target.files[0].name;
      $('#cek').val(fileName);

  });
});