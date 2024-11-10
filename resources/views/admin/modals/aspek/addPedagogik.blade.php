<div class="modal fade none-border" id="addPedagogik">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong >Tambah Data Pedagogik</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formEditPengajuan" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="_token" id="token_pedagogik" value="{{ csrf_token() }}">

                        <div class="col-md-6">
                            <label class="control-label">Nama Pedagogik</label>
                            <input class="form-control form-white" id="nama_pedagogik" type="text" name="nama_pedagogik">
                        </div>
                        
                       
                        <div class="input-group col-md-6" id="old">
                            <label class="control-label">Dokumen Pendukung</label>
                            <div class="input-group mb-3">

                                <input type="text" class="form-control" placeholder="" id="namaFilePedagogik" aria-label="Example text with button addon" readonly aria-describedby="button-addon1">
                                <button class="btn btn-primary" type="button" id="pedagogik_dokumen_button" onclick="addPedagogikFile()">Add</button>
                              </div>
                        </div>
                        <div class="col-md-6" id="new" hidden>
                            <label class="control-label">File</label>
                            <input class="form-control form-white" id="filePedagogik" type="file" name="rpp">
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="buttonTambahPedagogik" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>