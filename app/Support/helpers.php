<?php

use Illuminate\Support\Carbon;

if (! function_exists('tanggal')) {
    /** "2024-08-26" -> "26 Agt 2024". Singkatan bulan mengikuti desain (Agt, bukan Agu seperti bawaan Carbon). */
    function tanggal(?Carbon $tanggal): string
    {
        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];

        return $tanggal
            ? $tanggal->format('d') . ' ' . $bulan[$tanggal->month - 1] . ' ' . $tanggal->year
            : '-';
    }
}

if (! function_exists('rupiah')) {
    /** 50000 -> "Rp50.000" */
    function rupiah(int|float $nominal): string
    {
        return 'Rp' . number_format($nominal, 0, ',', '.');
    }
}

if (! function_exists('angka')) {
    /** 1234.5 -> "1.234,5" */
    function angka(int|float $nilai, int $desimal = 0): string
    {
        return number_format($nilai, $desimal, ',', '.');
    }
}
