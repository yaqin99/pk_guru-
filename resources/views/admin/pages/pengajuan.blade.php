@extends('admin.layout')
@section('main')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <h2 class="card-title ">Data Pengajuan Kinerja</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabel_pengajuan" class="display" style="width:100%; align-item:center;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>Program Kerja</th>
                                <th>Catatan</th>
                                <th>Estimasi</th>
                                <th>Poin</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
   
</div>
@include('admin.modals.addPengajuan')
@include('admin.modals.editPengajuan')
@endsection