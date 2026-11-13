<?php

namespace App\Support;

use App\Models\Aturan;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\ItemBuku;
use App\Models\JenisDenda;
use App\Models\KategoriBuku;
use App\Models\Peminjaman;
use App\Models\Pengguna;
use App\Models\Siswa;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Data contoh tahap visual: instance model lengkap dengan relasinya, supaya Blade
 * sudah menulis $peminjaman->siswa->nama_siswa seperti nanti saat query sungguhan masuk.
 * Tanggal dibuat relatif terhadap hari ini agar status Dipinjam/Terlambat tetap masuk akal.
 */
class ContohData
{
    /** @var array<string, Collection> */
    private static array $cache = [];

    /** Judul tambahan dari prototipe, supaya grid buku dan riwayat peminjaman terisi wajar. */
    private const BUKU_TAMBAHAN = [
        [7, 'Ayat-Ayat Cinta', 'Habiburrahman El Shirazy', 'Republika', 2004, 1],
        [8, 'Sirah Nabawiyah', 'Shafiyyurrahman Al-Mubarakfuri', 'Pustaka Al-Kautsar', 2012, 4],
        [9, 'Kisah 25 Nabi dan Rasul', 'Tim Pustaka Ilmu', 'Erlangga', 2018, 4],
        [10, 'Sejarah Indonesia Modern', 'M.C. Ricklefs', 'Serambi', 2008, 3],
        [11, 'IPA Terpadu SMP Kelas VII', 'Tim Kemendikbud', 'Kemendikbud', 2017, 2],
        [12, 'Hafalan Shalat Delisa', 'Tere Liye', 'Republika', 2005, 1],
    ];

    private const SISWA_TAMBAHAN = [
        ['Fatimah Az-Zahra', 'Perempuan'],
        ['Rafi Ahmad Maulana', 'Laki-laki'],
        ['Khadijah Nur Aini', 'Perempuan'],
        ['Umar Abdullah', 'Laki-laki'],
        ['Salma Husna', 'Perempuan'],
        ['Bilal Ramadhan', 'Laki-laki'],
        ['Annisa Fitri', 'Perempuan'],
        ['Yusuf Hakim', 'Laki-laki'],
        ['Maryam Kamila', 'Perempuan'],
        ['Ilham Pratama', 'Laki-laki'],
    ];

    public static function kategori(): Collection
    {
        return self::ingat('kategori', fn () => collect([
            self::model(KategoriBuku::class, 'id_kategori', 1, [
                'nama_kategori' => 'Fiksi',
                'deskripsi_kategori' => 'Buku yang berisi cerita rekaan, khayalan, atau hasil imajinasi dari pengarangnya.',
            ]),
            self::model(KategoriBuku::class, 'id_kategori', 2, [
                'nama_kategori' => 'Non-Fiksi',
                'deskripsi_kategori' => 'Buku yang berisi informasi, data, atau kejadian yang benar-benar terjadi dalam kehidupan nyata.',
            ]),
            self::model(KategoriBuku::class, 'id_kategori', 3, [
                'nama_kategori' => 'Sejarah',
                'deskripsi_kategori' => 'Karya tulis non-fiksi yang mendokumentasikan, menganalisis, serta menafsirkan peristiwa, masyarakat, tokoh, dan perkembangan di masa lalu berdasarkan bukti nyata.',
            ]),
            self::model(KategoriBuku::class, 'id_kategori', 4, [
                'nama_kategori' => 'Keagamaan',
                'deskripsi_kategori' => 'Karya tulis yang berisi ajaran, pedoman hidup, nilai-nilai spiritual, serta pengetahuan mengenai suatu agama tertentu untuk membimbing umatnya.',
            ]),
        ]));
    }

