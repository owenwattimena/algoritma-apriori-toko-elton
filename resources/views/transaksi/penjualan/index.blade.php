@extends('templates.index')

@section('head')

<link rel="stylesheet" href="{{ url('/') }}/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
<link rel="stylesheet" href="{{ url('/') }}/assets/vendors/select2/select2.min.css">
<style>
    .select2-selection.select2-selection--single {
        height: 35px !important;
    }

    .select2-selection__rendered {
        padding-top: 4px !important;
    }

    .select2-selection__arrow {
        margin-top: 3px !important;
    }

</style>
@endsection

@section('title', 'Transaksi > Penjualan')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Transaksi Penjualan</h6>
                <div class="row justify-content-end">
                    <div class="col-md-12">
                        <ul class="list-group mb-2">
                            <li class="list-group-item pb-0">
                                <div class="row">
                                    <div class="col-md-2 mb-3">
                                        <label for="idTransaksi" class="form-label">ID Transaksi</label>
                                        <input type="text" class="form-control form-control-sm" id="idTransaksi" placeholder="ID Transaksi" name="id_transaksi" value="{{ $idTransaksi }}" disabled readonly>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="inputPelanggan" class="form-label">Pelanggan</label>
                                        <input type="text" class="form-control form-control-sm" id="inputPelanggan" placeholder="Pelanggan" name="pelanggan">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="inputTanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control form-control-sm" id="inputTanggal" value="{{ date('Y-m-d') }}" name="tanggal">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="inputJam" class="form-label">Jam</label>
                                        <input type="time" class="form-control form-control-sm" id="inputJam" value="{{ date('H:m') }}" name="jam">
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-3 mb-3 mb-0">
                                        <label for="selectKolom" class="form-label">Kolom</label>
                                        <select id="selectKolom" class="form-control form-select-sm" data-width="100%" name="sku">
                                            <option value="sku">SKU</option>
                                            <option value="nama_produk">Nama Produk</option>
                                        </select>
                                    </div>
                                    <div class="col-md-9 mb-3 mb-0">
                                        <label for="inputProduk" class="form-label text-white">-</label>
                                        <select id="inputProduk" class="form-control form-select-sm" data-width="100%" name="nama_produk"></select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <input type="hidden" id="sku" name="sku">
                                        <input type="text" class="form-control form-control-sm d-none" id="nama_produk" placeholder="Nama Produk" disabled readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="harga_satuan" class="form-label">Harga Satuan</label>
                                <input type="number" class="form-control form-control-sm" id="harga_satuan" placeholder="Harga Satuan" name="harga" disabled readonly>
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="input_jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control form-control-sm" id="input_jumlah" min="0" name="jumlah" value="0">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="input_diskon" class="form-label">Diskon</label>
                                <input type="number" class="form-control form-control-sm input_diskon" id="input_diskon" min="0" name="diskon" value="0">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="total" class="form-label">Total</label>
                                <input type="number" class="form-control form-control-sm" id="total" name="total" disabled readonly>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-2 text-end">
                                <button class="btn btn-xs btn-secondary rounded-0 border-top border-dark" id="tambah_item">Tambah</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <ul class="list-group mb-2">
                            <li class="list-group-item pb-0">
                                <table class="table table-border table-sm" id="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>SKU</th>
                                            <th>Nama Barang</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah Jual</th>
                                            <th>Diskon</th>
                                            <th>Harga</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
                                        <td> Rp. <input id="sub_total" type="text" disabled readonly></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Diskon
                                        </td>
                                        <td>:</td>
                                        <td> Rp. <input id="total_diskon" type="text" disabled readonly></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Total
                                        </td>
                                        <td>:</td>
                                        <td> Rp. <input id="grand_total" type="text" disabled readonly ></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Bayar
                                        </td>
                                        <td>:</td>
                                        <td> Rp. <input id="input_bayar" type="number"  ></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Kembali
                                        </td>
                                        <td>:</td>
                                        <td> Rp. <input id="kembali" type="text" disabled readonly ></td>
                                    </tr>
                                </table>
                            </li>
                        </ul>
                        <div class="col-md-12 text-end">
                            {{-- <button class="btn btn-xs btn-dark rounded-0 border-top border-dark">Batal</button> --}}
                            <button class="btn btn-xs btn-success rounded-0 border-top border-dark" id="btn-simpan">Simpan</button>
                            {{-- <button class="btn btn-xs btn-danger rounded-0 border-top border-dark">Final</button> --}}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Riwayat
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse hide" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table id="dataTableExample" class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Id Transaksi</th>
                                                <th>Pelanggan</th>
                                                <th>Tanggal/Jam</th>
                                                <th>Sub Total</th>
                                                <th>Diskon</th>
                                                <th>Total</th>
                                                <th>Bayar</th>
                                                <th>Dibuat pada</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaksi as $key => $item)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->id_transaksi }}</td>
                                                <td>{{ $item->pelanggan ?? '-' }}</td>
                                                <td>{{ $item->tanggal }} {{ $item->jam }}</td>
                                                <td>{{ $item->sub_total }}</td>
                                                <td>{{ $item->diskon }}</td>
                                                <td>{{ $item->total }}</td>
                                                <td>{{ $item->bayar }}</td>
                                                <td>{{ $item->final_at }}</td>
                                                <td>
                                                    <a href="{{ route('transaksi.penjualan.show', $item->id) }}" class="btn btn-xs btn-secondary rounded-0 border-dark">Lihat</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
<script src="{{ asset('app/config.js') }}"></script>
{{-- <script src="{{ asset('app/controller/pembelian.js') }}"></script> --}}
<script src="{{ asset('app/controller/penjualan.js') }}"></script>
@endsection
