<div class="modal fade none-border" id="addSosial">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong >Tambah Data Sosial</strong></h4>
            </div>
            <div class="modal-body">
                <form id="form_tambah_sosial" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="_token" id="token_sosial" value="{{ csrf_token() }}">

                        <div class="col-md-6">
                            <label class="control-label">Nama Sosial</label>
                            <input class="form-control form-white" id="nama_sosial" type="text" name="nama_sosial">
                        </div>
                        
                       
                        <div class="input-group col-md-6">
                            <label class="control-label">Dokumen Pendukung</label>
                            <div class="input-group mb-3">

                                <input type="text" class="form-control" placeholder="" id="namaFileSosial" aria-label="Example text with button addon" readonly aria-describedby="button-addon1">
                                <button class="btn btn-primary" type="button" id="sosial_dokumen_button" onclick="addSosialFile()">Add</button>
                              </div>
                        </div>
                        <div class="col-md-6" hidden>
                            <label class="control-label">File</label>
                            <input class="form-control form-white" id="fileSosial" type="file" name="fileSosial">
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="buttonTambahSosial" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>