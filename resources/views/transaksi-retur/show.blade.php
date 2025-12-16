@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Nomor Retur : {{ $transaksi->nomor_retur }}</h4>
            <a href="{{ route('transaksi-retur.index') }}" class="text-primary">Kembali</a>
        </div>
        <div class="card-body">
            <x-meta-item label="Pengirim" value="{{ $transaksi->transaksi->pengirim }}" />
            <x-meta-item label="Kontak" value="{{ $transaksi->transaksi->kontak }}" />
            <x-meta-item label="Jumlah Harga" value="Rp.{{ number_format($transaksi->jumlah_harga) }}" />
            <x-meta-item label="Jumlah Barang" value="{{ number_format($transaksi->transaksi->jumlah_barang) }} pcs" />
            <x-meta-item label="Petugas" value="{{ $transaksi->petugas }}" />
            <x-meta-item label="Tanggal Retur" value="{{ $transaksi->tanggal_retur }}" />


            <div class="mt-5">
                <h6>Detail Barang</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Barang</td>
                            <td>Nomor Batch</td>
                            <td>Jumlah</td>
                            <td>Harga Satuan</td>
                            <td>Sub Total</td>
                            <td>Note</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->produk }} {{ $item->varian }}</td>
                                <td>{{ $item->nomor_batch }}</td>
                                <td>{{ number_format($item->qty) }} pcs</td>
                                <td>Rp.{{ number_format($item->harga) }}</td>
                                <td>Rp.{{ number_format($item->sub_total) }}</td>
                                <td>{{ $item->note }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6">Grand Total</th>
                            <th>Rp.{{ number_format($transaksi->jumlah_harga) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
