<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDendaRequest;
use App\Http\Requests\UpdateDendaRequest;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Support\ContohData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DendaController extends Controller
{
    public function index(): View
    {
        // Denda terbaru di atas, mengikuti urutan peminjamannya.
        $semua = ContohData::denda()
            ->sortByDesc(fn (Denda $d) => [$d->peminjaman->tanggal_peminjaman->toDateString(), $d->id_denda])
            ->values();

        return view('petugas.denda.index', [
            'denda' => ContohData::halaman($semua),
            'jumlahPerStatus' => [
                'Semua' => $semua->count(),
                Denda::STATUS_BELUM_LUNAS => $semua->where('status_denda', Denda::STATUS_BELUM_LUNAS)->count(),
                Denda::STATUS_LUNAS => $semua->where('status_denda', Denda::STATUS_LUNAS)->count(),
            ],
            'totalBelumLunas' => $semua->where('status_denda', Denda::STATUS_BELUM_LUNAS)->sum('total_denda'),
            'jenisDenda' => ContohData::jenisDenda(),
            // ERD: satu peminjaman hanya boleh punya satu denda, jadi yang sudah punya tidak ditawarkan lagi.
            'pilihanPeminjaman' => ContohData::peminjaman()->filter(fn (Peminjaman $p) => $p->denda === null)->values(),
        ]);
    }

    public function store(StoreDendaRequest $request): RedirectResponse
    {
        return redirect()->route('petugas.denda.index');
    }

    public function update(UpdateDendaRequest $request, int $denda): RedirectResponse
    {
        return redirect()->route('petugas.denda.index');
    }

    public function destroy(int $denda): RedirectResponse
    {
        return redirect()->route('petugas.denda.index');
    }
}
