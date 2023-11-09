@extends('templates.index')

@section('head')
<link rel="stylesheet" href="{{ url('/') }}/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
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
                                <form action="" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <label for="inputTanggal" class="form-label">Periode Awal</label>
                                            <input type="date" class="form-control form-control-sm" id="inputTanggal" name="periode_awal" value="{{ $periode_awal ?? '' }}" required>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="inputTanggal" class="form-label">Periode Akhir</label>
                                            <input type="date" class="form-control form-control-sm" id="inputTanggal" name="periode_akhir" value="{{ $periode_akhir ?? '' }}" required>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="inputTanggal" class="form-label">Min. Support</label>
                                            <input type="number" class="form-control form-control-sm" id="inputTanggal" name="min_sup" value="{{ $min_sup }}" required>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="inputTanggal" class="form-label">Min. Confidence (%)</label>
                                            <input type="number" class="form-control form-control-sm" id="inputTanggal" name="min_conf" value="{{ $min_conf }}" required>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="inputTanggal" class="form-label text-white">_</label>
                                            <button type="submit" class="form-control btn-sm btn btn-success">Analisa</button>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                @if ($result)
                <h6 class="mt-5">Dataset</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th style="width: 190px">Id Transaksi</th>
                                <th>Item Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $item)
                            <tr>
                                <td>{{ $item->id_transaksi }}</td>
                                <td>
                                    @foreach ($item->detail as $detail)
                                    {{ $detail->produk->nama_produk }},
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <h6 class="mt-5">Frekuensi Itemset</h6>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Itemset barang</th>
                            <th>Support Count</th>
                            <th>Support </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result['freg_itemsets'] as $item)
                        <tr>
                            <td>
                                @php
                                $index = 1;
                                @endphp
                                @foreach ($item as $key => $i)
                                @php
                                $index +=1;
                                @endphp
                                {{ $key != 'sup' ? $i . ($index <= count($item) ? ',' : '') : '' }}
                                @endforeach
                            </td>
                            <td>{{ $item['sup'] }}</td>
                            <td> {{ ( $item['sup'] / count($transaksi) ) * 100 }}% </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
                <h6 class="mt-5">Aturan Assosiatif</h6>
                <div class="table-responsive">
                    <table class="table table-sm" id="table">
                        <thead>
                            <tr>
                                <th>Aturan Asosiatif</th>
                                <th>Confidence</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result['assoc_rules'] as $key => $item)
                            <tr>
                                <td>
                                    { {{ $key }} } → {
                                        @php
                                        $index = 1;
                                        @endphp
                                        @foreach ($item as $k => $i)
                                        @php
                                        $index +=1;
                                        @endphp
                                        {{ ($index <= count($item) ? '' : $k) }}
                                        @endforeach
                                    }
                                </td>
                                <td>
                                    {{ end($item) }}%
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                @if(isset($no_data))
                <div class="alert alert-warning" role="alert">
                    {{$no_data}}
                </div>
                @endif
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- Plugin js for this page -->
<script src="{{ url('/') }}/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="{{ url('/') }}/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
<script>
$(function() {
        'use strict';

        $(function() {
            $('#table').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1]
                    , [10, 30, 50, "All"]
                ]
                , "iDisplayLength": 10
                , "language": {
                    search: ""
                }
            });
        });

    });
</script>
@endsection
