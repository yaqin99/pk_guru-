<div class="modal fade none-border" id="editPengajuan">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong >Tambah Data Pengajuan</strong></h4>
            </div>
            <div class="modal-body">
                <form id="formEditPengajuan" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="_token" id="token_pengajuan_id" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="theId" >

                        <div class="col-md-12">
                            <label for="nama_kegiatan_id" class="form-label">Program Kegiatan Kinerja</label>
                            <select id="nama_kegiatan_id" name="nama_kegiatan_id" onchange="getSingleProgramEdit()" class="form-select form-control">
                                <option selected>-Pilih-</option>
                                @foreach ($program as $pro)
                                <option value="{{$pro->id}}">{{$pro->nama_program}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Waktu Pelaksanaan</label>
                            <input class="form-control form-white" id="waktu_id" type="text" name="waktu_id" readonly> 
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Estimasi Poin</label>
                            <input class="form-control form-white" id="jumlah_poin_id" type="text" name="jumlah_poin_id" readonly> 
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
                        
                        <div class="input-group col-md-6" id="old_bukti">
                            <label class="control-label">Bukti Kegiatan</label>
                            <div class="input-group mb-3">

                                <input type="text" class="form-control" placeholder="" id="cek_bukti" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                <button class="btn btn-primary" type="button" id="cek_file_bukti" onclick="changing_bukti()">Ubah</button>
                              </div>
                        </div>
                        <div class="col-md-6" id="new_bukti" hidden>
                            <label class="control-label">Bukti Kegiatan</label>
                            <input class="form-control form-white" id="bukti_edit_real" type="file" name="bukti_edit_real">
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