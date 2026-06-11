<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function home()
    {
        $produk = \App\Models\Produk::where('status', 'aktif')->get();
        return view('frontend.customer.home', compact('produk'));
    }
}