    public static function buku(): Collection
    {
        return self::ingat('buku', function () {
            $kategori = self::kategori()->keyBy('id_kategori');

            $buku = collect([
                [1, 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 3, 1],
                [2, 'Bumi', 'Tere Liye', 'Gramedia', 2014, 2, 1],
                [3, 'Sejarah Islam di Nusantara', 'Prof. Azyumardi Azra', 'Mizan', 2013, 2, 3],
                [4, 'Matematika untuk SMP Kelas VIII', 'Tim Kemendikbud', 'Kemendikbud', 2017, 3, 2],
                [5, 'Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia', 2009, 2, 1],
                [6, 'Ensiklopedia Sains Junior', 'Wolf and Sons', 'Erlangga', 1997, 1, 2],
            ])->map(fn (array $baris) => self::model(Buku::class, 'id_buku', $baris[0], [
                'judul_buku' => $baris[1],
                'penulis_buku' => $baris[2],
                'penerbit_buku' => $baris[3],
                'tahun_terbit_buku' => $baris[4],
                'stok_buku' => $baris[5],
                'id_kategori' => $baris[6],
            ]))->concat(collect(self::BUKU_TAMBAHAN)->map(
                fn (array $baris) => self::model(Buku::class, 'id_buku', $baris[0], [
                    'judul_buku' => $baris[1],
                    'penulis_buku' => $baris[2],
                    'penerbit_buku' => $baris[3],
                    'tahun_terbit_buku' => $baris[4],
                    'stok_buku' => 2,
                    'id_kategori' => $baris[5],
                ])
            ));

            return $buku->each(fn (Buku $b) => $b->setRelation('kategori', $kategori[$b->id_kategori]));
        });
    }

    public static function itemBuku(): Collection
    {
        return self::ingat('itemBuku', function () {
            $buku = self::buku()->keyBy('id_buku');

            $item = collect([
                [1, 'BK-10231', 'Dipinjam', '2024-08-26', 1],
                [2, 'BK-10232', 'Tersedia', '2024-08-26', 1],
                [3, 'BK-10233', 'Tersedia', '2025-04-04', 1],
                [4, 'BK-20411', 'Dipinjam', '2024-01-12', 2],
                [5, 'BK-20412', 'Tersedia', '2024-01-12', 2],
                [6, 'BK-30832', 'Tersedia', '2023-07-19', 3],
                [7, 'BK-30833', 'Dipinjam', '2023-07-19', 3],
                [8, 'BK-40832', 'Tersedia', '2024-08-26', 4],
                [9, 'BK-40833', 'Dipinjam', '2024-08-26', 4],
                [10, 'BK-40834', 'Tersedia', '2025-04-04', 4],
                [11, 'BK-51414', 'Tersedia', '2025-04-04', 5],
                [12, 'BK-51415', 'Tersedia', '2025-04-04', 5],
                [13, 'BK-81414', 'Tersedia', '2022-02-10', 6],
            ])->map(fn (array $baris) => self::model(ItemBuku::class, 'id_item_buku', $baris[0], [
                'kode_buku' => $baris[1],
                'status_buku' => $baris[2],
                'tanggal_pembelian' => $baris[3],
                'id_buku' => $baris[4],
            ]));

            $idItem = 14;
            foreach (self::BUKU_TAMBAHAN as $judul) {
                foreach ([1, 2] as $ke) {
                    $item->push(self::model(ItemBuku::class, 'id_item_buku', $idItem++, [
                        'kode_buku' => 'BK-' . $judul[0] . str_pad((string) (4000 + $ke * 7 + $judul[0] * 13), 4, '0', STR_PAD_LEFT),
                        'status_buku' => ItemBuku::STATUS_TERSEDIA,
                        'tanggal_pembelian' => (2023 + $judul[0] % 3) . '-0' . (1 + $judul[0] % 8) . '-1' . $ke,
                        'id_buku' => $judul[0],
                    ]));
                }
            }

            $item->each(fn (ItemBuku $i) => $i->setRelation('buku', $buku[$i->id_buku]));

            $buku->each(function (Buku $b) use ($item) {
                $miliknya = $item->where('id_buku', $b->id_buku)->values();
                $b->setRelation('itemBuku', $miliknya);
                $b->item_buku_count = $miliknya->count();
                $b->tersedia_count = $miliknya->where('status_buku', ItemBuku::STATUS_TERSEDIA)->count();
            });

            return $item;
        });
    }

    public static function siswa(): Collection
    {
        return self::ingat('siswa', fn () => collect([
            [1, '0081234567', 'Ahmad Fauzan', 'Laki-laki', 'Aktif'],
            [2, '0082345678', 'Aisyah Putri Ramadhani', 'Perempuan', 'Aktif'],
            [3, '0083456789', 'Muhammad Rizky', 'Laki-laki', 'Aktif'],
            [4, '0084567890', 'Nadia Salsabila', 'Perempuan', 'Aktif'],
            [5, '0085678901', 'Hafidz Al Farisi', 'Laki-laki', 'Aktif'],
            [6, '0076789012', 'Zahra Khairunnisa', 'Perempuan', 'Tidak Aktif'],
        ])->map(fn (array $baris) => self::model(Siswa::class, 'id_siswa', $baris[0], [
            'NISN_siswa' => $baris[1],
            'nama_siswa' => $baris[2],
            'jenis_kelamin_siswa' => $baris[3],
            'status_siswa' => $baris[4],
        ]))->concat(collect(self::SISWA_TAMBAHAN)->map(
            fn (array $baris, int $i) => self::model(Siswa::class, 'id_siswa', 7 + $i, [
                'NISN_siswa' => substr('00' . (91000000 + $i * 137531), 0, 10),
                'nama_siswa' => $baris[0],
                'jenis_kelamin_siswa' => $baris[1],
                'status_siswa' => Siswa::STATUS_AKTIF,
            ])
        )));
    }

