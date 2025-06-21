let hitung = 0 ; 

function showNotification(title, text, icon = 'info') {
  Swal.fire({
      title: title,
      text: text,
      icon: icon,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'OK'
  });
}

function cekGuru(idGuru) {
  const selectedValue = $(idGuru).val(); // id guru
  const selectedText = $(idGuru).find('option:selected').text();

  // Ambil tahun sekarang (bisa juga dari input khusus jika ada)
  const tahun = new Date().getFullYear(); // Misalnya: 2025

  $.ajax({
    url: `/surat/cekGuru`,
    type: "POST",
    data: {
      id: selectedValue,
      tahun: tahun
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(response) {
      console.log("Response:", response);

      if (!response.lengkap) {
        let pesan = '';

        if (response.aspek_kosong && response.aspek_kosong.length > 0) {
          pesan += `Aspek belum diisi: ${response.aspek_kosong.join(', ')}.\n`;
        }

        if (response.nilai_kosong && response.nilai_kosong.length > 0) {
          pesan += `Nilai kosong pada: ${response.nilai_kosong.join(', ')}.`;
        }

        Swal.fire({
          icon: 'warning',
          title: 'Data Belum Lengkap',
          text: pesan.trim()
        });
        $('#addSurat').modal('hide');
      } else {
        // Swal.fire({
        //   icon: 'success',
        //   title: 'Lengkap',
        //   text: 'Semua data aspek dan nilai sudah lengkap.'
        // });
      }
    },
    error: function(error) {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Terjadi kesalahan saat memeriksa data guru.'
      });
    }
  });
}



function tolakSurat(id){
 $.ajax({
  url: `/surat/tolak`,
  type: "POST",
  data: {id:id},
  headers:{
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
  success:function(response){
    if (response.message == 'success') {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Surat Berhasil Ditolak'
      });
      getSurat();
    }
    else {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Surat Gagal Ditolak'
      });
    }
  },
  error:function(error){
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: 'Surat Gagal Ditolak'
    });
  }
 })
}


function teruskanSurat(data){
  let row = JSON.parse(data);
  // if (row.pedagogik == null || row.kepribadian == null || row.profesional == null || row.sosial == null) {
  //   Swal.fire({
  //     icon: 'error',
  //     title: 'Data Tidak Lengkap',
  //     text: 'Mohon lengkapi semua aspek penilaian terlebih dahulu.',
  //     confirmButtonClass: "btn btn-primary"
  //   });
  //   return ; 
  // }
 $.ajax({
  url: `/surat/teruskanSurat`,
  type: "POST",
  data: {id:row.id},
  headers:{
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
  success:function(response){
    if (response.message == 'success') {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Surat Berhasil Diteruskan'
      });
      getSurat();
    }
    else {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Surat Gagal Diteruskan'
      });
    }
  },
  error:function(error){
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: 'Surat Gagal Diteruskan'
    });
  }
 })
}


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
  let row = JSON.parse(data);
  // if (row.pedagogik == null || row.kepribadian == null || row.profesional == null || row.sosial == null) {
  //   Swal.fire({
  //     icon: 'error',
  //     title: 'Data Tidak Lengkap',
  //     text: 'Mohon lengkapi semua aspek penilaian terlebih dahulu.',
  //     confirmButtonClass: "btn btn-primary"
  //   });
  //   return ; 
  // }
  // Buat form sementara
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = '/surat/cetakSurat';
  form.target = '_blank'; // Buka di tab baru
  
  // Tambahkan CSRF token
  const csrfToken = document.createElement('input');
  csrfToken.type = 'hidden';
  csrfToken.name = '_token';
  csrfToken.value = $('meta[name="csrf-token"]').attr('content');
  form.appendChild(csrfToken);

  // Tambahkan data sebagai input hidden
  for (let key in row) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = key;
    input.value = typeof row[key] === 'object' ? JSON.stringify(row[key]) : row[key];
    form.appendChild(input);
  }

  // Tambahkan form ke body dan submit
  document.body.appendChild(form);
  form.submit();
  
  // Hapus form setelah submit
  document.body.removeChild(form);
}

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

