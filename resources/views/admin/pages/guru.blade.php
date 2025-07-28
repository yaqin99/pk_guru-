@extends('admin.layout')
@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <h2 class="card-title ">Data Guru</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabel_guru" class="display" style="width:100%; align-item:center;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>Nip</th>
                                <th>Nomer Handphone</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Kelas</th>
                                <th>Mapel</th>
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
@include('admin.modals.guru.aspek')
@include('admin.modals.guru.penilaian')
@include('admin.modals.guru.grafik')
@include('admin.modals.addGuru')
@include('admin.modals.editGuru')
@include('admin.modals.guru.addAbsensi')
@endsection