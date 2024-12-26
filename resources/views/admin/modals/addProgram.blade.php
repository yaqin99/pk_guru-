<div class="modal fade none-border" id="addProgram">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Tambah Data Guru</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formProgram" method="POST">
                    <div class="row">
                        
                        <div class="col-md-12">
                            <label class="control-label">Nama Program Kegiatan</label>
                            <textarea class="col-md-12" name="nama_program" id="nama_program" cols="30" rows="5" "></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="poin" class="form-label">Poin</label>
                            <select id="poin" name="poin" class="form-select form-control">
                                <option selected value="5">5 Poin</option>
                                <option value="10">10 Poin</option>
                                <option value="15">15 Poin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="pelaksanaan" class="form-label">Pelaksanaan</label>
                            <select id="pelaksanaan" name="pelaksanaan" class="form-select form-control">
                                <option selected value="1">1 Semester</option>
                                <option value="2">2 Semester</option>
                            </select>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="simpanProgram" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>