<div class="modal fade none-border" id="editCatatan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong >Berikan Catatan Pada Guru</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formTambahSurat" method="POST" >
                        <input type="hidden" name="id" id="idCatatan" >

                        
                        
                        <div class="col-md-12" >
                            <label class="control-label">Catatan</label>
                            <textarea class="col-md-12" name="catatan" id="catatan" cols="30" rows="5"></textarea>
                        </div>
                        
                        
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="btnCatatan" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>