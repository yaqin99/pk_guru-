<div class="modal fade none-border" id="addGuru">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong id="judulFormTambah">Tambah Data Guru</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formTambahGuru" method="POST">
                    <div class="row">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                        <div class="col-md-6">
                            <label class="control-label">Nama Lengkap</label>
                            <input class="form-control form-white" id="nama" type="text" name="nama">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">NIP</label>
                            <input class="form-control form-white" id="nip" type="text" name="nip">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Nomer Handphone</label>
                            <input class="form-control form-white" id="no_hp" type="text" name="no_hp">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Alamat</label>
                            <input class="form-control form-white" id="alamat" type="text" name="alamat">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Email</label>
                            <input class="form-control form-white" id="email" type="text" name="email">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" id="labelUsername">Username</label>
                            <input class="form-control form-white" id="username" type="text" name="username">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" id="labelPassword">Password</label>
                            <input class="form-control form-white" id="password" type="text" name="password">
                        </div>
                        {{-- <div class="col-md-6">
                            <label class="control-label">Choose Category Color</label>
                            <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                <option value="success">Success</option>
                                <option value="danger">Danger</option>
                                <option value="info">Info</option>
                                <option value="pink">Pink</option>
                                <option value="primary">Primary</option>
                                <option value="warning">Warning</option>
                            </select>
                        </div> --}}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="simpan" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>