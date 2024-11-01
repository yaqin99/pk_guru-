<div class="modal fade none-border" id="editPengajuan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong >Tambah Data Pengajuan</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formEditPengajuan" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="_token" id="token_pengajuan_id" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="theId" >

                        <div class="col-md-6">
                            <label class="control-label">Nama Kegiatan</label>
                            <input class="form-control form-white" id="nama_kegiatan_id" type="text" name="nama_kegiatan">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="waktu_id" class="form-label">Waktu Pelaksanaan</label>
                            <select id="waktu_id" name="waktu" class="form-select form-control">
                                <option selected>-Pilih-</option>
                                <option value="1 Semester">1 Semester</option>
                                <option value="2 Semester">2 Semester</option>
                            </select>
                        </div>
                    
                        <div class="col-md-6">
                            <label class="control-label">Estimasi Poin</label>
                            <input class="form-control form-white" id="jumlah_poin_id" type="number" name="jumlah_poin">
                        </div>
                        <div class="input-group col-md-6" id="old">
                            <label class="control-label">Rpp Modul</label>
                            <div class="input-group mb-3">

                                <input type="text" class="form-control" placeholder="" id="cek" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                <button class="btn btn-primary" type="button" id="cek_file" onclick="changing()">Ubah</button>
                              </div>
                        </div>
                        <div class="col-md-6" id="new" hidden>
                            <label class="control-label">Rpp Modul</label>
                            <input class="form-control form-white" id="rpp_id" type="file" name="rpp">
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="addPengajuanButton_edit" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>