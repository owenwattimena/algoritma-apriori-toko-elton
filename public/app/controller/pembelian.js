var CtrlPembelian = function () {
    return {
        data : {
            element : {
                selectKolom : $('#selectKolom'),
                sub_total : $('#sub_total'),
                total_diskon : $('#total_diskon'),
                grand_total : $('#grand_total'),
                delete_row : $('.delete_row'),
                id_transaksi : $('#idTransaksi'),
                input_no_faktur : $('#inputNoFaktur'),
                input_penyedia : $('#inputPenyedia'),
                input_tanggal : $('#inputTanggal'),
                input_jam : $('#inputJam'),
            },
        },
        init: function () {
            var elmt = CtrlPembelian.data.element;
            // var selectKolom = $('#selectKolom');
            var selectKolom = elmt.selectKolom;
            var nama_produk = $('#nama_produk');
            var input_jumlah = $('#input_jumlah');
            var input_diskon = $('#input_diskon');
            var inputProduk = $('#inputProduk');
            var harga_satuan = $('#harga_satuan');
            var total = $('#total')

            selectKolom.on('change', function (e) {
                inputProduk.val(null).trigger('change').empty();
            });
            input_jumlah.on('change mouseup keyup', function(e){
                var _total = ($(this).val() * harga_satuan.val()) - input_diskon.val();
                $('#total').val(_total);
            });
            input_diskon.on('change mouseup keyup',function(e){
                var _total = (input_jumlah.val() * harga_satuan.val()) - input_diskon.val();
                total.val(_total);
            });
            $("#inputProduk").select2({
                ajax: {
                    url: globalPath + '/ajax/get-produk-by',
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            q: params.term,
                            pencarian: selectKolom.val()
                        }
                        return query;
                    },
                },
                placeholder: 'Cari...',
                minimumInputLength: 1
            });
            inputProduk.on('change', function (e) {
                if($(this).val() == null) return;
                CtrlPembelian.getProduk($(this).val());
                if (selectKolom.val() == 'sku') {
                    if ($(this).val() != null) {
                        nama_produk.removeClass('d-none');
                    }
                } else {
                    nama_produk.addClass('d-none');
                }

            });

            $('#tambah_item').click(function(){
                var id = inputProduk.val();
                var sku = $('#sku').val();
                var _nama_produk = nama_produk.val();
                var harga = harga_satuan.val();
                var jumlah = input_jumlah.val();
                var diskon = input_diskon.val();
                CtrlPembelian.addRow(id, sku, _nama_produk, harga, jumlah, diskon);
                CtrlPembelian.resetForm();
                CtrlPembelian.infoTotal();
            });

            $('#btn-simpan').click(function(){
                CtrlPembelian.simpan();
            });

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
            $('#dataTableExample').each(function () {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });
        },
        getProduk: function (id) {
            $.ajax({
                type: "GET",
                url: globalPath + '/ajax/get-produk/' + id,
                cache: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "id": id
                },
                dataType: 'json',
                success: function (result) {
                    $('#nama_produk').val(result.nama_produk);
                    $('#harga_satuan').val(result.harga);
                    var total = (result.harga * $('#input_jumlah').val()) - $('#input_diskon').val();
                    $('#total').val(total);
                    $('#sku').val(result.sku);
                },
                error: function (erors) {
                    // $.LoadingOverlay("hide");
                    var response = erors.responseJSON;
                    console.log(response)
                    alert('Error Connection ..');
                }
            });
        },
        resetForm: function(){
            $('#inputProduk').val(null).trigger('change').empty();
            $('#harga_satuan').val('');
            $('#input_jumlah').val(0);
            $('#input_diskon').val(0);
            $('#total').val(0);
            $('#nama_produk').addClass('d-none');
        },
        validate: function(id, sku, nama_produk, harga, jumlah, diskon)
        {
            if(id == null || sku == null || nama_produk == null || harga == null || jumlah == null || diskon == null)
            {
                return false;
            }
            return true;
        },
        addRow: function(id, sku, nama_produk, harga, jumlah, diskon){

            if(!CtrlPembelian.validate(id, sku, nama_produk, harga, jumlah, diskon)){
                return alert('lengkapi data terlebih dahulu.');
            }

            var table = document.getElementById("table").getElementsByTagName('tbody')[0];
            var newRow = table.insertRow(table.rows.length);

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);
            var cell7 = newRow.insertCell(6);
            var cell8 = newRow.insertCell(7);

            var data1 = id;
            var data2 = sku;
            var data3 = nama_produk;
            var data4 = harga;
            var data5 = jumlah;
            var data6 = diskon;
            var data7 = (harga * jumlah) - diskon;
            var data8 = `<button class='delete_row' onclick='CtrlPembelian.deleteRow(this)'>Hapus</button>`;

            cell1.innerHTML = data1;
            cell2.innerHTML = data2;
            cell3.innerHTML = data3;
            cell4.innerHTML = data4;
            cell5.innerHTML = data5;
            cell6.innerHTML = data6;
            cell7.innerHTML = data7;
            cell8.innerHTML = data8;
        },
        deleteRow: function(e){
            var row = e.parentNode.parentNode; // Get the row that contains the clicked button
            row.parentNode.removeChild(row);
            CtrlPembelian.infoTotal();
        },
        infoTotal: function(){
            var elmt = CtrlPembelian.data.element;
            var table = document.getElementById('table');
            var rows = table.getElementsByTagName('tr');
            var diskon = 0;
            var total = 0;

            var columnIndexDiskon = 5;
            var columnIndexHarga = 6;

            for (var i = 1; i < rows.length; i++) {
                // Loop through each row
                var row = rows[i];
                var cols = row.getElementsByTagName('td');
                var diskonValue = cols[columnIndexDiskon].innerHTML;
                var totalValue = cols[columnIndexHarga].innerHTML;

                // Check if the cell contains a number
                if (!isNaN(diskonValue)) {
                    diskon += parseInt(diskonValue);
                }
                if (!isNaN(totalValue)) {
                    total += parseInt(totalValue);
                }
            }

            elmt.sub_total.val(total + diskon);
            elmt.total_diskon.val(diskon);
            elmt.grand_total.val(total);
        },
        simpan: function(){
            var detail_transaksi = [];

            var table = document.getElementById('table');
            var rows = table.getElementsByTagName('tr');
            for (var i = 1; i < rows.length; i++) {
                // Loop through each row
                var row = rows[i];
                var cols = row.getElementsByTagName('td');

                var row_item = {
                    "id_produk": cols[0].innerHTML,
                    "harga": cols[3].innerHTML,
                    "jumlah": cols[4].innerHTML,
                    "diskon": cols[5].innerHTML,
                    "total": cols[6].innerHTML,
                };
                detail_transaksi.push(row_item);

            }

            var data = {
                "transaksi" : {
                    "id_transaksi": CtrlPembelian.data.element.id_transaksi.val(),
                    "nomor_faktur": CtrlPembelian.data.element.input_no_faktur.val(),
                    "penyedia": CtrlPembelian.data.element.input_penyedia.val(),
                    "tanggal": CtrlPembelian.data.element.input_tanggal.val(),
                    "jam": CtrlPembelian.data.element.input_jam.val(),
                    "sub_total": CtrlPembelian.data.element.sub_total.val(),
                    "diskon": CtrlPembelian.data.element.total_diskon.val(),
                    "total": CtrlPembelian.data.element.grand_total.val(),
                },
                "detail_transaksi" : detail_transaksi
            };
            $.ajax({
                type: "POST",
                url: globalPath + '/ajax/create-transaction-purchase',
                cache: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                dataType: 'json',
                success: function (result) {
                    window.location.reload(true);
                },
                error: function (erors) {
                    // $.LoadingOverlay("hide");
                    var response = erors.responseJSON;
                    console.log(response)
                    alert(response);
                }
            });
        },
        // simpanDetail: function(id_produk, jumlah, harga, diskon){
        //     $.ajax({
        //         type: "POST",
        //         url: globalPath + '/ajax/create-transaction-detail',
        //         cache: true,
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         data: {
        //             "id_produk": CtrlPembelian.data.element.id_transaksi.val(),
        //             "harga": CtrlPembelian.data.element.input_penyedia.val(),
        //             "jumlah": CtrlPembelian.data.element.input_no_faktur.val(),
        //             "diskon": CtrlPembelian.data.element.total_diskon.val(),
        //             "total": CtrlPembelian.data.element.grand_total.val(),
        //         },
        //         dataType: 'json',
        //         success: function (result) {
        //             console.log(result);
        //         },
        //         error: function (erors) {
        //             // $.LoadingOverlay("hide");
        //             var response = erors.responseJSON;
        //             console.log(response)
        //             alert('Error Connection ..');
        //         }
        //     });
        // }
    }
}();

CtrlPembelian.init();
