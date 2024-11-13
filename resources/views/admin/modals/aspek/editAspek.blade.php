<div class="modal fade none-border" id="editAspek">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong id="judulFormEdit">Form Nilai Aspek Guru</strong></h4>
            </div>
            <div class="modal-body">

                <div class="d-flex justify-content-around">
                    
                        <button class="btn btn-outline-secondary" id="btnPedagogik" type="button" onclick="pedagogik()">Pedagogik</button>
                       

                   
                    
                        <button class="btn btn-outline-secondary" id="btnKepribadian" type="button" onclick="kepribadian()">Kepribadian</button>
                                             

               
                    
                        <button class="btn btn-outline-secondary" id="btnProfesional" type="button" onclick="profesional()">Profesional</button>
                                             
                    
                    
                        <button class="btn btn-outline-secondary" id="btnSosial" type="button" onclick="sosial()">Sosial</button> 
                                             

                    
                </div>
                <div style="max-height: 15%;" class="container">

                </div>
                <form id="formAspek" method="POST" class="mb-10">
                    <div class="row">
                        <input type="hidden" name="_token" id="tokenAspek" value="{{ csrf_token() }}">
                        <input type="hidden" name="idAspek" id="idAspek" >
                        <div class="col-md-5">
                            <label class="control-label">Total Skor</label>
                            <input class="form-control" id="totalSkor" type="number" name="nama">
                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Skor Maximal</label>
                            <input class="form-control" id="skorMaksimal" type="number" name="nip">
                        </div>
                        
                        <div class="col-md-2">
                            <label class="control-label" style="color: transparent;">Tombol</label>
                            <button class="btn btn-success text-light w-100" type="button" onclick="hitungAspek()" id="addToTabel"><i class="bi bi-plus-lg"></i></button>

                        </div>
                        
                        
                    </div>
                </form>
                <div style="max-height: 20%;" class="container">

                </div>
                <div class="table-responsive">

                    <table  class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Pedagogik</th>
                                <th scope="col">Kepribadian</th>
                                <th scope="col">Profesional</th>
                                <th scope="col">Sosial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" id="nomer"></th>
                                <td><p class="text-center" id="pedagogik"></p></td>
                                <td><p class="text-center" id="kepribadian"></p></td>
                                <td><p class="text-center" id="profesional"></p></td>
                                <td><p class="text-center" id="sosial"></p></td>
                                
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="simpan_edit" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>