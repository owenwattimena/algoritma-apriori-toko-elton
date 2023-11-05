@extends('templates.index')

@section('head')

<link rel="stylesheet" href="{{ url('/') }}/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
<link rel="stylesheet" href="{{ url('/') }}/assets/vendors/select2/select2.min.css">
@endsection

@section('title', 'Transaksi > Penjualan > Detail')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Detail Transaksi Penjualan</h6>
                <div class="row justify-content-end">
                    <div class="col-md-12">
                        <ul class="list-group mb-2">
                            <li class="list-group-item pb-0">
                                <div class="row">
                                    <div class="col-md-2 mb-3">
                                        <label for="idTransaksi" class="form-label">ID Transaksi</label>
                                        <input type="text" class="form-control form-control-sm" id="idTransaksi" placeholder="ID Transaksi" name="id_transaksi" value="{{ $transaksi->id_transaksi }}" disabled readonly>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="inputPelanggan" class="form-label">Pelanggan</label>
                                        <input type="text" class="form-control form-control-sm" id="inputPelanggan" placeholder="Pelanggan" name="pelanggan" value="{{ $transaksi->pelanggan }}" disabled readonly>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="inputTanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control form-control-sm" id="inputTanggal" name="tanggal" value="{{ $transaksi->tanggal }}" disabled readonly>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="inputJam" class="form-label">Jam</label>
                                        <input type="time" class="form-control form-control-sm" id="inputJam" name="jam" value="{{ $transaksi->jam }}" disabled readonly>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12 mt-3">
                        <ul class="list-group mb-2">
                            <li class="list-group-item pb-0">
                                <table class="table table-border table-sm" id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>SKU</th>
                                            <th>Nama Barang</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah Beli</th>
                                            <th>Diskon</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $diskon = 0;
                                            $total = 0;
                                        @endphp
                                        @foreach ($transaksi->detail as $key => $item)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $item->produk->sku }}</td>
                                            <td>{{ $item->produk->nama_produk }}</td>
                                            <td>{{ $item->harga }}</td>
                                            <td>{{ $item->jumlah }}</td>
                                            <td>{{ $item->diskon }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                        @php
                                            $diskon += $item->diskon;
                                            $total += $item->total;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-5 mt-3">
                        <ul class="list-group mb-2">
                            <li class="list-group-item pb-0">
                                <table class="w-100 table table-sm" >
                                    <tr>
                                        <td>
                                            Sub Total
                                        </td>
                                        <td>:</td>
                                        <td> Rp. <input id="sub_total" value="{{ $transaksi->sub_total }}" type="text" disabled readonly></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Diskon
                                        </td>
                                        <td>:</td>
                                        <td> Rp. <input id="total_diskon" value="{{ $transaksi->diskon }}" type="text" disabled readonly></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Total
                                        </td>
                                        <td>:</td>
                                        <td> Rp. <input id="grand_total" type="text" value="{{ $transaksi->total }}" disabled readonly ></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Bayar
                                        </td>
                                        <td>:</td>
                                        <td> Rp. <input id="baar" type="text" value="{{ $transaksi->bayar }}" disabled readonly ></td>
                                    </tr>
                                </table>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Plugin js for this page -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="{{ url('/') }}/assets/vendors/select2/select2.min.js"></script>
<script src="{{ url('/') }}/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="{{ url('/') }}/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
@endsection
