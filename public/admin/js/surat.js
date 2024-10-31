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
           {data: 'detail_surat', name: 'detail_surat'},
           {data: 'tipe', name: 'tipe'},
           {data: 'tanggal', name: 'tanggal'},
           {data: 'action', name: 'action', orderable: false, searchable: false},
     ]
 });
   }

   $(document).ready(function(){
    getSurat();
  });