<div class="modal fade" id="grafikGuru" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h4 class="modal-title"><strong>Grafik Performa Guru</strong></h4>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <select class="form-control" id="filterGrafik">
                            <option value="kompetensi">Kompetensi</option>
                            <option value="kehadiran">Kehadiran</option>
                            <option value="kinerja">Kinerja Guru</option>
                        </select>
                    </div>
                </div>
                <canvas id="chartPerforma" height="100"></canvas>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
