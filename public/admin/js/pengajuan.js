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
         {data: 'status', name: 'status'},
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

   function getSingleProgramEdit(){
     let id = $('#nama_kegiatan_id').val();
     console.log(id)
    $.ajax({
  
      url: `/getSingleProgram`,
      type: "POST",
      cache: false,
      data: {
        id:id , 
      }, 
    
      headers:{
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
      success:function(response){
          $('#waktu_id').val(`${response.pelaksanaan} Semester`);
          $('#jumlah_poin_id').val(`${response.poin} Poin`);
      },
      error:function(error){
        console.log(error)
  
      }
  
  });
  }
   function getSingleProgram(){
     let id = $('#nama_kegiatan').val();
     console.log(id)
    $.ajax({
  
      url: `/getSingleProgram`,
      type: "POST",
      cache: false,
      data: {
        id:id , 
      }, 
    
      headers:{
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
      success:function(response){
          $('#waktu').val(`${response.pelaksanaan} Semester`);
          $('#jumlah_poin').val(`${response.poin} Poin`);
      },
      error:function(error){
        console.log(error)
  
      }
  
  });
  }

   function cekRpp(row){
    console.log('called')
    let data = JSON.parse(row);
    window.location.href = `/aspek/pedagogik` ; 

   }

  

$( document ).ready(function() {     
   getPengajuan();
  //  $('#guru').select2();



  $('#btnCatatan').click(function(e) {
    e.preventDefault();
    $('#editCatatan').modal({"backdrop": "static"})

    //define variable
    let idCatatan   = $('#idCatatan').val();
    let catatan = $('#catatan').val();

    let data = {
        idCatatan : idCatatan , 
        catatan : catatan , 
        
           }

           var form_data = new FormData();
    form_data.append('id', idCatatan);
    form_data.append('catatan', catatan);
   
   

       const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: "Konfirmasi Catatan?",
        text: "Data Akan Langsung Ditambahkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Simpan",
        cancelButtonText: "Batal",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({

                url: `/pengajuan/catatan`,
                type: "POST",
                cache: false,
                headers:{
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
                processData: false,
                contentType: false,
                data: form_data,
                enctype: 'multipart/form-data',

                success:function(response){
                    swalWithBootstrapButtons.fire({
                        title: "Berhasil!",
                        text: "Catatan Telah Ditambahkan",
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
            text: "Catatan Tidak Ditambah",
            icon: "error"
          });
        }
      });





});
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
    let waktuFix = Array.from(waktu)[0];
    let poinFix = jumlah_poin.replace(/\D/g, "");
    let data = {
        _token: $('#token_pengajuan').val(),
        nama_kegiatan : nama_kegiatan , 
        waktu : waktuFix , 
        jumlah_poin : poinFix , 
        rpp : rpp , 
           }
    //ajax
    
    
    
    var file_data = $('#rpp').prop('files')[0];
    var form_data = new FormData();
    form_data.append('rpp', file_data);
    form_data.append('_token', token);
    form_data.append('nama_kegiatan', nama_kegiatan);
    form_data.append('waktu', waktuFix);
    form_data.append('jumlah_poin', poinFix);
   
    
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
    let waktuFixx = Array.from(waktu)[0];
    let poinFixx = jumlah_poin.replace(/\D/g, "");
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
    form_data.append('waktu', waktuFixx);
    form_data.append('jumlah_poin', poinFixx); 
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
  $('#waktu_id').val(`${data.estimasi} Semester`);
  $('#jumlah_poin_id').val(`${data.jumlah_poin} Poin`);
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

function approvePengajuan(id){

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "btn btn-danger"
    },
    buttonsStyling: false
  });
  swalWithBootstrapButtons.fire({
    title: "Konfirmasi Persetujuan Pengajuan Kinerja?",
    text: "Data Akan Langsung Diupdate!",
    icon: "info",
    showCancelButton: true,
    confirmButtonText: "Simpan",
    cancelButtonText: "Batal",
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {

        $.ajax({

            url: `/pengajuan/approve`,
            type: "POST",
            headers:{
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
            cache: false,
            data: {id:id},
            success:function(response){
                swalWithBootstrapButtons.fire({
                    title: "Berhasil!",
                    text: "Pengajuan Disetujui!",
                    icon: "success"
                  });
                getPengajuan();
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
        text: "Data Pengajuan Tidak Disetujui",
        icon: "error"
      });
    }
  });

}

function formatTanggal(dateString) {
  // Daftar nama hari dan bulan dalam bahasa Indonesia
  const namaHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
  const namaBulan = [
      "Januari", "Februari", "Maret", "April", "Mei", "Juni",
      "Juli", "Agustus", "September", "Oktober", "November", "Desember"
  ];

  // Konversi string ISO ke objek Date
  const date = new Date(dateString);

  // Ambil elemen tanggal
  const hari = namaHari[date.getUTCDay()];
  const tanggal = date.getUTCDate();
  const bulan = namaBulan[date.getUTCMonth()];
  const tahun = date.getUTCFullYear();

  // Gabungkan elemen dalam format yang diinginkan
  return `${hari}, ${tanggal} ${bulan} ${tahun}`;
}


function opsi (row){
  let data = JSON.parse(row);
  Swal.fire({
    title: `Program Telah Diajukan Sejak ${formatTanggal(data.created_at)}`,
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: "Setujui",
    denyButtonText: `Berikan Catatan`
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      approvePengajuan(data.id)
    } else if (result.isDenied) {
      editCatatan(data)
      // Swal.fire("Changes are not saved", "", "info");
    }
  });
}

function editCatatan(row){
  $('#idCatatan').val(row.id);
  $('#editCatatan').modal('show');

}