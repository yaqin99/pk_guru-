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
                        <div class="col-md-6">
                            <label class="control-label">Mata Pelajaran</label>
                            <select class="form-control form-white" id="mapel_add" name="mapel_add">
                                @foreach ($mapels as $mapel )
                                <option value="{{$mapel->id}}">{{$mapel->nama_mapel}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Kelas</label>
                            <select class="form-control form-white" id="kelas_add" name="kelas_add">
                                <option value="1">10</option>
                                <option value="2">11</option>
                                <option value="3">12</option>
                                
                            </select>
                        </div>
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