    public static function pengguna(): Collection
    {
        return self::ingat('pengguna', fn () => collect([
            [1, 'Admin Perpustakaan', 'admin', 'admin123', 'Superadmin'],
            [2, 'Siti Rahmawati', 'sitirahmawati', 'siti2026', 'Penjaga'],
            [3, 'Bambang Suharto', 'bambangsuharto', '9201bs', 'Penjaga'],
        ])->map(fn (array $baris) => self::model(Pengguna::class, 'id_pengguna', $baris[0], [
            'nama_pengguna' => $baris[1],
            'username_pengguna' => $baris[2],
            'password_pengguna' => $baris[3],
            'role_pengguna' => $baris[4],
        ])));
    }

    public static function penggunaBerperan(string $role): ?Pengguna
    {
        return self::pengguna()->firstWhere('role_pengguna', $role);
    }

    public static function aturan(): Collection
    {
        return self::ingat('aturan', fn () => collect([
            [1, 'Batas waktu pinjaman harian', 'Buku harian dipinjam maksimal 7 hari dan wajib dikembalikan sebelum atau pada tanggal harus kembali.'],
            [2, 'Buku pelajaran semester', 'Buku pelajaran dipinjam selama satu semester dan dikembalikan paling lambat di akhir semester.'],
            [3, 'Denda keterlambatan', 'Keterlambatan pengembalian dikenakan denda Rp1.000 per hari untuk setiap buku.'],
            [4, 'Kerusakan dan kehilangan', 'Buku yang rusak atau hilang dikenakan denda sesuai jenis denda yang berlaku.'],
            [5, 'Jaga kondisi buku', 'Dilarang mencoret, melipat, atau merobek halaman buku. Laporkan ke petugas jika buku sudah rusak saat dipinjam.'],
        ])->map(fn (array $baris) => self::model(Aturan::class, 'id_aturan', $baris[0], [
            'judul_aturan' => $baris[1],
            'deskripsi_aturan' => $baris[2],
        ])));
    }

    public static function jenisDenda(): Collection
    {
        return self::ingat('jenisDenda', fn () => collect([
            [1, 'Keterlambatan', 1000, 'Denda per hari keterlambatan pengembalian buku'],
            [2, 'Kerusakan Buku', 25000, 'Denda untuk siswa yang merusak buku'],
            [3, 'Kehilangan Buku', 50000, 'Denda untuk siswa yang menghilangkan buku'],
        ])->map(fn (array $baris) => self::model(JenisDenda::class, 'id_jenis_denda', $baris[0], [
            'nama_denda' => $baris[1],
            'nominal_denda' => $baris[2],
            'keterangan_denda' => $baris[3],
        ])));
    }

