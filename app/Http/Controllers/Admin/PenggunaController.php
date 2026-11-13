<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePenggunaRequest;
use App\Http\Requests\UpdatePenggunaRequest;
use App\Support\ContohData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    public function index(): View
    {
        return view('admin.pengguna.index', [
            'pengguna' => ContohData::halaman(ContohData::penggunaDenganJumlahPeminjaman()),
        ]);
    }

    public function store(StorePenggunaRequest $request): RedirectResponse
    {
        return redirect()->route('admin.pengguna.index');
    }

    public function update(UpdatePenggunaRequest $request, int $pengguna): RedirectResponse
    {
        return redirect()->route('admin.pengguna.index');
    }

    public function destroy(int $pengguna): RedirectResponse
    {
        return redirect()->route('admin.pengguna.index');
    }
}
