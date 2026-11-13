<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Support\ContohData;
use App\Support\Peran;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function pilihPeran(): View
    {
        return view('auth.pilih-peran', [
            'peran' => Peran::semua(),
        ]);
    }

    public function create(string $peran): View
    {
        $info = Peran::dariSlug($peran);
        $akun = ContohData::penggunaBerperan($info['role']);

        return view('auth.login', [
            'peran' => $info,
            // Mode pengujian: kredensial contoh sudah terisi supaya login tidak perlu akun sungguhan.
            'akun' => $akun,
        ]);
    }

    public function store(LoginRequest $request, string $peran): RedirectResponse
    {
        $info = Peran::dariSlug($peran);

        return redirect()->route($info['beranda']);
    }

    public function destroy(): RedirectResponse
    {
        return redirect()->route('pilih-peran');
    }
}
