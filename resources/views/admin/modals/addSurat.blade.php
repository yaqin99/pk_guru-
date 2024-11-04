<div class="modal fade none-border" id="addSurat">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong >Tambah Data Surat</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formTambahSurat" method="POST" >
                        <input type="hidden" name="_token" id="token_surat" value="{{ csrf_token() }}">

                        <div class="col-md-12">
                            <label for="nama_guru" class="form-label">Nama Guru</label>
                            <select id="nama_guru" name="nama_guru" class="form-select form-control">
                                <option selected value="0">-Pilih-</option>
                                @foreach ($gurus as $guru)
                                
                                <option value="{{$guru->id}}">{{$guru->nama_user}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="tipe_surat" class="form-label">Tipe Surat</label>
                            <select id="tipe_surat" name="tipe_surat" class="form-select form-control">
                                <option selected value="0">-Pilih-</option>
                                <option value="1">Surat Penilaian Kinerja</option>
                                <option value="2">Surat Teguran Kinerja</option>
                            </select>
                        </div>
                    
                        <div class="col-md-12">
                            <label class="control-label">Tanggal Surat</label>
                            <input class="form-control" id="tanggal" type="date" name="tanggal">
                        </div>
                        
                        <div class="col-md-12">
                            <label class="control-label">Keterangan</label>
                            <textarea class="col-md-12" name="ketarangan" id="keterangan" cols="30" rows="5"></textarea>
                        </div>
                        
                        
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="addSuratButton" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>