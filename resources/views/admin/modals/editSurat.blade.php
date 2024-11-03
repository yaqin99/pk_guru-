<div class="modal fade none-border" id="editSurat">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong >Edit Data Surat</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formEditSurat" method="POST" >
                        <input type="hidden" name="_token" id="token_surat_edit" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id_surat">

                        <div class="col-md-12">
                            <label for="nama_guru_edit" class="form-label">Nama Guru</label>
                            <select id="nama_guru_edit" name="nama_guru_edit" class="form-select form-control">
                                <option selected>-Pilih-</option>
                                @foreach ($gurus as $guru)
                                    
                                <option value="{{$guru->id}}">{{$guru->nama_user}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Nama Surat</label>
                            <input class="form-control" id="nama_surat_edit" type="text" name="nama_surat_edit">
                        </div>
                        <div class="col-md-12">
                            <label for="tipe_surat_edit" class="form-label">Tipe Surat</label>
                            <select id="tipe_surat_edit" name="tipe_surat_edit" class="form-select form-control">
                                <option value="1">Surat Penilaian Kinerja</option>
                                <option value="2">Surat Teguran Kinerja</option>
                            </select>
                        </div>
                    
                        <div class="col-md-12">
                            <label class="control-label">Tanggal Surat</label>
                            <input class="form-control" id="tanggal_edit" type="date" name="tanggal_edit">
                        </div>
                        
                        <div class="col-md-12">
                            <label class="control-label">Keterangan</label>
                            <textarea class="col-md-12" name="ketarangan_edit" id="keterangan_edit" cols="30" rows="5"></textarea>
                        </div>
                        
                        
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="buttonEdit" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>