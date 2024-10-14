function getPengajuan(){
    $("#tabel_pengajuan").dataTable().fnDestroy();

   var table = $('#tabel_pengajuan').DataTable({
     processing: true,
     serverSide: true,
     ajax: "/pengajuan",
     columns: [
         {data: null,"sortable": false, 
            render: function (data, type, row, meta) {
                console.log(data)
            return meta.row + meta.settings._iDisplayStart + 1;
           }  },
         {data: 'nama_guru', name: 'nama_guru'},
         {data: 'nip', name: 'nip'},
         {data: 'no_hp', name: 'no_hp'},
         {data: 'alamat', name: 'alamat'},
         {data: 'email', name: 'email'},
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

$( document ).ready(function() {     
   console.log('called pengajuan');
   getPengajuan()
});