    public static function peminjaman(): Collection
    {
        return self::ingat('peminjaman', function () {
            $siswa = self::siswa()->keyBy('id_siswa');
            $item = self::itemBuku()->keyBy('id_item_buku');
            $petugas = self::pengguna()->keyBy('id_pengguna');

            $peminjaman = collect([
                [1, 'Harian', -3, 4, null, 'Dipinjam', 1, 1],
                [2, 'Harian', -12, -5, null, 'Dipinjam', 2, 4],
                [3, 'Harian', -20, -13, -10, 'Dikembalikan', 3, 8],
                [4, 'Harian', -6, -6, -6, 'Dikembalikan', 4, 11],
                [5, 'Harian', -1, 6, null, 'Dipinjam', 5, 7],
                [6, 'Harian', -30, -23, -22, 'Dikembalikan', 1, 13],
                [7, 'Semester', -60, null, null, 'Dipinjam', 4, 9],
            ])->map(function (array $baris) {
                $tanggalPinjam = self::hari($baris[2]);

                return self::model(Peminjaman::class, 'id_peminjaman', $baris[0], [
                    'jenis_peminjaman' => $baris[1],
                    'tanggal_peminjaman' => $tanggalPinjam,
                    'tanggal_harus_kembali' => $baris[3] === null
                        ? self::akhirSemester($tanggalPinjam)
                        : self::hari($baris[3]),
                    'tanggal_kembali' => $baris[4] === null ? null : self::hari($baris[4]),
                    'status_peminjaman' => $baris[5],
                    'id_siswa' => $baris[6],
                    'id_item_buku' => $baris[7],
                    'id_pengguna' => 2,
                ]);
            });

            $peminjaman = $peminjaman->concat(self::riwayat($peminjaman));

            $peminjaman->each(function (Peminjaman $p) use ($siswa, $item, $petugas) {
                $p->setRelation('siswa', $siswa[$p->id_siswa]);
                $p->setRelation('itemBuku', $item[$p->id_item_buku]);
                $p->setRelation('petugas', $petugas[$p->id_pengguna]);
            });

            return self::pasangDenda($peminjaman);
        });
    }

    /**
     * Peminjaman lama yang sudah dikembalikan, dibuat mundur dari pinjaman terawal tiap
     * eksemplar supaya status item tetap konsisten. Deterministik dan hanya untuk tahap
     * visual: tabel butuh lebih dari 15 baris agar footer paginasi ikut terlihat.
     */
    private static function riwayat(Collection $berjalan): Collection
    {
        $riwayat = collect();
        $idPeminjaman = 100;

        foreach (self::itemBuku() as $item) {
            $awal = $berjalan->where('id_item_buku', $item->id_item_buku)->min('tanggal_peminjaman');
            $kursor = Carbon::parse($awal ?? self::hari(-($item->id_item_buku % 8) - 1));

            foreach (range(0, 3) as $ke) {
                $jeda = 3 + ($item->id_item_buku * 7 + $ke * 5) % 14;
                $tanggalKembali = $kursor->copy()->subDays($jeda);
                $lama = 2 + ($item->id_item_buku * 3 + $ke * 11) % 10;
                $tanggalPinjam = $tanggalKembali->copy()->subDays($lama);
                $kursor = $tanggalPinjam;

                $riwayat->push(self::model(Peminjaman::class, 'id_peminjaman', $idPeminjaman++, [
                    'jenis_peminjaman' => Peminjaman::JENIS_HARIAN,
                    'tanggal_peminjaman' => $tanggalPinjam->toDateString(),
                    'tanggal_harus_kembali' => $tanggalPinjam->copy()->addDays(7)->toDateString(),
                    'tanggal_kembali' => $tanggalKembali->toDateString(),
                    'status_peminjaman' => Peminjaman::STATUS_DIKEMBALIKAN,
                    'id_siswa' => 1 + ($item->id_item_buku * 3 + $ke) % 16,
                    'id_item_buku' => $item->id_item_buku,
                    'id_pengguna' => $ke % 3 === 0 ? 3 : 2,
                ]));
            }
        }

        return $riwayat;
    }

    public static function denda(): Collection
    {
        return self::peminjaman()
            ->map(fn (Peminjaman $p) => $p->denda)
            ->filter()
            ->sortBy('id_denda')
            ->values();
    }

