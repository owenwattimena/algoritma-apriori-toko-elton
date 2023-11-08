@extends('templates.index')

@section('head')
    
@endsection

@section('title', 'Laporan')
    
@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Laporan Analisa Algoritma Apriori</h6>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group mb-2">
                            <li class="list-group-item pb-0">
                                <div class="row">
                                    <div class="col-md-2 mb-3">
                                        <label for="inputTanggal" class="form-label">Periode Awal</label>
                                        <input type="date" class="form-control form-control-sm" id="inputTanggal" name="periode_awal">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="inputTanggal" class="form-label">Periode Akhir</label>
                                        <input type="date" class="form-control form-control-sm" id="inputTanggal" name="periode_akhir">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="inputTanggal" class="form-label">Min. Support</label>
                                        <input type="number" class="form-control form-control-sm" id="inputTanggal" value="2" name="periode_akhir">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="inputTanggal" class="form-label">Min. Confidence (%)</label>
                                        <input type="number" class="form-control form-control-sm" id="inputTanggal" value="70" name="periode_akhir">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="inputTanggal" class="form-label text-white">_</label>
                                        <button type="number" class="form-control btn-sm btn btn-success">Analisa</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection