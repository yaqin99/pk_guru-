<div class="modal fade none-border" id="addBuktiKegiatan">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h4 class="modal-title"><strong id="judulFormTambah">Bukti Pelaksanaan Kegiatan</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formBuktiKegiatan" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <input type="text" name="idBuktiKegiatan" id="idBuktiKegiatan" hidden>

                        <div class="input-group col-md-12 text-center">
                            <label class="control-label">Dokumen Terkait</label>
                            <div class="input-group mb-3">

                                <input type="text" class="form-control" placeholder="" name="namaFileBuktiKegiatan" id="namaFileBuktiKegiatan" aria-label="Example text with button addon" readonly aria-describedby="button-addon1">
                                <input class="form-control form-white" id="fileBuktiKegiatan" type="file" name="fileBuktiKegiatanNama" hidden>

                                <button class="btn btn-primary" type="button" id="bukti_kegiatan_butt" onclick="buktiKegiatanClick()">Add</button>
                              </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="addBuktiKegiatanSave" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>