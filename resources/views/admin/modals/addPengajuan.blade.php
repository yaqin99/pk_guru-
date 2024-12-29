<div class="modal fade none-border" id="addPengajuan">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong id="judulFormTambah">Tambah Data Pengajuan</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formTambahPengajuan" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="_token" id="token_pengajuan" value="{{ csrf_token() }}">

                        
                        <div class="col-md-12">
                            <label for="nama_kegiatan" class="form-label">Program Kegiatan Kinerja</label>
                            <select id="nama_kegiatan" name="nama_kegiatan" onchange="getSingleProgram()" class="form-select form-control">
                                <option selected>-Pilih-</option>
                                @foreach ($program as $pro)
                                <option value="{{$pro->id}}">{{$pro->nama_program}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Waktu Pelaksanaan</label>
                            <input class="form-control form-white" id="waktu" type="text" name="waktu" readonly> 
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Estimasi Poin</label>
                            <input class="form-control form-white" id="jumlah_poin" type="text" name="jumlah_poin" readonly> 
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