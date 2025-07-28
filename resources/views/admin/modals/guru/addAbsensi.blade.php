<div class="modal fade" id="modalAbsensiManual" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Input Absensi Guru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="formAbsensiManual">
            @csrf
            <div class="mb-3">
              <label>Nama Guru</label>
              <select name="user_id" class="form-select select2" required>
                <option value="">-- Pilih Guru --</option>
                @foreach ($guru as $g)
                  <option value="{{ $g->id }}">{{ $g->nama_user }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label>Keterangan</label>
              <select name="keterangan" class="form-select select2" required>
                <option value="">-- Pilih Keterangan --</option>
                <option value="hadir">Hadir</option>
                <option value="sakit">Sakit</option>
                <option value="izin">Izin</option>
                <option value="alpha">Alpha</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" onclick="submitAbsensiManual()" class="btn btn-success">Simpan</button>
        </div>
      </div>
    </div>
  </div>