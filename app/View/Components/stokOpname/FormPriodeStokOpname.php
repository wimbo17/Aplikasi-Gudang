<?php

namespace App\View\Components\stokOpname;

use App\Models\PriodeStokOpname;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormPriodeStokOpname extends Component
{
    /**
     * Create a new component instance.
     */
    public $tanggal_mulai, $tanggal_selesai, $id, $action, $is_active;

    public function __construct($id = null)
    {
        if ($id) {
            $priode = PriodeStokOpname::findOrFail($id);
            $this->id = $priode->id;
            $this->tanggal_mulai = $priode->tanggal_mulai;
            $this->tanggal_selesai = $priode->tanggal_selesai;
            $this->is_active = $priode->is_active;
            $this->action = route('stok-opname.priode.update', $priode->id);
        } else {
            $this->action = route('stok-opname.priode.store');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stok-opname.form-priode-stok-opname');
    }
}
