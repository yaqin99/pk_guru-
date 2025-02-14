<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PK Guru Al - Ghazali</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/admin/images/yala.png">
    <!-- Datatable -->
    <link href="/admin/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="/admin/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
                <img class="logo-abbr" src="/admin/images/pk_guru_logo.png" alt="">
                <img class="logo-compact" src="/admin/images/pk_guru.png" alt="">
                <img class="brand-title" src="/admin/images/pk_guru.png" alt="">
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

                @yield('main')
                
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        @include('admin.modals.addGuru')
        @include('admin.modals.editGuru')
        @include('admin.modals.profil.profil')
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js" integrity="sha256-/H4YS+7aYb9kJ5OKhFYPUjSJdrtV6AeyJOtTkw6X72o=" crossorigin="anonymous"></script>

    <script src="/admin/js/addData.js"></script>
    <script src="/admin/js/aspek/pedagogik.js"></script>
    <script src="/admin/js/aspek/kepribadian.js"></script>
    <script src="/admin/js/aspek/profesional.js"></script>
    <script src="/admin/js/aspek/sosial.js"></script>

    <script src="/admin/js/deleteData.js"></script>
    <script src="/admin/js/editData.js"></script>
    <script src="/admin/js/guru.js"></script>
    <script src="/admin/js/pengajuan.js"></script>
    <script src="/admin/js/surat.js"></script>
    <script src="/admin/js/program.js"></script>
    <script src="/admin/js/profil.js"></script>
</body>

</html>