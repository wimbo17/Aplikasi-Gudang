@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
    <div class="card py-5">
        <div class="card-body">
            {{-- form --}}
            <form class="row col-12 justify-content-between " id="form-add-produk">
                <div class="alert alert-danger" id="alert-danger" style="box-shadow: none" !important></div>
                <div class="row">
                    <div class="form-group w-25">
                        <label for="pengirim" class="form-label">Pengirim</label>
                        <input type="text" name="pengirim" id="pengirim" class="form-control" />
                    </div>
                    <div class="form-group w-25">
                        <label for="kontak" class="form-label">Kontak</label>
                        <input type="text" name="kontak" id="kontak" class="form-control" />
                    </div>
                    <div class="form-group mt-1">
                        <label for="keterangan" class="form-label">keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-4">
                        <select id="select-produk" class="form-control border py-3"></select>
                    </div>
                    <div class="col-2">
                        <input type="text" name="nomor_batch" id="nomor_batch" class="form-control"
                            placeholder="Nomor Batch">
                    </div>
                    <div class="col-2">
                        <input type="number" name="qty" id="qty" class="form-control" placeholder="Qty">
                    </div>
                    <div class="col-2">
                        <input type="number" name="harga" id="harga" class="form-control" placeholder="Harga">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-dark btn-round w-100" id="btn-add">Tambahkan</button>
                    </div>
                </div>
            </form>
            {{-- End form --}}
            {{-- Tabel --}}
            <table class="table mt-5" id="table-produk">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 15px">No</th>
                        <th>Produk</th>
                        <th>Batch</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Sub Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" class="text-end">Grand Total</th>
                        <th id="grand-total">0</th>
                    </tr>
                    <tr>
                        <th colspan="7" class="text-end">
                            <form id="form-transaksi">
                                <button type="submit" class="btn btn-primary ">Simpan Transaksi</button>
                            </form>
                        </th>
                    </tr>
                </tfoot>
            </table>
            {{-- End Tabel --}}
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#alert-danger').hide();
            const numberFormat = new Intl.NumberFormat('id-ID');
            let selectedOptions = {};
            let selectedProducts = [];


            $('#select-produk').select2({
                placeholder: 'Pilih Kategori',
                delay: 250,
                allowClear: true,
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('get-data.varian-produk') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        let query = {
                            search: params.term
                        }
                        return query
                    },
                    processResults: function(data) {
                        return {
                            results: data.map((item) => {
                                return {
                                    id: item.id,
                                    text: item.text,
                                    nomor_sku: item.nomor_sku,
                                }
                            })
                        }
                    }
                }
            })

            $('#select-produk').on('select2:select', function(e) {
                let data = e.params.data;
                selectedOptions = data;
            })

            $("#form-add-produk").on("submit", function(e) {
                e.preventDefault();
                let qty = parseInt($("#qty").val());
                let harga = parseInt($("#harga").val());
                let nomor_batch = $("#nomor_batch").val();

                if (!selectedOptions.id || !qty || !harga || !nomor_batch) {
                    swal({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'input belum lengkap',
                        timer: 2000,
                    })
                    return;
                }

                if (qty < 1 || harga < 1) {
                    swal({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Qty dan Harga tidak boleh kurang dari 1',
                        timer: 2000,
                    })
                    return;
                }

                let subTotal = qty * harga;

                let existingItem = selectedProducts.find(item => item.nomor_sku === selectedOptions
                    .nomor_sku);
                if (existingItem) {
                    existingItem.qty = parseInt(existingItem.qty) + parseInt(qty);
                    existingItem.harga = parseInt(harga);
                    existingItem.subTotal = existingItem.qty * existingItem.harga;
                } else {
                    selectedProducts.push({
                        text: selectedOptions.text,
                        nomor_sku: selectedOptions.nomor_sku,
                        qty: qty,
                        harga: harga,
                        nomor_batch: nomor_batch,
                        subTotal: subTotal,
                    })
                }

                $("#select-produk").val(null).trigger('change');
                $("#qty").val('');
                $("#harga")
                    .val('');
                $("#nomor_batch").val('');
                renderTable();
            });

            function renderTable() {
                let tableBody = $('#table-produk tbody');
                tableBody.empty();
                selectedProducts.forEach((item, index) => {
                    let row = ` 
                     <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${item.text}</td>    
                        <td>${item.nomor_batch}</td>    
                        <td>${item.qty}</td> 
                        <td>${numberFormat.format(item.harga)}</td>    
                        <td>${numberFormat.format(item.subTotal)}</td>   
                        <td>
                            <button class="btn btn-round btn-sm btn-danger btn-delete" data-nomor-sku="${item.nomor_sku}">
                                <i class="fas fa-trash"></i>
                            </button>    
                        </td>
                    </tr>
                    `;
                    tableBody.append(row);
                })
                $(document).on('click', '.btn-delete', function() {
                    let nomorSku = $(this).data('nomor-sku');
                    selectedProducts = selectedProducts.filter(item => item.nomor_sku !== nomorSku);
                    renderTable();
                });

                if (selectedProducts.length === 0) {

                    tableBody.append(` 
                     <tr>
                        <td class="text-center" colspan="7">Tidak ada data produk</td>
                    </tr>
                    `);
                }
                let grandTotal = selectedProducts.reduce((total, item) => total + item.subTotal, 0);
                $('#grand-total').text(numberFormat.format(grandTotal));
            }
            renderTable();

            $("#form-transaksi").on("submit", function(e) {
                e.preventDefault();
                if (selectedProducts.length === 0) {
                    swal({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Wajib Menuliskan 1 produk yang akan dicatat',
                        timer: 2000,
                    });
                    return;
                }
                $.ajax({
                    method: "POST",
                    url: "{{ route('transaksi-masuk.store') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        items: selectedProducts,
                        pengirim: $('#pengirim').val(),
                        kontak: $('#kontak').val(),
                        keterangan: $('#keterangan').val(),
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.redirect_url;
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON?.errors;
                        console.log(errors);
                        if (errors) {
                            renderError(errors);
                            return;
                        }
                    }
                });

            });

            function renderError(errors) {
                let alertBox = $('#alert-danger');
                alertBox.empty();
                Object.values(errors).forEach((err) => {
                    err.forEach(msg => {
                        alertBox.append(`<p>${msg}</p>`);
                    })
                })
                alertBox.show();
            }
        });
    </script>
@endpush
