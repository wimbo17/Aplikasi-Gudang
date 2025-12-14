@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
    <div class="card">
        <div class="card-body py-5">
            <div class="row align-items-center">
                {{-- fillter --}}
                <div class="row col-10 align-items-center justify-content-between">
                    <div class="col-1">
                        <x-per-page-option />
                    </div>
                    <div class="col-9">
                        <x-filter-by-field term="search" placeholder="Cari Kategori Produk" />
                    </div>
                    <div class="col-1">
                        <x-button-reset-filter route="master-data.produk.index" />
                    </div>
                </div>
                {{-- end fillter --}}
                {{-- form --}}
                <div class="col-2 d-flex justify-content-end">
                    <x-produk.form-produk />
                </div>
                {{-- end form --}}
            </div>
            <table class="table mt-5">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 15px;">No</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th lass="text-center" style="width: 10px;">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produk as $index=> $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <a href="{{ route('master-data.produk.show', $item->id) }}" class="text-decoration-none">
                                    {{ $item->nama_produk }}
                                </a>
                            </td>
                            <td>{{ $item->kategori->nama_kategori }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <x-produk.form-produk id="{{ $item->id }}" />
                                    <x-confirm-delete id="{{ $item->id }}" route="master-data.produk.destroy" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Data Produk Tidak Tersedia </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $produk->links() }}
        </div>
    </div>


@endsection
