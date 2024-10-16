function getPengajuan(){
    $("#tabel_pengajuan").dataTable().fnDestroy();

   var table = $('#tabel_pengajuan').DataTable({
     processing: true,
     serverSide: true,
     ajax: "/pengajuan",
     columns: [
         {data: null,"sortable": false, 
            render: function (data, type, row, meta) {
                console.log(data.pengajuan)
            return meta.row + meta.settings._iDisplayStart + 1;
           }  },
         {data: 'nama_user', name: 'nama_user'},
         {data: 'nama_kegiatan', name: 'nama_kegiatan'},
         {data: 'catatan', name: 'catatan'},
         {data: 'jumlah_poin', name: 'jumlah_poin'},
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

$( document ).ready(function() {     
   console.log('called pengajuan');
   getPengajuan()
});
