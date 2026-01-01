{{-- @extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
    <div class="card p-5">
        <div class="card-body">
            @if ($items->isEmpty())
                <div class="alert alert-info text-center" role="alert">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h5 class="alert-heading">Belum Ada Priode Stok Opname Aktif</h5>
                    <p class="mb-0">Silakan buat priode stok opname terlebih dahulu di menu <strong>Priode Stok
                            Opname</strong> sebelum melakukan input laporan.</p>
                </div>
            @else
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
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->varian->nomor_sku }}</td>
                                <td>{{ $item->produk }}</td>
                                <td>{{ $item->varian->stok_varian }}</td>
                                <td>{{ $item->jumlah_dilaporkan }}</td>
                                <td>
                                    <span
                                        class="badge 
                                {{ $item->status == 'selisih' ? 'bg-danger' : ($item->status == 'sesuai' ? 'bg-success' : 'bg-secondary') }}
                                text-capitalize">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>{{ $item->keterangan }}</td>
                                <td>{{ $item->petugas }}</td>
                                <td>
                                    <div>
                                        <x-stok-opname.form-input-item :item="$item" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection --}}

@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
    <div class="card p-5">
        <div class="card-body">
            @if ($items->isEmpty())
                <div class="alert alert-info text-center" role="alert">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h5 class="alert-heading">Belum Ada Priode Stok Opname Aktif</h5>
                    <p class="mb-0">Silakan buat priode stok opname terlebih dahulu di menu <strong>Priode Stok
                            Opname</strong> sebelum melakukan input laporan.</p>
                </div>
            @else
                {{-- WRAPPER RESPONSIVE DIMULAI DI SINI --}}
                <div class="table-responsive">
                    <table class="table w-100 table-hover text-nowrap">
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
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td class="align-middle">{{ $index + 1 }}</td>
                                    <td class="align-middle">{{ $item->varian->nomor_sku }}</td>
                                    <td class="align-middle">{{ $item->produk }}</td>
                                    <td class="align-middle">{{ $item->varian->stok_varian }}</td>
                                    <td class="align-middle">{{ $item->jumlah_dilaporkan }}</td>
                                    <td class="align-middle">
                                        <span
                                            class="badge 
                                    {{ $item->status == 'selisih' ? 'bg-danger' : ($item->status == 'sesuai' ? 'bg-success' : 'bg-secondary') }}
                                    text-capitalize">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="align-middle">{{ $item->keterangan }}</td>
                                    <td class="align-middle">{{ $item->petugas }}</td>
                                    <td class="align-middle">
                                        <div>
                                            <x-stok-opname.form-input-item :item="$item" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- WRAPPER RESPONSIVE BERAKHIR DI SINI --}}
            @endif
        </div>
    </div>
@endsection
