<div class="modal fade none-border" id="modalPenilaian">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h4 class="modal-title"><strong>Penilaian Aspek Guru</strong></h4>
            </div>
            <div class="modal-body">
                <div class="row mt-4">
                    <div class="col-md-12 mb-3">
                        <div class="d-flex justify-content-start">
                            <div class="col-md-4 px-0">
                                <select class="form-control" id="filterAspekPenilaian">
                                    <option value="1">Pedagogik</option>
                                    <option value="2">Kepribadian</option>
                                    <option value="3">Profesional</option>
                                    <option value="4">Sosial</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <form id="formPenilaianSiswa">
                            @csrf
                            <input type="hidden" id="user_id" name="user_id">
                            <input type="hidden" id="guru_id" name="guru_id">

                            <table class="table table-bordered" style="width: 100%; color: black;">
                                <thead class="text-center">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 40%">Komponen Penilaian</th>
                                        <th style="width: 15%">Tidak ada bukti<br>(tidak terpenuhi)</th>
                                        <th style="width: 15%">Terpenuhi Sebagian</th>
                                        <th style="width: 15%">Seluruhnya Terpenuhi</th>
                                    </tr>
                                </thead>

                                <tbody id="tabel_komponen_aspek">
                                    {{-- Akan diisi dengan JavaScript --}}
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger"  onclick="tutupPenilaian()" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="addPenilaian()">Simpan</button>
            </div>
        </div>
    </div>
</div>
