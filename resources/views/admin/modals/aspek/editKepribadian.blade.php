<div class="modal fade none-border" id="editKepribadian">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Edit Data Kepribadian</strong></h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="_token" id="token_kepribadian_edit" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="idKepribadian_edit" >

                        <div class="col-md-6">
                            <label class="control-label">Nama Kepribadian</label>
                            <input class="form-control form-white" id="nama_kepribadian_edit" type="text" name="nama_kepribadian">
                        </div>
                        
                       
                        <div class="input-group col-md-6" >
                            <label class="control-label">Dokumen Pendukung</label>
                            <div class="input-group mb-3">

                                <input type="text" class="form-control" placeholder="" id="namaFileKepribadian_edit" aria-label="Example text with button addon" readonly aria-describedby="button-addon1">
                                <button class="btn btn-primary" type="button" id="kepribadian_dokumen_button_edit" onclick="editKepribadianFile()">Add</button>
                              </div>
                        </div>
                        <div class="col-md-6" hidden>
                            <label class="control-label">File</label>
                            <input class="form-control form-white" id="fileKepribadian_edit" type="file" name="rpp">
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="buttonTambahKepribadian_edit" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>