var CtrlPenjualan = function(){
    return {
        data:{
            element : {
                id_transaksi : $('#idTransaksi'),
                input_pelanggan : $('#inputPelanggan'),
                input_tanggal : $('#inputTanggal'),
                input_jam : $('#inputJam'),

                selectKolom : $('#selectKolom'),
                input_produk: $('#inputProduk'),
                input_hidden_sku: $('#sku'),
                nama_produk: $('#nama_produk'),
                harga_satuan: $('#harga_satuan'),
                input_jumlah: $('#input_jumlah'),
                input_diskon: $('#input_diskon'),
                total: $('#total'),
                tambah_item: $('#tambah_item'),

                table: $('#table'),

                sub_total : $('#sub_total'),
                total_diskon : $('#total_diskon'),
                grand_total : $('#grand_total'),
                input_bayar : $('#input_bayar'),
                kembali : $('#kembali'),

                btn_simpan: $('#btn-simpan'),

                delete_row : $('.delete_row'),
            },
        },
        init: function(){
            var elmt = CtrlPenjualan.data.element;

            elmt.selectKolom.on('change', function (e) {
                elmt.input_produk.val(null).trigger('change').empty();
            });

            elmt.input_produk.select2({
                ajax: {
                    url: globalPath + '/ajax/get-produk-by',
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            q: params.term,
                            pencarian: elmt.selectKolom.val()
                        }
                        return query;
                    },
                },
                placeholder: 'Cari...',
                minimumInputLength: 1
            });

            elmt.input_produk.on('change', function (e) {
                if($(this).val() == null) return;
                CtrlPenjualan.getProduk($(this).val());
                if (elmt.selectKolom.val() == 'sku') {
                    if ($(this).val() != null) {
                        elmt.nama_produk.removeClass('d-none');
                    }
                } else {
                    elmt.nama_produk.addClass('d-none');
                }
            });

            elmt.input_jumlah.on('change mouseup keyup', function(e){
                var _total = ($(this).val() * elmt.harga_satuan.val()) - elmt.input_diskon.val();
                elmt.total.val(_total);
            });
            elmt.input_diskon.on('change mouseup keyup',function(e){
                var _total = (elmt.input_jumlah.val() * elmt.harga_satuan.val()) - elmt.input_diskon.val();
                elmt.total.val(_total);
            });

            elmt.tambah_item.click(function(){
                var id = elmt.input_produk.val();
                var sku = elmt.input_hidden_sku.val();
                var nama_produk = elmt.nama_produk.val();
                var harga = elmt.harga_satuan.val();
                var jumlah = elmt.input_jumlah.val();
                var diskon = elmt.input_diskon.val();
                CtrlPenjualan.addRow(id, sku, nama_produk, harga, jumlah, diskon);
                CtrlPenjualan.resetForm();
                CtrlPenjualan.infoTotal();
            });

            elmt.input_bayar.on('change mouseup keyup', function(e){
                var kembali = $(this).val() - elmt.grand_total.val();
                elmt.kembali.val(kembali)
            });
            elmt.btn_simpan.click(function(){
                CtrlPenjualan.simpan();
            });
        },
        getProduk: function (id) {
            var elmt = CtrlPenjualan.data.element;
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
                    elmt.nama_produk.val(result.nama_produk);
                    elmt.harga_satuan.val(result.harga);
                    var total = (result.harga * elmt.input_jumlah.val()) - elmt.input_diskon.val();
                    elmt.total.val(total);
                    elmt.input_hidden_sku.val(result.sku);
                },
                error: function (erors) {
                    // $.LoadingOverlay("hide");
                    var response = erors.responseJSON;
                    console.log(response)
                    alert('Error Connection ..');
                }
            });
        },
        addRow: function(id, sku, nama_produk, harga, jumlah, diskon){

            if(!CtrlPenjualan.validate(id, sku, nama_produk, harga, jumlah, diskon)){
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
            var data8 = `<button class='delete_row' onclick='CtrlPenjualan.deleteRow(this)'>Hapus</button>`;

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
            CtrlPenjualan.infoTotal();
        },
        validate: function(id, sku, nama_produk, harga, jumlah, diskon)
        {
            if(id == null || sku == null || nama_produk == null || harga == null || jumlah == null || diskon == null)
            {
                return false;
            }
            return true;
        },
        resetForm: function(){
            var elmt = CtrlPenjualan.data.element;

            elmt.input_produk.val(null).trigger('change').empty();
            elmt.harga_satuan.val('');
            elmt.input_jumlah.val(0);
            elmt.input_diskon.val(0);
            elmt.total.val(0);
            elmt.nama_produk.addClass('d-none');
        },
        infoTotal: function(){
            var elmt = CtrlPenjualan.data.element;
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
            var kembali = elmt.input_bayar.val() - elmt.grand_total.val();
            elmt.kembali.val(kembali)
        },
        simpan: function(){
            var elmt = CtrlPenjualan.data.element;
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
                    "id_transaksi": elmt.id_transaksi.val(),
                    "pelanggan": elmt.input_pelanggan.val(),
                    "tanggal": elmt.input_tanggal.val(),
                    "jam": elmt.input_jam.val(),
                    "sub_total": elmt.sub_total.val(),
                    "diskon": elmt.total_diskon.val(),
                    "total": elmt.grand_total.val(),
                    "bayar": elmt.input_bayar.val(),
                },
                "detail_transaksi" : detail_transaksi
            };
            $.ajax({
                type: "POST",
                url: globalPath + '/ajax/create-transaction-sale',
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
                    alert('Error Connection ..');
                }
            });
        }
    }
}();
CtrlPenjualan.init();
