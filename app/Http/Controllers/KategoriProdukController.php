<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{
    public $pageTitle = 'Kategori Produk'; 
    public function index()
    {
        $pageTitle = $this->pageTitle;
        $query = KategoriProduk::query();
        $kategori = $query->paginate(10);
        return view('kategori-produk.index', compact('pageTitle', 'kategori'));
    }
}
