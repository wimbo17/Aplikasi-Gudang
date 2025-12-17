@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
    <div class="card p-5">
        <div class="card-header d-flex justify-content-between align-items-center ">
            <h4 class="card-title">Periode : {{ $dataPriode->priode }}</h4>
            <a href="{{ route('stok-opname.priode.index') }}" class="text-primary">Kembali</a>
        </div>
        <div class="card-body">
            <x-meta-item label="Jumlah Barang" value="{{ $dataPriode->jumlah_barang }}" />
            <x-meta-item label="Jumlah Barang Sesuai" value="{{ $dataPriode->jumlah_barang_sesuai }}" />
            <x-meta-item label="Jumlah Barang Selisih" value="{{ $dataPriode->jumlah_barang_selisih }}" />
            <x-meta-item label="Status Kerja" value="{{ $dataPriode->is_active ? 'Aktif' : 'Tidak aktif' }}" />
            <x-meta-item label="Laporan Stok Opname"
                value="{{ $dataPriode->is_completed ? 'Lengkap' : 'Belum Lengkap' }}" />
        </div>

        <div class="mt-5">
            <div>
                <button class="btn btn-primary btn-sm" id="btn-update-produk">Update Daftra Produk</button>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor SKU</th>
                        <th>Produk</th>
                        <th>Stok</th>
                        <th>Jumlah Terlapor</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataPriode->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nomor_sku }}</td>
                            <td>{{ $item->produk }}</td>
                            <td>{{ $item->jumlah_stok }}</td>
                            <td>{{ $item->jumlah_dilaporkan }}</td>
                            <td>
                                <span
                                    class="badge text-capitalize
                                {{ $item->status == 'selisih' ? 'bg-danger' : ($item->status == 'sesuai' ? 'bg-success' : 'bg-secondary') }}
                                ">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>{{ $item->keterangan }}</td>
                            <td>{{ $item->petugas }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#btn-update-produk').on('click', function() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('stok-opname.update-produk') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        priode_id: "{{ $dataPriode->id }}"
                    },
                    success: function(response) {

                        isSuccess = response.success;
                        swal({
                            icon: isSuccess ? 'success' : 'warning',
                            title: isSuccess ? 'Berhasil' : 'Gagal',
                            text: response.message,
                            timer: 2000
                        }).then(() => {
                            window.location.href = response.redirect_url;
                        })
                    }
                });
            });
        });
    </script>
@endpush
