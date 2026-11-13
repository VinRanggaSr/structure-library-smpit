<?php

namespace App\Support;

use App\Models\Pengguna;

/** Dua peran sistem: apa yang ditampilkan di layar pilih peran dan ke mana masing-masing masuk. */
class Peran
{
    private const DAFTAR = [
        'master-admin' => [
            'slug' => 'master-admin',
            'role' => Pengguna::ROLE_SUPERADMIN,
            'nama' => 'Master Admin',
            'deskripsi' => 'Mengelola data buku, kategori, siswa, pengguna, jenis denda, dan aturan',
            'ikon' => 'book-bookmark',
            'beranda' => 'admin.dashboard',
            'menu' => 'superadmin',
        ],
        'petugas' => [
            'slug' => 'petugas',
            'role' => Pengguna::ROLE_PENJAGA,
            'nama' => 'Petugas Perpustakaan',
            'deskripsi' => 'Mencatat peminjaman, pengembalian, dan denda siswa',
            'ikon' => 'money-wavy',
            'beranda' => 'petugas.peminjaman.index',
            'menu' => 'penjaga',
        ],
    ];

    public static function semua(): array
    {
        return array_values(self::DAFTAR);
    }

    public static function dariSlug(string $slug): array
    {
        return self::DAFTAR[$slug] ?? abort(404);
    }

    public static function dariRole(string $role): array
    {
        foreach (self::DAFTAR as $peran) {
            if ($peran['role'] === $role) {
                return $peran;
            }
        }

        abort(404);
    }
}
