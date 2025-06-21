<div class="modal fade none-border" id="modalProfil">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h4 class="modal-title"><strong>Profil</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formProfil" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="user_id" name="user_id">
                    <!-- Foto Profil -->
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <div class="position-relative d-inline-block">
                                <label for="upload_foto" style="cursor: pointer; margin: 0;">
                                    <img id="foto_profil" src="/admin/images/kontak2.png" 
                                         class="rounded-circle" 
                                         style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #007bff; transition: opacity 0.3s;">
                                    
                                </label>
                                <input type="file" id="upload_foto" name="foto" class="d-none" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <!-- Data Diri -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" id="nama_profil" name="nama_user" >
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email_profil" name="email" >
                            </div>
                            <div class="form-group">
                                <label>Perolehan Poin</label>
                                <input type="number" readonly class="form-control" id="perolehan_poin" name="perolehan_poin" >
                            </div>
                            {{-- <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" id="username_profil" name="username_profil" >
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" id="password_profil" name="password_profil" >
                            </div> --}}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Telepon</label>
                                <input type="text" class="form-control" id="no_telp_profil" name="no_hp" >
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" id="alamat_profil" name="alamat" rows="3" ></textarea>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row mt-4" id="aspekSection">
                    <div class="col-md-12 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="col-md-4 px-0">
                                <select class="form-control" id="filterAspekProfil">
                                    <option value="1">Pedagogik</option>
                                    <option value="2">Kepribadian</option>
                                    <option value="3">Profesional</option>
                                    <option value="4">Sosial</option>
                                </select>
                            </div>
                            {{-- <button type="button" class="btn btn-primary" onclick="showModalTambahAspek({{Auth::user()->id}})">
                                <i class="bi bi-plus"></i> Tambah Aspek
                            </button> --}}
                        </div>
                    </div>
                    <div class="col-md-12">
                        {{-- <table class="table table-bordered" id="tabel_aspek_profil" style="width: 100%; color: black;">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">File Aspek</th>
                                    <th width="40%">Keterangan</th>
                                    <th width="5%">Poin</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table> --}}

                        <table class="table table-bordered" id="tabel_aspek_profil" style="width: 100%; color: black; ">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Nama Guru</th>
                                    <th width="10%">Skor</th>
                                    <th width="25%">Keterangan</th>
                                    <th width="20%">Jumlah Penilai</th>
                                    <th width="20%">Tahun Ajaran</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="updateProfile()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Aspek -->
<div class="modal fade" id="modalTambahAspek" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Aspek</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formTambahAspek" enctype="multipart/form-data">
                <input type="hidden" id="aspek_id" name="aspek_id">
                <input type="hidden" id="user_id_cek" name="user_id_cek">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Jenis Aspek</label>
                        <select class="form-control" id="jenis_aspek" name="jenis_aspek" required>
                            <option value="1">Pedagogik</option>
                            <option value="2">Kepribadian</option>
                            <option value="3">Profesional</option>
                            <option value="4">Sosial</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>File</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="file_name" readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" onclick="$('#file_aspek').click()">
                                    <i class="bi bi-upload"></i> Pilih File
                                </button>
                            </div>
                        </div>
                        <input type="file" class="d-none" id="file_aspek" name="file_aspek" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" id="keterangan_aspek" name="keterangan_aspek" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input class="form-control" id="tanggal_guru_add" name="tanggal_guru_add" type="date" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="simpanAspek()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>