    /** Satu peminjaman punya paling banyak satu denda (ERD), jadi relasinya dipasang dua arah di sini. */
    private static function pasangDenda(Collection $peminjaman): Collection
    {
        $jenis = self::jenisDenda()->keyBy('id_jenis_denda');
        $terindeks = $peminjaman->keyBy('id_peminjaman');

        $baku = collect([
            [1, 3, 3000, 'Belum Lunas', null, 3, 1],
            [2, 1, 25000, 'Lunas', -20, 6, 2],
        ])->map(fn (array $baris) => [
            'id' => $baris[0],
            'jumlah' => $baris[1],
            'total' => $baris[2],
            'status' => $baris[3],
            'bayar' => $baris[4] === null ? null : self::hari($baris[4]),
            'id_peminjaman' => $baris[5],
            'id_jenis_denda' => $baris[6],
        ]);

        $idDenda = 100;
        $keterlambatan = $jenis->firstWhere('nama_denda', 'Keterlambatan');

        $dariRiwayat = $peminjaman
            ->filter(fn (Peminjaman $p) => $p->id_peminjaman >= 100 && $p->hari_terlambat > 0)
            ->map(function (Peminjaman $p) use (&$idDenda, $keterlambatan) {
                $lunas = $p->id_peminjaman % 10 < 7;

                return [
                    'id' => $idDenda++,
                    'jumlah' => $p->hari_terlambat,
                    'total' => $p->hari_terlambat * $keterlambatan->nominal_denda,
                    'status' => $lunas ? Denda::STATUS_LUNAS : Denda::STATUS_BELUM_LUNAS,
                    'bayar' => $lunas ? $p->tanggal_kembali->toDateString() : null,
                    'id_peminjaman' => $p->id_peminjaman,
                    'id_jenis_denda' => $keterlambatan->id_jenis_denda,
                ];
            });

        $baku->concat($dariRiwayat)->each(function (array $baris) use ($jenis, $terindeks) {
            $denda = self::model(Denda::class, 'id_denda', $baris['id'], [
                'jumlah_denda' => $baris['jumlah'],
                'total_denda' => $baris['total'],
                'status_denda' => $baris['status'],
                'tanggal_bayar' => $baris['bayar'],
                'id_peminjaman' => $baris['id_peminjaman'],
                'id_jenis_denda' => $baris['id_jenis_denda'],
            ]);

            $denda->setRelation('jenisDenda', $jenis[$denda->id_jenis_denda]);
            $denda->setRelation('peminjaman', $terindeks[$denda->id_peminjaman]);
            $terindeks[$denda->id_peminjaman]->setRelation('denda', $denda);
        });

        return $peminjaman->each(function (Peminjaman $p) {
            if (! $p->relationLoaded('denda')) {
                $p->setRelation('denda', null);
            }
        });
    }

    /** Seperti KategoriBuku::withCount('buku') — dipakai popup hapus untuk menolak kategori yang masih terpakai. */
    public static function kategoriDenganJumlahBuku(): Collection
    {
        $jumlah = self::buku()->countBy('id_kategori');

        return self::kategori()->each(fn (KategoriBuku $k) => $k->buku_count = $jumlah[$k->id_kategori] ?? 0);
    }

    /** Seperti JenisDenda::withCount('denda'). */
    public static function jenisDendaDenganJumlahDenda(): Collection
    {
        $jumlah = self::denda()->countBy('id_jenis_denda');

        return self::jenisDenda()->each(fn (JenisDenda $j) => $j->denda_count = $jumlah[$j->id_jenis_denda] ?? 0);
    }

    /** Seperti Siswa::withCount('peminjaman'). */
    public static function siswaDenganJumlahPeminjaman(): Collection
    {
        $jumlah = self::peminjaman()->countBy('id_siswa');

        return self::siswa()->each(fn (Siswa $s) => $s->peminjaman_count = $jumlah[$s->id_siswa] ?? 0);
    }

    /** Seperti Pengguna::withCount('peminjaman'). */
    public static function penggunaDenganJumlahPeminjaman(): Collection
    {
        $jumlah = self::peminjaman()->countBy('id_pengguna');

        return self::pengguna()->each(fn (Pengguna $u) => $u->peminjaman_count = $jumlah[$u->id_pengguna] ?? 0);
    }

    /** Seperti KategoriBuku::withCount('buku') — dipakai popup hapus untuk menolak kategori yang masih terpakai. */
    public static function halaman(Collection $baris, int $perHalaman = 15): LengthAwarePaginator
    {
        $halaman = LengthAwarePaginator::resolveCurrentPage();

        return new LengthAwarePaginator(
            $baris->forPage($halaman, $perHalaman)->values(),
            $baris->count(),
            $perHalaman,
            $halaman,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => request()->query()],
        );
    }

    /** @template T of \Illuminate\Database\Eloquent\Model */
    private static function model(string $kelas, string $primaryKey, int $id, array $atribut): object
    {
        $model = new $kelas($atribut);
        $model->setAttribute($primaryKey, $id);
        $model->exists = true;

        return $model;
    }

    private static function hari(int $selisih): string
    {
        return today()->addDays($selisih)->toDateString();
    }

    /** Semester berakhir 30 Juni (Jan–Jun) atau 31 Desember (Jul–Des). */
    private static function akhirSemester(string $tanggal): string
    {
        $t = Carbon::parse($tanggal);

        return $t->month <= 6 ? "{$t->year}-06-30" : "{$t->year}-12-31";
    }

    private static function ingat(string $kunci, callable $buat): Collection
    {
        return self::$cache[$kunci] ??= $buat();
    }
}
