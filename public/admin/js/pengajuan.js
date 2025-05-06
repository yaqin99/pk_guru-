function showNotification(title, text, icon = 'info') {
  Swal.fire({
      title: title,
      text: text,
      icon: icon,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'OK'
  });
}
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
         {data: 'catatan_admin', name: 'catatan_admin'},
         {data: 'estimasi', name: 'estimasi'},
         {data: 'jumlah_poin', name: 'jumlah_poin'},
         {data: 'status', name: 'status'},
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

   function adminValidasi(row) {
    let data = JSON.parse(row);
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Pengajuan ini akan diselesaikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Selesaikan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'adminValidasi',
                type: 'POST',
                data: {
                    id: data.id,
                    user_id: data.user_id,
                    jumlah_poin: data.jumlah_poin,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message
                        }).then(() => {
                            // Jika guru sudah mencapai 20 poin
                            if(response.needCertificate) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Perhatian!',
                                    html: `Guru <b>${response.guru.nama}</b> telah mencapai <b>${response.guru.poin} poin</b>.<br>
                                          Silahkan buatkan surat keterangan kinerja.`,
                                    confirmButtonText: 'OK'
                                });
                            }
                            $('#tabel_pengajuan').DataTable().ajax.reload();
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memvalidasi pengajuan'
                    });
                }
            });
        }
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


  function sendToKepsek(id){
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger"
      },
      buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
      title: "Konfirmasi Penerusan Program Kinerja?",
      text: "Data Akan Langsung Dirubah Pada Tabel!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Simpan",
      cancelButtonText: "Batal",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({

              url: `/sendToKepsek`,
              type: "POST",
              cache: false,
              headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
              data: {
                id:id , 
              },
              enctype: 'multipart/form-data',

              success:function(response){
                  swalWithBootstrapButtons.fire({
                      title: "Berhasil!",
                      text: "Program Telah Diteruskan",
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
          text: "Data Pengajuan Tidak Diteruskan",
          icon: "error"
        });
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
    $('#fileBuktiKegiatan').change(function(e){
        var fileName = e.target.files[0].name;
        $('#namaFileBuktiKegiatan').val(fileName);
  
    });


  $('#addBuktiKegiatanSave').click(function(e) {
    e.preventDefault();
    $('#addBuktiKegiatan').modal({"backdrop": "static"})

    //define variable
   
           var form_data = new FormData($('#formBuktiKegiatan')[0]);
   
   

       const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: "Konfirmasi Bukti Kegiatan?",
        text: "Data Akan Langsung Ditambahkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Simpan",
        cancelButtonText: "Batal",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({

                url: `/pengajuan/addBuktiKegiatan`,
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
                        text: "Bukti Telah Ditambahkan",
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

    if (!nama_kegiatan) {
        showNotification('Peringatan', 'Nama kegiatan tidak boleh kosong!', 'warning');
        
        return;
    }
    if (!waktu) {
        showNotification('Peringatan', 'Waktu harus diisi!', 'warning');
        return;
    }
    if (!jumlah_poin) {
        showNotification('Peringatan', 'Jumlah poin harus diisi!', 'warning');
        return;
    }
    if (!rpp) {
        showNotification('Peringatan', 'RPP harus diisi!', 'warning');

        return;
    }
   
    
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
function tolakPengajuan(id) {
    Swal.fire({
        title: 'Masukkan Alasan Penolakan',
        input: 'textarea',
        inputPlaceholder: 'Ketik alasan penolakan di sini...',
        showCancelButton: true,
        confirmButtonText: 'Lanjutkan',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) {
                return 'Alasan penolakan harus diisi!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const alasanPenolakan = result.value;
            
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Pengajuan akan ditolak dengan alasan: " + alasanPenolakan,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tolak!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/pengajuan/tolak`,
                        type: 'POST',
                        headers:{
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
                        data: {
                          id:id,
                          catatan: alasanPenolakan
                        },
                        success: function(response) {
                           
                                Swal.fire(
                                    'Berhasil!',
                                    'Pengajuan berhasil ditolak',
                                    'success'
                                ).then(() => {
                                    getPengajuan();
                                });
                            
                        }
                    });
                }
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
    showConfirmButton: false,
    denyButtonText: `Berikan Catatan Perbaikan`,
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isDenied) {
      editCatatan(data.id)
    }
  });
}

function editCatatan(id) {
    Swal.fire({
        title: 'Edit Catatan',
        input: 'textarea',
        inputLabel: 'Masukkan catatan baru',
        inputPlaceholder: 'Ketik catatan disini...',
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: (catatan) => {
            return $.ajax({
                url: `/pengajuan/catatan`,
                type: 'POST',
                headers:{
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
                data: {
                    catatan: catatan,
                    id:id
                }
            }).then(response => {
                return response;
            }).catch(error => {
                Swal.showValidationMessage(`Request failed: ${error.responseJSON.message}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Catatan berhasil diperbarui',
                icon: 'success'
            }).then(() => {
                getPengajuan();
            });
        }
    });
}

function buktiKegiatan(data){
  let row = JSON.parse(data);
  console.log(row)
  $('#idBuktiKegiatan').val(row.id);
  $('#namaFileBuktiKegiatan').val(row.bukti);
  $('#addBuktiKegiatan').modal('show');
}

function buktiKegiatanClick(){
  $('#fileBuktiKegiatan').click();
}

function perbaikiPengajuan(id) {
    Swal.fire({
        title: 'Masukkan Catatan Perbaikan',
        input: 'textarea',
        inputPlaceholder: 'Ketik catatan perbaikan di sini...',
        showCancelButton: true,
        confirmButtonText: 'Lanjutkan',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) {
                return 'Catatan perbaikan harus diisi!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const catatanPerbaikan = result.value;
            
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Pengajuan akan diminta perbaikan dengan catatan: " + catatanPerbaikan,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Minta Perbaikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/pengajuan/perbaiki`,
                        type: 'POST',
                        headers:{
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
                        data: {
                          id: id,
                          catatan_admin: catatanPerbaikan
                        },
                        success: function(response) {
                            Swal.fire(
                                'Berhasil!',
                                'Permintaan perbaikan berhasil dikirim',
                                'success'
                            ).then(() => {
                                getPengajuan();
                            });
                        }
                    });
                }
            });
        }
    });
}