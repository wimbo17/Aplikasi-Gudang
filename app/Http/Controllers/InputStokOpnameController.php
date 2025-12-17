<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInputStokOpnameRequest;
use App\Models\ItemStokOpname;
use App\Models\PriodeStokOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InputStokOpnameController extends Controller
{
    public $pageTitele = "Input Laporan Stok Opname", $activePriode = null, $items = null;

    public function __construct()
    {
        $priode = PriodeStokOpname::where('is_active', true)->first()->id;
        $this->activePriode = $priode;
        $this->items = ItemStokOpname::with('varian')->where('priode_stok_opname_id', $this->activePriode)->get()->map(function ($q) {
            $produk = $q->varian->produk->nama_produk . ' ' . $q->varian->nama_varian;
            $q->setAttribute('produk', $produk);
            return $q;
        });
    }

     public function create()
    {
        $pageTitle = $this->pageTitele;
        $items = $this->items;

        return view('stok-opname.input.create', compact('pageTitle', 'items'));
    }

    public function update(UpdateInputStokOpnameRequest $request, $id)
    {
        $item = ItemStokOpname::find($id);
        $isSelisih = $request->jumlah_dilaporkan != $item->jumlah_stok;

        $item->update([
            'jumlah_dilaporkan' => $request->jumlah_dilaporkan,
            'status' => $isSelisih ? 'selisih' : 'sesuai',
            'keterangan' => $request->keterangan,
            'petugas'   => Auth::user()->name
        ]);

        $itemStopOpname = ItemStokOpname::where('priode_stok_opname_id', $this->activePriode)->where('status', 'belum_dilaporkan')->count();
        if ($itemStopOpname == 0) {
            PriodeStokOpname::where('id', $this->activePriode)->update(['is_completed' => true]);
        }

        toast()->success('Item Stok Opname Berhasil diubah');
        return redirect()->route('stok-opname.input-data.create');
    }
}
