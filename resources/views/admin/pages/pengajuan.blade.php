@extends('admin.layout')
@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
                                <th>Catatan Evaluasi</th>    
                                {{-- <th>Catatan Admin</th> --}}
                               
                                <th>Estimasi</th>
                                <th>Poin</th>
                                {{-- <th>Tanggal</th> --}}
                                <th>Status</th>
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
@include('admin.modals.editCatatan')
@include('admin.modals.editPengajuan')
@include('admin.modals.addBuktiKegiatan')
@endsection