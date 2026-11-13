<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJenisDendaRequest;
use App\Http\Requests\UpdateJenisDendaRequest;
use App\Support\ContohData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenisDendaController extends Controller
{
    public function index(): View
    {
        return view('admin.jenis-denda.index', [
            'jenisDenda' => ContohData::halaman(ContohData::jenisDendaDenganJumlahDenda()),
        ]);
    }

    public function store(StoreJenisDendaRequest $request): RedirectResponse
    {
        return redirect()->route('admin.jenis-denda.index');
    }

    public function update(UpdateJenisDendaRequest $request, int $jenisDenda): RedirectResponse
    {
        return redirect()->route('admin.jenis-denda.index');
    }

    public function destroy(int $jenisDenda): RedirectResponse
    {
        return redirect()->route('admin.jenis-denda.index');
    }
}