function suratAspek(id){
 console.log('anjay');
  $.ajax({

    url: `/aspek/getAspek`,
    type: "POST", 
    headers:{
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
    cache: false,
    data: {id:id},
    success:function(response){

      console.log(response);
      $('#idAspek').val(response.id);
      $('#pedagogik').html(response.pedagogik);
      $('#kepribadian').html(response.kepribadian);
      $('#profesional').html(response.profesional);
      $('#sosial').html(response.sosial);
      $('#surat_id').val(response.surat_kinerja_id);

      $('#editAspekSurat').modal('show');

    },
    error:function(error){

    }

});
}

function getAspek(id){
  $.ajax({

    url: `/aspek/getAspek`,
    type: "POST",
    headers:{
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
    cache: false,
    data: {id:id},
    success:function(response){
      console.log(response);
      $('#idAspek').val(response.id);
      $('#pedagogik').html(response.pedagogik);
      $('#kepribadian').html(response.kepribadian);
      $('#profesional').html(response.profesional);
      $('#sosial').html(response.sosial);
      $('#surat_id').val(response.surat_kinerja_id);
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
           {data: 'status', name: 'status'},
           {data: 'penerusan', name: 'penerusan'},
           {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

   function tipesurat(){
    let tipe = $('#tipe_surat').val();
    if(tipe == 1){
      $('#keteranganSurat').attr('hidden' , false);
    } else {
      $('#keteranganSurat').attr('hidden' , true);

    }
   }
   
   $(document).ready(function(){
    
   
    $('#editAspekButton').click(function(e) {
      e.preventDefault();
  
      // define variable
      let token = $('#tokenAspek').val();
      let id = $('#idAspek').val();
      let pedagogik = $('#pedagogik').html().trim();
      let kepribadian = $('#kepribadian').html().trim();
      let profesional = $('#profesional').html().trim();
      let sosial = $('#sosial').html().trim();
      let surat_id = $('#surat_id').val();
  
      // Validasi
      if (!pedagogik || !kepribadian || !profesional || !sosial) {
          showNotification('Gagal', 'Semua aspek (pedagogik, kepribadian, profesional, sosial) harus diisi!', 'warning');
          return;
      }
  
      let data = {
          _token: token,
          id: id,
          pedagogik: pedagogik,
          kepribadian: kepribadian,
          profesional: profesional,
          sosial: sosial,
      };
  
      const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
              confirmButton: "btn btn-success",
              cancelButton: "btn btn-danger"
          },
          buttonsStyling: false
      });
  
      swalWithBootstrapButtons.fire({
          title: "Konfirmasi Perubahan Data Aspek?",
          text: "Data Akan Langsung Dirubah Pada Tabel!",
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
                  success: function(response) {
                      swalWithBootstrapButtons.fire({
                          title: "Berhasil!",
                          text: "Data Aspek Telah Dirubah",
                          icon: "success"
                      });
                      getSurat(); // atau getAspek(surat_id); tergantung kebutuhan
                  },
                  error: function(error) {
                      showNotification('Gagal', 'Terjadi kesalahan saat menyimpan perubahan!', 'error');
                  }
              });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
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

   function cekGuruSurat(idGuru) {
   
    const tahun = new Date().getFullYear(); // Misalnya: 2025
  
    $.ajax({
      url: `/surat/cekGuru`,
      type: "POST",
      data: {
        id: idGuru,
        tahun: tahun
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        console.log("Response:", response);
  
        if (!response.lengkap) {
          let pesan = '';
  
          if (response.aspek_kosong && response.aspek_kosong.length > 0) {
            pesan += `Aspek belum diisi: ${response.aspek_kosong.join(', ')}.\n`;
          }
  
          if (response.nilai_kosong && response.nilai_kosong.length > 0) {
            pesan += `Nilai kosong pada: ${response.nilai_kosong.join(', ')}.`;
          }
  
          Swal.fire({
            icon: 'warning',
            title: 'Data Belum Lengkap',
            text: pesan.trim()
          });
          return 
        } else {
         
        }
      },
      error: function(error) {
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: 'Terjadi kesalahan saat memeriksa data guru.'
        });
      }
    });
  }
  

   $(document).ready(function(){
    getSurat();
    $('#nama_guru').select2();
    $('#nama_guru_edit').select2();

    // $('#nama_guru').on('change', function(event) {
    //   if (event.originalEvent) {
    //       cekGuru(this);
    //   }
    // });

    $('#addSuratButton').click(function(e) {
      e.preventDefault();
      $('#addSurat').modal({ "backdrop": "static" });
  
      // define variable
      let token_surat = $('#token_surat').val();
      let nama_user = $('#nama_guru').val();
      let tipe_surat = $('#tipe_surat').val();
      let tanggal = $('#tanggal_add').val();
      let keterangan = $('#keterangan').val();

      // validasi form
      if (!nama_user || nama_user === '0') {
          showNotification('Gagal', 'Nama guru harus diisi!', 'warning');
          return;
      }
  
      if (!tipe_surat || tipe_surat === '0') {
          showNotification('Gagal', 'Tipe surat harus dipilih!', 'warning');
          return;
      }
  
      if (!tanggal) {
          showNotification('Gagal', 'Tanggal surat harus diisi!', 'warning');
          return;
      }
  
    
      let data = {
          _token: token_surat,
          nama_user: nama_user,
          tipe_surat: tipe_surat,
          tanggal: tanggal,
          keterangan: keterangan,
      };
  
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
                  success: function(response) {
                      swalWithBootstrapButtons.fire({
                          title: "Berhasil!",
                          text: "Data Surat Telah Ditambahkan",
                          icon: "success"
                      });
  
                      // Reset form
                      $('#nama_guru').val('0').trigger('change');
                      $('#tipe_surat').val('0').trigger('change');
                      $('#tanggal_add').val('');
                      $('#keterangan').val('');
  
                      getSurat();
                  },
                  error: function(error) {
                      showNotification('Gagal', 'Terjadi kesalahan saat menyimpan data!', 'error');
                  }
              });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
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

  function approve(id){

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger"
      },
      buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
      title: "Konfirmasi Persetujuan Surat?",
      text: "Data Akan Langsung Diupdate!",
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Simpan",
      cancelButtonText: "Batal",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
  
          $.ajax({
  
              url: `/surat/approve`,
              type: "POST",
              headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} , 
              cache: false,
              data: {id:id},
              success:function(response){
                  swalWithBootstrapButtons.fire({
                      title: "Berhasil!",
                      text: "Surat Disetujui!",
                      icon: "success"
                    });
                  getAspek(id);
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
          text: "Data Surat Tidak Disetujui",
          icon: "error"
        });
      }
    });
  
  }


  