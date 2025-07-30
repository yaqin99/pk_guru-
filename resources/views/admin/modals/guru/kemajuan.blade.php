<div class="modal fade" id="kemajuanSekolah" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h4 class="modal-title"><strong>Grafik Kemajuan Sekolah</strong></h4>
                <select id="filterTahun" class="form-select" style="width:150px;">
                    <option value="all" selected>Keseluruhan</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Grafik Jumlah Murid -->
                    <div class="col-md-6">
                        <h6>Jumlah Murid per Tahun</h6>
                        <canvas id="chartMurid" height="150"></canvas>
                    </div>

                    <!-- Grafik Jumlah Guru -->
                    <div class="col-md-6">
                        <h6>Jumlah Guru per Tahun</h6>
                        <canvas id="chartGuru" height="150"></canvas>
                    </div>
                </div>

                <hr>

                <div class="row mt-3">
                    <!-- Status Guru -->
                    <div class="col-md-6">
                        <h6>Status Guru</h6>
                        <canvas id="chartStatusGuru" height="150"></canvas>
                    </div>

                    <!-- Indeks Kemajuan -->
                    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <h6>Indeks Kemajuan Sekolah</h6>
                        <div id="indeksKemajuan" class="p-3 text-center rounded" style="font-size:20px; font-weight:bold;">
                            Memuat...
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
