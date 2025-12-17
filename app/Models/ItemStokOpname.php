<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemStokOpname extends Model
{
    protected $guarded = ['id'];

    public function priodeStokOpname()
    {
        return $this->belongsTo(PriodeStokOpname::class, 'priode_stok_opname_id');
    }

    public function varian()
    {
        return $this->belongsTo(VarianProduk::class, 'nomor_sku', 'nomor_sku');
    }

     public static function jumlahDilaporkan($priode, $status)
    {
        $jumlah  = ItemStokOpname::where('priode_stok_opname_id', $priode)->where('status', $status)->count();
        return $jumlah;
    }
}
