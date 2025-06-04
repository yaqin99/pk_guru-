<!-- Modal -->
<div class="modal fade" id="nilaiAspekModal" tabindex="-1" aria-labelledby="nilaiAspekModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nilaiAspekModalLabel">Penilaian File</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="pilihanNilai" id="pilihan1" value="file_tidak_lengkap">
            <label class="form-check-label" for="pilihan1">File tidak lengkap</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="pilihanNilai" id="pilihan2" value="file_kurang_lengkap">
            <label class="form-check-label" for="pilihan2">File kurang lengkap</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="pilihanNilai" id="pilihan3" value="file_lengkap">
            <label class="form-check-label" for="pilihan3">File lengkap</label>
          </div>
        </div>

        <div class="mt-3" id="pesanTambahanBox" style="display: none;">
          <label for="pesanTambahan">Pesan untuk melengkapi file:</label>
          <textarea class="form-control" id="pesanTambahan" rows="3" placeholder="Masukkan pesan..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onclick="kirimPenilaian()">Kirim</button>
      </div>
    </div>
  </div>
</div>
