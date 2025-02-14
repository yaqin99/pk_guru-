let nama_awal = null;
function getGuru(){
    $("#tabel_guru").dataTable().fnDestroy();

   var table = $('#tabel_guru').DataTable({
     processing: true,
     serverSide: true,
     ajax: "/guru",
     columns: [
         {data: null,"sortable": false, 
            render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
           }  },
         {data: 'nama_user', name: 'nama_user'},
         {data: 'nip', name: 'nip'},
         {data: 'no_hp', name: 'no_hp'},
         {data: 'alamat', name: 'alamat'},
         {data: 'email', name: 'email'},
         {data: 'poin', name: 'poin'},
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

$( document ).ready(function() {     
   getGuru()
});

$(document).ready(function() {
  $('#tabel_aspek').DataTable();
});

// Tambahkan variabel global untuk menyimpan ID guru
window.currentGuruId = null;

function viewAspek(row) {
  let data = JSON.parse(row); 
    // Simpan ID guru ke variabel global
    window.currentGuruId = data.id;
    loadAspekData(data.id, $('#filterAspek').val() , data.nama_user);
}

function download(id, dokumen, aspekType) {
    window.open(`/guru/download/${id}/${dokumen}/${aspekType}`, '_blank');
}

function loadAspekData(id, aspekType, nama_user) {
  console.log(id, aspekType, nama_user);
  nama_awal = nama_user;
    $.ajax({
        url: "/guru/aspek/" + id,
        type: "GET",
        data: { type: aspekType },
        dataType: "json",
        success: function(response) {
            let tbody = "";
            
            response.forEach(function(item, index) {
                // Tentukan nama field yang akan ditampilkan berdasarkan tipe aspek
                let namaField;
                let typeNumber;
                let folder;
                switch(aspekType) {
                    case '1':
                        namaField = item.nama_pedagogik;
                        typeNumber = 1;
                        folder = 'pedagogik';
                        nama_user = nama_user;
                        break;
                    case '2':
                        namaField = item.nama_kepribadian;
                        typeNumber = 2;
                        folder = 'kepribadian';
                        nama_user = nama_user;
                        break;
                    case '3':
                        namaField = item.nama_profesional;
                        typeNumber = 3;
                        folder = 'profesional';
                        nama_user = nama_user;
                        break;
                    case '4':
                        namaField = item.nama_sosial;
                        typeNumber = 4;
                        folder = 'sosial';
                        nama_user = nama_user;
                        break;
                    default:
                        namaField = item.nama_pedagogik;
                        typeNumber = 1;
                        folder = 'pedagogik';
                        nama_user = nama_user;
                }

              tbody += `<tr style="color: black;">
                    <td>${index + 1}</td>
                    <td>${namaField}</td>
                    <td>${item.dokumen}</td>
                    <td>
                       <div class="btn-group">
                          <a class="btn btn-primary btn-sm text-light" target="_blank" href="/storage/${nama_user}/${folder}/${item.dokumen}"><i class="bi bi-download"></i></a>
                       </div>
                    </td>
                </tr>`;
            });
            
            let table = $('#tabel_aspek').DataTable();
            table.clear().destroy();
            $("#tabel_aspek tbody").html(tbody);
            $('#tabel_aspek').DataTable();
            $("#aspekGuru").modal("show");
        },
        error: function(xhr, status, error) {
            console.error("Terjadi kesalahan: ", error);
        }
    });
}

// Event listener untuk perubahan filter tidak perlu diubah karena sudah menggunakan window.currentGuruId
$(document).ready(function() {
    $('#filterAspek').on('change', function() {
        
        if (window.currentGuruId) {
            loadAspekData(window.currentGuruId, $(this).val() , nama_awal);
        }
    });
});
