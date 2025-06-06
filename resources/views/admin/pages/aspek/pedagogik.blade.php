@extends('admin.layout')
@section('main')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <h2 class="card-title ">Data Pedagogik</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabel_pedagogik" class="display" style="width:100%; align-item:center;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>Detail Pedagogik</th>
                                <th>Dokumen</th>
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
@include('admin.modals.aspek.addPedagogik')
@include('admin.modals.aspek.editPedagogik')
@endsection