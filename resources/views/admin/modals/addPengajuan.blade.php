<div class="modal fade none-border" id="addPengajuan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong id="judulFormTambah">Tambah Data Pengajuan</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formTambahPengajuan" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="_token" id="token_pengajuan" value="{{ csrf_token() }}">

                        <div class="col-md-6">
                            <label class="control-label">Nama Kegiatan</label>
                            <input class="form-control form-white" id="nama_kegiatan" type="text" name="nama_kegiatan">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="waktu" class="form-label">Waktu Pelaksanaan</label>
                            <select id="waktu" name="waktu" class="form-select form-control">
                                <option selected>-Pilih-</option>
                                <option value="1 Semester">1 Semester</option>
                                <option value="2 Semester">2 Semester</option>
                            </select>
                        </div>
                    
                        <div class="col-md-6">
                            <label class="control-label">Estimasi Poin</label>
                            <input class="form-control form-white" id="jumlah_poin" type="number" name="jumlah_poin">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Rpp Modul</label>
                            <input class="form-control form-white" id="rpp" type="file" name="rpp">
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="addPengajuanButton" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>