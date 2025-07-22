@extends('admin.layout')
@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <h2 class="card-title ">Data Surat Kinerja</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabel_surat" class="display" style="width:100%; align-item:center;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>Surat</th>
                                <th>Tipe Surat</th>
                                <th>Tanggal</th>
                               
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
@include('admin.modals.addSurat')
@include('admin.modals.editSurat')
@include('admin.modals.aspek.editAspek')
@endsection