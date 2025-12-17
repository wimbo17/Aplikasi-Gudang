<?php

namespace App\Http\Controllers;

use App\Models\ItemStokOpname;
use App\Models\PriodeStokOpname;
use App\Models\VarianProduk;
use Illuminate\Http\Request;

class ItemStokOpnameController extends Controller
{
     public function updateProduk(Request $request)
    {
        $priodeId = $request->priode_id;
        $priode = PriodeStokOpname::findOrFail($priodeId);
        $produk = VarianProduk::all();

        if (!$priode->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Priode Stok Opname tidak aktif',
                'redirect_url' => route('stok-opname.priode.show', $priodeId)
            ]);
        }
        if ($priode->items()->count() == count($produk)) {
            return response()->json([
                'success' => false,
                'message' => 'Data sudah Terupdate, tidak ada data baru yang di tambahkan ',
                'redirect_url' => route('stok-opname.priode.show', $priodeId)
            ]);
        }

        foreach ($produk as $item) {
            ItemStokOpname::updateOrCreate(
                ['priode_stok_opname_id' => $priodeId, 'nomor_sku' => $item->nomor_sku],
                ['jumlah_stok' => $item->stok_varian]
            );
        }
        $priode->is_completed = 0;
        $priode->jumlah_barang = count($produk);
        $priode->save();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan',
            'redirect_url' => route('stok-opname.priode.show', $priodeId)
        ]);
    }
}
