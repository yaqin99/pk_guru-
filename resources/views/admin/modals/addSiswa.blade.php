<div class="modal fade none-border" id="addSiswa">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong id="judulFormSiswa">form Tambah Data Siswa</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formAddDataSiswa" method="POST">
                    <div class="row">
                        <input type="hidden" name="id_siswa" id="id_siswa" >
                        <div class="col-md-6">
                            <label class="control-label">Nama Lengkap</label>
                            <input class="form-control form-white" id="nama_siswa" type="text" name="nama_siswa">

                        </div>
                        <div class="col-md-6 ">
                            <label class="control-label">Kelas</label>
                            <select class="form-control form-white" id="kelas" name="kelas">
                                <option value="10 A">10 A</option>
                                <option value="10 B">10 B</option>
                                <option value="10 C">10 C</option>
                                <option value="10 D">10 D</option>            
                                <option value="11 A">11 A</option>
                                <option value="11 B">11 B</option>
                                <option value="11 C">11 C</option>
                                <option value="11 D">11 D</option>                             
                                <option value="12 A">12 A</option>
                                <option value="12 B">12 B</option>
                                <option value="12 C">12 C</option>
                                <option value="12 D">12 D</option> 
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="control-label">No Absen</label>
                            <input class="form-control form-white" id="no_absen" type="number" readonly name="no_absen">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Nomer Handphone</label>
                            <input class="form-control form-white" id="no_hp" type="text" name="no_hp">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Angkatan</label>
                            <select class="form-control form-white" id="angkatan" name="angkatan">
                                @for ($year = now()->year; $year >= 2023; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>

                            
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="simpanSiswa" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>