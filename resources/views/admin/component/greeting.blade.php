<div class="row page-titles mx-0">
    
    
    <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex mt-5">
        <ol class="breadcrumb">
            @if ($pages == 'guru')
            <li class="breadcrumb-item"><button onclick="showAddGuru()" data-bs-toggle="modal" class="btn btn-secondary text-left text-light"><i class="bi bi-plus-circle"></i> Tambah Guru</button></li>
            @elseif ($pages == 'pengajuan')
            <li class="breadcrumb-item"><button onclick="showAddPengajuan()" data-bs-toggle="modal" data-bs-target="#modalJenisTambah" class="btn btn-secondary text-left text-light"><i class="bi bi-plus-circle"></i> Tambah Pengajuan</button></li>
            @elseif ($pages == 'surat')
            <li class="breadcrumb-item"><button onclick="showAddSurat()" data-bs-toggle="modal" data-bs-target="#modalModulTambah" class="btn btn-secondary text-left text-light"><i class="bi bi-plus-circle"></i> Tambah Surat</button></li>
           
            @endif
        </ol>
    </div>
</div>