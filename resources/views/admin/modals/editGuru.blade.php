<div class="modal fade none-border" id="editGuru">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong id="judulFormEdit">Edit Data Guru</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formEditGuru" method="POST">
                    <div class="row">
                        <input type="hidden" name="_token" id="tokenEdit" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_guru" id="id_guru" >
                        <div class="col-md-6">
                            <label class="control-label">Nama Lengkap</label>
                            <input class="form-control form-white" id="nama_edit" type="text" name="nama">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">NIP</label>
                            <input class="form-control form-white" id="nip_edit" type="text" name="nip">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Nomer Handphone</label>
                            <input class="form-control form-white" id="no_hp_edit" type="text" name="no_hp">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Alamat</label>
                            <input class="form-control form-white" id="alamat_edit" type="text" name="alamat">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Email</label>
                            <input class="form-control form-white" id="email_edit" type="text" name="email">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="control-label">Mata Pelajaran</label>
                            <select class="form-control form-white" id="mapel_edit" name="mapel_edit">
                                @foreach ($mapels as $mapel )
                                <option value="{{$mapel->id}}">{{$mapel->nama_mapel}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Kelas</label>
                            <select class="form-control form-white" id="kelas_edit" name="kelas_edit">
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
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="simpan_edit" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>