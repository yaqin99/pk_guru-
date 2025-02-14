<div class="modal fade none-border" id="modalProfil">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h4 class="modal-title"><strong>Profil</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formProfil">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" id="nama_profil" name="nama_profil" readonly>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email_profil" name="email_profil" readonly>
                            </div>
                            {{-- <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" id="username_profil" name="username_profil" readonly>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" id="password_profil" name="password_profil" readonly>
                            </div> --}}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Telepon</label>
                                <input type="text" class="form-control" id="no_telp_profil" name="no_telp_profil" readonly>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" id="alamat_profil" name="alamat_profil" rows="3" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row mt-4">
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
                            <button type="button" class="btn btn-primary" onclick="showModalTambahAspek()">
                                <i class="bi bi-plus"></i> Tambah Aspek
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered" id="tabel_aspek_profil" style="width: 100%; color: black;">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">File Aspek</th>
                                    <th width="50%">Keterangan</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning waves-effect" onclick="editProfile()">Edit Profil</button>
                <button type="button" class="btn btn-info waves-effect" onclick="changePassword()">Ganti Password</button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
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
                <input type="hidden" id="user_id" name="user_id">
                <input type="hidden" id="aspek_id" name="aspek_id">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="simpanAspek()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>