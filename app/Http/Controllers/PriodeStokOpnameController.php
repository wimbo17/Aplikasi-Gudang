<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePriodeStokOpnameRequest;
use App\Http\Requests\UpdatePriodeStokOpnameRequest;
use App\Models\ItemStokOpname;
use App\Models\PriodeStokOpname;
use App\Models\VarianProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PriodeStokOpnameController extends Controller
{
    public $pageTitle = 'Priode Stok Opname';
    public function index()
    {

        confirmDelete('Menghapus data Priode kan menghapus semua data stok opname, apakah anda yakin ?');
        $pageTitle = $this->pageTitle;
        $dataPriode = PriodeStokOpname::orderBy('created_at', 'DESC')->get()->map(function ($q) {
            $tanggalMulai = Carbon::parse($q->tanggal_mulai)->locale('id')->translatedFormat('d M Y');
            $tanggalSelesai = Carbon::parse($q->tanggal_selesai)->locale('id')->translatedFormat('d M Y');
            $priode = $tanggalMulai . ' s/d ' . $tanggalSelesai;
            return [
                'id'                    => $q->id,
                'priode'                => $priode,
                'is_active'             => $q->is_active,
                'is_completed'          => $q->is_completed,
                'jumlah_barang'         => $q->jumlah_barang,
                'jumlah_barang_sesuai'  => ItemStokOpname::jumlahDilaporkan($q->id, 'sesuai'),
                'jumlah_barang_selisih' => ItemStokOpname::jumlahDilaporkan($q->id, 'selisih'),
            ];
        });
        return view('stok-opname.priode.index', compact('pageTitle', 'dataPriode'));
    }

     public function store(StorePriodeStokOpnameRequest $request)
    {
        $isActive = $request->is_active ? true : false;
        $varian = VarianProduk::all();
        $newPriode = PriodeStokOpname::create([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'is_active' => $isActive,
            'jumlah_barang' => count($varian),
        ]);
        foreach ($varian as $item) {
            ItemStokOpname::create([
                'priode_stok_opname_id' => $newPriode->id,
                'nomor_sku' => $item->nomor_sku,
                'jumlah_stok' => $item->stok_varian,
            ]);
        }

        PriodeStokOpname::where('is_active', true)
            ->where('id', '!=', $newPriode->id)
            ->update(['is_active' => false]);

        toast()->success('Berhasil menambahkan priode stok opname');
        return redirect()->route('stok-opname.priode.index');
    }

    public function update(UpdatePriodeStokOpnameRequest $request, $id)
    {
        $isActive = $request->is_active ? true : false;
        $priode = PriodeStokOpname::findOrFail($id);
        $priode->update([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'is_active' => $isActive,
        ]);

        if ($request->is_active) {
            PriodeStokOpname::where('is_active', true)
                ->where('id', '!=', $id)
                ->update(['is_active' => false]);
        }
        toast()->success('Priode stok opname Berhasil diubah ');
        return redirect()->route('stok-opname.priode.index');
    }

    public function destroy($id)
    {
        $priode = PriodeStokOpname::findOrFail($id);

        if ($priode->is_active) {
            toast()->error('Tidak bisa menghapus priode stok opname yang sedang aktif');
            return redirect()->route('stok-opname.priode.index');
        }

        $priode->delete();
        toast()->success('priode stok opname berhasil dihapus ');
        return redirect()->route('stok-opname.priode.index');
    }

    public function show($priode)
    {
        $pageTitle = $this->pageTitle;
        $dataPriode = PriodeStokOpname::findOrFail($priode);
        $tanggalMulai = Carbon::parse($dataPriode->tanggal_mulai)->locale('id')->translatedFormat('d M Y');
        $tanggalSelesai = Carbon::parse($dataPriode->tanggal_selesai)->locale('id')->translatedFormat('d M Y');
        $priode = $tanggalMulai . ' - ' . $tanggalSelesai;
        $dataPriode['priode'] = $priode;

        $dataPriode['jumlah_barang_sesuai'] = ItemStokOpname::jumlahDilaporkan($dataPriode->id, 'sesuai');
        $dataPriode['jumlah_barang_selisih'] = ItemStokOpname::jumlahDilaporkan($dataPriode->id, 'selisih');
        $dataPriode['items'] = $dataPriode->items->map(function ($q) {
            $q->setAttribute('produk', $q->varian->produk->nama_produk . ' ' . $q->varian->nama_varian);
            return $q;
        });

        return view('stok-opname.priode.show', compact('pageTitle', 'dataPriode'));
    }
}
