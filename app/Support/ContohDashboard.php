<?php

namespace App\Support;

/**
 * Angka dashboard tahap visual. Nanti dihitung dari tabel peminjaman & denda
 * pada rentang tanggal yang dipilih, lalu berkas ini ikut dihapus.
 */
class ContohDashboard
{
    /** Rentang cepat pada pemilih tanggal. */
    public static function rentangCepat(): array
    {
        return [
            ['label' => '7 hari terakhir', 'start' => today()->subDays(6)->toDateString()],
            ['label' => '30 hari terakhir', 'start' => today()->subDays(29)->toDateString()],
            ['label' => 'Bulan ini', 'start' => today()->startOfMonth()->toDateString()],
            ['label' => '3 bulan terakhir', 'start' => today()->subMonths(2)->startOfMonth()->toDateString()],
            ['label' => '6 bulan terakhir', 'start' => today()->subMonths(5)->startOfMonth()->toDateString()],
            ['label' => '12 bulan terakhir', 'start' => today()->subMonths(11)->startOfMonth()->toDateString()],
            ['label' => 'Tahun ini', 'start' => today()->startOfYear()->toDateString()],
        ];
    }

    public static function aktivitas(): array
    {
        return [
            'hari' => 184,
            'totalPinjam' => 221,
            'deltaPinjam' => 12,
            'siswaPeminjam' => 5,
            'siswaTerdaftar' => ContohData::siswa()->count(),
            'rataLama' => 5.6,
            'granularitas' => 'bulan',
            'tren' => self::tren(),
            'ketepatan' => ['tepat' => 184, 'dipinjam' => 3, 'terlambat' => 34],
            'bukuPopuler' => [
                ['label' => 'Laskar Pelangi', 'meta' => 'Andrea Hirata', 'value' => 36],
                ['label' => 'Bumi', 'meta' => 'Tere Liye', 'value' => 26],
                ['label' => 'Negeri 5 Menara', 'meta' => 'Ahmad Fuadi', 'value' => 24],
                ['label' => 'Matematika untuk SMP Kelas VIII', 'meta' => 'Tim Kemendikbud', 'value' => 19],
                ['label' => 'Sejarah Islam di Nusantara', 'meta' => 'Prof. Azyumardi Azra', 'value' => 14],
            ],
            'kategori' => [
                ['label' => 'Fiksi', 'value' => 86],
                ['label' => 'Non-Fiksi', 'value' => 52],
                ['label' => 'Sejarah', 'value' => 41],
                ['label' => 'Keagamaan', 'value' => 18],
            ],
            'denda' => [
                'total' => 213000,
                'delta' => -26,
                'lunas' => 185000,
                'belum' => 28000,
                'jumlah' => 24,
                'perJenis' => [
                    ['label' => 'Kerusakan Buku', 'meta' => '5 tagihan', 'value' => 125000],
                    ['label' => 'Keterlambatan', 'meta' => '19 tagihan', 'value' => 88000],
                ],
            ],
        ];
    }

    /** Enam bulan terakhir untuk grafik kolom; bulan berjalan ditandai "(sebagian)". */
    private static function tren(): array
    {
        $jumlah = [41, 28, 46, 39, 32, 35];

        return collect(range(5, 0))->map(function (int $mundur) use ($jumlah) {
            $awal = today()->subMonths($mundur)->startOfMonth();

            return [
                'tick' => $awal->locale('id')->translatedFormat('M'),
                'label' => $awal->locale('id')->translatedFormat('F Y') . ($mundur === 0 ? ' (sebagian)' : ''),
                'value' => $jumlah[5 - $mundur],
            ];
        })->all();
    }
}
