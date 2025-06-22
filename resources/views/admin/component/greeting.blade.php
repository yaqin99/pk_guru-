<div class="row page-titles mx-0">
    
    
    <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex mt-5">
        <ol class="breadcrumb">
            @if ($pages == 'guru')
            <li class="breadcrumb-item"><button onclick="showAddGuru()" data-bs-toggle="modal" class="btn btn-secondary text-left text-light"><i class="bi bi-plus-circle"></i> Tambah Guru</button></li>
            <li class="breadcrumb-item"><button onclick="showResetPoinGuru()" data-bs-toggle="modal" class="btn btn-warning text-left text-dark"><i class="bi bi-arrow-counterclockwise"></i> Reset Poin Guru</button></li>
            @elseif ($pages == 'pengajuan')
                @if (Auth::user()->role == 1)
                <li class="breadcrumb-item"><button onclick="showAddPengajuan()" data-bs-toggle="modal" data-bs-target="#modalJenisTambah" class="btn btn-secondary text-left text-light"><i class="bi bi-plus-circle"></i> Tambah Pengajuan</button></li>
                @endif
            @elseif ($pages == 'surat')
                @if (Auth::user()->role == 2)
                <li class="breadcrumb-item"><button onclick="showAddSurat()" data-bs-toggle="modal" data-bs-target="#modalModulTambah" class="btn btn-secondary text-left text-light"><i class="bi bi-plus-circle"></i> Tambah Surat</button></li>
                @endif
           
            @elseif ($pages == 'siswa')
                @if (Auth::user()->role == 2)
                <li class="breadcrumb-item"><button onclick="showAddSiswa()" data-bs-toggle="modal" data-bs-target="#modalModulTambah" class="btn btn-secondary text-left text-light"><i class="bi bi-plus-circle"></i> Tambah Siswa</button></li>
                <li class="breadcrumb-item"><button onclick="sendWaAllSiswa()" data-bs-toggle="modal" class="btn btn-warning text-left text-dark"><i class="bi bi-chat-text"></i>
                    Chat Siswa</button></li>

                @endif
           
            @elseif ($pages == 'pedagogik')
                @if (Auth::user()->role == 1)
                <li class="breadcrumb-item"><button onclick="showAddPedagogik()" data-bs-toggle="modal" data-bs-target="#modalModulTambah" class="btn btn-secondary text-left text-light"><i class="bi bi-plus-circle"></i> Tambah Pedagogik</button></li>
                @endif
           
            @elseif ($pages == 'sosial')
                @if (Auth::user()->role == 1)
                    
                <li class="breadcrumb-item"><button onclick="showAddSosial()" data-bs-toggle="modal" data-bs-target="#modalModulTambah" class="btn btn-secondary text-left text-light"><i class="bi bi-plus-circle"></i> Tambah Sosial</button></li>
                @endif
           
            @elseif ($pages == 'profesional')
                @if (Auth::user()->role == 1)
                    
                <li class="breadcrumb-item"><button onclick="showAddProfesional()" data-bs-toggle="modal" data-bs-target="#modalModulTambah" class="btn btn-secondary text-left text-light"><i class="bi bi-plus-circle"></i> Tambah Profesional</button></li>
                @endif
           
            @elseif ($pages == 'kepribadian')
            @if (Auth::user()->role == 1)
                
            <li class="breadcrumb-item"><button onclick="showAddKepribadian()" data-bs-toggle="modal" data-bs-target="#modalModulTambah" class="btn btn-secondary text-left text-light"><i class="bi bi-plus-circle"></i> Tambah Kepribadian</button></li>
            @endif

            @elseif ($pages == 'program')
                
            <li class="breadcrumb-item"><button onclick="showAddProgram()" data-bs-toggle="modal" data-bs-target="#modalProgram" class="btn btn-secondary text-left text-light"><i class="bi bi-plus-circle"></i> Tambah Program Kegiatan</button></li>
            
           
            @endif
        </ol>
    </div>
</div>