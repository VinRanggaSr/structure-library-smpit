<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Http\Requests\KembalikanPeminjamanRequest;
use App\Http\Requests\StorePeminjamanRequest;
use App\Http\Requests\UpdatePeminjamanRequest;
use App\Models\ItemBuku;
use App\Models\Peminjaman;
use App\Models\Siswa;
use App\Support\ContohData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(): View
    {
        // Peminjaman terbaru di atas.
        $semua = ContohData::peminjaman()
            ->sortByDesc(fn (Peminjaman $p) => [$p->tanggal_peminjaman->toDateString(), $p->id_peminjaman])
            ->values();

        return view('petugas.peminjaman.index', [
            'peminjaman' => ContohData::halaman($semua),
            'jumlahPerStatus' => [
                'Semua' => $semua->count(),
                Peminjaman::STATUS_DIPINJAM => $semua->where('status_tampilan', Peminjaman::STATUS_DIPINJAM)->count(),
                Peminjaman::STATUS_TERLAMBAT => $semua->where('status_tampilan', Peminjaman::STATUS_TERLAMBAT)->count(),
                Peminjaman::STATUS_DIKEMBALIKAN => $semua->where('status_tampilan', Peminjaman::STATUS_DIKEMBALIKAN)->count(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('petugas.peminjaman.form', [
            'peminjaman' => null,
            'siswa' => $this->siswaAktif(),
            'itemTersedia' => $this->itemTersedia(),
            'aturan' => ContohData::aturan(),
        ]);
    }

    public function store(StorePeminjamanRequest $request): RedirectResponse
    {
        return redirect()->route('petugas.peminjaman.index');
    }

    public function show(int $peminjaman): View
    {
        return view('petugas.peminjaman.show', [
            'peminjaman' => $this->temukan($peminjaman),
            'jenisDenda' => ContohData::jenisDenda(),
        ]);
    }

    public function edit(int $peminjaman): View
    {
        $pinjam = $this->temukan($peminjaman);

        return view('petugas.peminjaman.form', [
            'peminjaman' => $pinjam,
            'siswa' => $this->siswaAktif(),
            'itemTersedia' => $this->itemTersedia($pinjam),
            'aturan' => ContohData::aturan(),
        ]);
    }

    public function update(UpdatePeminjamanRequest $request, int $peminjaman): RedirectResponse
    {
        return redirect()->route('petugas.peminjaman.show', $peminjaman);
    }

    public function destroy(int $peminjaman): RedirectResponse
    {
        return redirect()->route('petugas.peminjaman.index');
    }

    public function kembalikan(KembalikanPeminjamanRequest $request, int $peminjaman): RedirectResponse
    {
        return redirect()->route('petugas.peminjaman.show', $peminjaman);
    }

    private function temukan(int $id): Peminjaman
    {
        return ContohData::peminjaman()->firstWhere('id_peminjaman', $id) ?? abort(404);
    }

    private function siswaAktif()
    {
        return ContohData::siswa()
            ->where('status_siswa', Siswa::STATUS_AKTIF)
            ->sortBy('nama_siswa')
            ->values();
    }

    /** Eksemplar yang bebas, ditambah eksemplar yang sedang dipegang peminjaman ini. */
    private function itemTersedia(?Peminjaman $peminjaman = null)
    {
        return ContohData::itemBuku()
            ->filter(fn (ItemBuku $i) => $i->status_buku === ItemBuku::STATUS_TERSEDIA
                || $i->id_item_buku === $peminjaman?->id_item_buku)
            ->sortBy([['buku.judul_buku', 'asc'], ['kode_buku', 'asc']])
            ->values();
    }
}
