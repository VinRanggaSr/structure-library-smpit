<?php

return [

    'superadmin' => [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
        ['label' => 'Buku', 'route' => 'admin.buku.index'],
        ['label' => 'Kategori', 'route' => 'admin.kategori.index'],
        ['label' => 'Siswa', 'route' => 'admin.siswa.index'],
        ['label' => 'Pengguna', 'route' => 'admin.pengguna.index'],
        ['label' => 'Jenis Denda', 'route' => 'admin.jenis-denda.index'],
        ['label' => 'Aturan', 'route' => 'admin.aturan.index'],
    ],

    'penjaga' => [
        ['label' => 'Peminjaman', 'route' => 'petugas.peminjaman.index'],
        ['label' => 'Denda', 'route' => 'petugas.denda.index'],
    ],

];
