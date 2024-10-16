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
         {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

$( document ).ready(function() {     
   getGuru()
});
