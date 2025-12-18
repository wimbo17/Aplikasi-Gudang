<?php

namespace App\Http\Controllers;

use App\Http\Requests\updateInputStokOpnameRequest;
use App\Models\ItemStokOpname;
use App\Models\PriodeStokOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InputStokOpnameController extends Controller
{
    public $pageTitele = "Input Laporan Stok Opname";

    public function create()
    {
        $pageTitle = $this->pageTitele;
        
        // Check if there's an active period
        $activePriode = PriodeStokOpname::where('is_active', true)->first();
        
        if (!$activePriode) {
            // No active period, return empty items
            $items = collect([]);
            return view('stok-opname.input.create', compact('pageTitle', 'items'));
        }
        
        // Get items for the active period
        $items = ItemStokOpname::with('varian')
            ->where('priode_stok_opname_id', $activePriode->id)
            ->get()
            ->map(function ($q) {
                $produk = $q->varian->produk->nama_produk . ' ' . $q->varian->nama_varian;
                $q->setAttribute('produk', $produk);
                return $q;
            });

        return view('stok-opname.input.create', compact('pageTitle', 'items'));
    }

    public function update(updateInputStokOpnameRequest $request, $id)
    {
        $item = ItemStokOpname::find($id);
        $isSelisih = $request->jumlah_dilaporkan != $item->jumlah_stok;

        $item->update([
            'jumlah_dilaporkan' => $request->jumlah_dilaporkan,
            'status' => $isSelisih ? 'selisih' : 'sesuai',
            'keterangan' => $request->keterangan,
            'petugas'   => Auth::user()->name
        ]);

        // Get the active period dynamically
        $activePriode = PriodeStokOpname::where('is_active', true)->first();
        
        if ($activePriode) {
            $itemStopOpname = ItemStokOpname::where('priode_stok_opname_id', $activePriode->id)
                ->where('status', 'belum_dilaporkan')
                ->count();
            
            if ($itemStopOpname == 0) {
                $activePriode->update(['is_completed' => true]);
            }
        }

        toast()->success('Item Stok Opname Berhasil diubah');
        return redirect()->route('stok-opname.input-data.create');
    }
}
