<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PK Guru Al - Ghazali</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/admin/images/ghazali.png">
    <!-- Datatable -->
    <link href="/admin/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="/admin/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="/admin/images/logo.png" alt="">
                <img class="logo-compact" src="/admin/images/logo-text.png" alt="">
                <img class="brand-title" src="/admin/images/logo-text.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        @include('admin.component.navbar')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        @include('admin.component.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                @include('admin.component.greeting')
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-center">
                                <h2 class="card-title ">Data Guru</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tabel_guru" class="display" style="width:100%; align-item:center;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Guru</th>
                                                <th>Nip</th>
                                                <th>Nomer Handphone</th>
                                                <th>Email</th>
                                                <th>Alamat</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        @include('admin.modals.addGuru')
        @include('admin.modals.editGuru')
        
        <!--**********************************
            Footer start
        ***********************************-->
        @include('admin.component.footer')
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->

        
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="/admin/vendor/global/global.min.js"></script>
    <script src="/admin/js/quixnav-init.js"></script>
    <script src="/admin/js/custom.min.js"></script>
    <script src="/admin/js/modal.js"></script>
    


    <!-- Datatable -->
    <script src="/admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/admin/js/plugins-init/datatables.init.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="/admin/js/addData.js"></script>
    <script src="/admin/js/deleteData.js"></script>
    <script src="/admin/js/editData.js"></script>
    <script>

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
        getGuru()
    });
   
      
      
        
  
    </script>
</body>

</html>