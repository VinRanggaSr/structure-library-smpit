<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImporSiswaRequest;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Support\ContohData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(): View
    {
        return view('admin.siswa.index', [
            'siswa' => ContohData::halaman(ContohData::siswaDenganJumlahPeminjaman()),
        ]);
    }

    public function store(StoreSiswaRequest $request): RedirectResponse
    {
        return redirect()->route('admin.siswa.index');
    }

    public function update(UpdateSiswaRequest $request, int $siswa): RedirectResponse
    {
        return redirect()->route('admin.siswa.index');
    }

    public function destroy(int $siswa): RedirectResponse
    {
        return redirect()->route('admin.siswa.index');
    }

    public function impor(ImporSiswaRequest $request): RedirectResponse
    {
        return redirect()->route('admin.siswa.index');
    }
}
