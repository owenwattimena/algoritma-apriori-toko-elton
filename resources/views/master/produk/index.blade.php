@extends('templates.index')

@section('head')

<link rel="stylesheet" href="{{ url('/') }}/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
@endsection

@section('title', 'Master > Produk')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Data Produk</h6>
                <div class="text-end mb-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                            </div>
                            <form action="{{ route('master.produk.create') }}" class="forms-sample" method="POST">
                                <div class="modal-body">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="inputSKU" class="form-label">SKU</label>
                                            <input type="text" class="form-control" id="inputSKU" placeholder="Masukan SKU" name="sku" required>
                                        </div>
                                        <div class="mb-3 col-md-8">
                                            <label for="inputNamaProduk" class="form-label">Nama Produk</label>
                                            <input type="text" class="form-control" id="inputNamaProduk" placeholder="Masukan Nama Produk" name="nama_produk" required>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="selectSatuan" class="form-label">Satuan</label>
                                            <select class="form-control" id="selectSatuan" name="id_satuan" required>
                                                @foreach ($satuan as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_satuan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="selectKategori" class="form-label">Kategori</label>
                                            <select class="form-control" id="selectKategori" name="id_kategori" required>
                                                @foreach ($kategori as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="inputHarga" class="form-label">Harga</label>
                                            <input type="number" class="form-control" id="inputHarga" placeholder="Masukan Harga" name="harga" step=".01" required>
                                        </div>


                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>SKU</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Satuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $key => $item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $item->sku }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->harga }}</td>
                                <td>{{ $item->kategori->nama_kategori }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>{{ $item->satuan->nama_satuan }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $item->sku }}" style="font-size: 8pt">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('master.produk.delete', $item->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="badge bg-danger" onclick="return confirm('Yakin ingin menghapus data?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="9" y1="9" x2="15" y2="15"></line>
                                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal-{{ $item->sku }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ubah Produk</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                        </div>
                                        <form action="{{ route('master.produk.update', $item->id) }}" class="forms-sample" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('put')
                                                <div class="row">
                                                    <div class="mb-3 col-md-4">
                                                        <label for="inputSKU" class="form-label">SKU</label>
                                                        <input type="text" class="form-control" id="inputSKU" placeholder="Masukan SKU" name="sku" value="{{ $item->sku }}">
                                                    </div>
                                                    <div class="mb-3 col-md-8">
                                                        <label for="inputNamaProduk" class="form-label">Nama Produk</label>
                                                        <input type="text" class="form-control" id="inputNamaProduk" placeholder="Masukan Nama Produk" name="nama_produk" value="{{ $item->nama_produk }}">
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="selectSatuan" class="form-label">Satuan</label>
                                                        <select class="form-control" id="selectSatuan" name="id_satuan">
                                                            @foreach ($satuan as $itemSatuan)
                                                            <option value="{{ $itemSatuan->id }}" {{ $itemSatuan->id == $item->id_satuan ? 'selected' : '' }} >{{ $itemSatuan->nama_satuan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="selectKategori" class="form-label">Kategori</label>
                                                        <select class="form-control" id="selectKategori" name="id_kategori">
                                                            @foreach ($kategori as $itemKategori)
                                                            <option value="{{ $itemKategori->id }}" {{ $itemKategori->id == $item->id_kategori ? 'selected' : '' }} >{{ $itemKategori->nama_kategori }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="inputHarga" class="form-label">Harga</label>
                                                        <input type="number" class="form-control" id="inputHarga" placeholder="Masukan Harga" name="harga" step=".01" value="{{ $item->harga }}">
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </tbody>
                    </table>
                </div>
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
    // npm package: datatables.net-bs5
    // github link: https://github.com/DataTables/Dist-DataTables-Bootstrap5

    $(function() {
        'use strict';

        $(function() {
            $('#dataTableExample').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1]
                    , [10, 30, 50, "All"]
                ]
                , "iDisplayLength": 10
                , "language": {
                    search: ""
                }
            });
            $('#dataTableExample').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });
        });

    });

</script>
@endsection
