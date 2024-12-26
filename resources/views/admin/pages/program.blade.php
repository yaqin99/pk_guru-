@extends('admin.layout')
@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <h2 class="card-title ">Data Program Kegiatan Kinerja Guru</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabel_program" class="display" style="width:100%; align-item:center;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Program Kegiatan</th>
                                <th>Poin Kegiatan</th>
                                <th>Waktu Pelaksanaan</th>
                                
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
@include('admin.modals.addProgram')
@endsection