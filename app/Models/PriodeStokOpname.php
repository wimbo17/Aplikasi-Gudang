<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriodeStokOpname extends Model
{
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(ItemStokOpname::class, 'priode_stok_opname_id', 'id');
    }
}
