<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use App\Support\ContohData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(): View
    {
        return view('admin.kategori.index', [
            'kategori' => ContohData::halaman(ContohData::kategoriDenganJumlahBuku()),
        ]);
    }

    public function store(StoreKategoriRequest $request): RedirectResponse
    {
        return redirect()->route('admin.kategori.index');
    }

    public function update(UpdateKategoriRequest $request, int $kategori): RedirectResponse
    {
        return redirect()->route('admin.kategori.index');
    }

    public function destroy(int $kategori): RedirectResponse
    {
        return redirect()->route('admin.kategori.index');
    }
}
