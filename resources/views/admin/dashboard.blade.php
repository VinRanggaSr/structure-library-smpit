@php
    $versus = 'vs ' . angka($aktivitas['hari']) . ' hari sebelumnya';
    $denda = $aktivitas['denda'];
    $persenPeminjam = $aktivitas['siswaTerdaftar']
        ? round($aktivitas['siswaPeminjam'] / $aktivitas['siswaTerdaftar'] * 100)
        : 0;
@endphp

<x-app-layout :nav="config('menu.superadmin')" title="Aktivitas Perpustakaan">
    <div class="ui-dashboard">
        {{-- Satu filter di kanan atas, berlaku untuk seluruh angka di bawahnya. --}}
        <x-ui.page-header title="Aktivitas Perpustakaan">
            <x-ui.date-range-picker :start="$mulai" :end="$sampai" :presets="$rentangCepat"
                                    :max="today()->toDateString()" />
        </x-ui.page-header>

        <section class="ui-dashboard__body" aria-label="Aktivitas perpustakaan">
            <div class="ui-dashboard__tiles">
                <x-ui.stat-tile label="Total peminjaman"
                                :value="angka($aktivitas['totalPinjam'])"
                                :delta="$aktivitas['deltaPinjam']" good-when-up :versus="$versus" />
                <x-ui.stat-tile label="Siswa yang meminjam"
                                :value="angka($aktivitas['siswaPeminjam'])"
                                :sub="$persenPeminjam . '% dari ' . angka($aktivitas['siswaTerdaftar']) . ' siswa terdaftar'" />
                <x-ui.stat-tile label="Rata-rata lama pinjam"
                                :value="angka($aktivitas['rataLama'], 1) . ' hari'"
                                sub="Batas pinjaman harian 7 hari" />
                <x-ui.stat-tile label="Denda tercatat"
                                :value="rupiah($denda['total'])"
                                :delta="$denda['delta']" :versus="$versus" />
            </div>

            <div class="ui-dashboard__grid">
                <x-ui.card class="ui-dashboard__cell--4" title="Tren Peminjaman"
                           :description="'Jumlah buku dipinjam per ' . $aktivitas['granularitas']">
                    <x-ui.column-chart :items="$aktivitas['tren']" />
                </x-ui.card>

                <x-ui.card class="ui-dashboard__cell--2" title="Ketepatan Pengembalian"
                           description="Pinjaman yang dimulai pada periode ini">
                    {{-- Urutan hijau → ungu → merah; celah antar potongan menjaga merah dan hijau tetap terbaca. --}}
                    <x-ui.donut-chart caption="tepat waktu" :segments="[
                        ['label' => 'Kembali tepat waktu', 'value' => $aktivitas['ketepatan']['tepat'], 'color' => 'var(--chart-good)'],
                        ['label' => 'Masih dipinjam', 'value' => $aktivitas['ketepatan']['dipinjam'], 'color' => 'var(--chart-series)'],
                        ['label' => 'Terlambat', 'value' => $aktivitas['ketepatan']['terlambat'], 'color' => 'var(--chart-critical)'],
                    ]" />
                </x-ui.card>

                <x-ui.card class="ui-dashboard__cell--3" title="Buku Terpopuler"
                           description="5 judul yang paling sering dipinjam">
                    <x-ui.bar-list :items="$aktivitas['bukuPopuler']" empty="Belum ada peminjaman" />
                </x-ui.card>

                <x-ui.card class="ui-dashboard__cell--3" title="Peminjaman per Kategori"
                           description="5 kategori dengan peminjaman terbanyak">
                    <x-ui.bar-list :items="$aktivitas['kategori']" empty="Belum ada peminjaman" />
                </x-ui.card>

                <x-ui.card class="ui-dashboard__cell--3" title="Jenis Denda Terbesar"
                           description="2 jenis denda dengan nominal terbesar">
                    <x-ui.bar-list :items="$denda['perJenis']" format="rupiah"
                                   empty="Tidak ada denda pada periode ini" />
                </x-ui.card>

                <x-ui.card class="ui-dashboard__cell--3" title="Pembayaran Denda"
                           description="Denda yang tercatat pada periode ini">
                    @if ($denda['total'] === 0)
                        <p class="ui-dashboard__empty">Tidak ada denda pada periode ini.</p>
                    @else
                        <div class="ui-dashboard__denda">
                            <x-ui.meter label="Sudah dibayar" tone="good"
                                        :value="$denda['lunas']" :max="$denda['total']"
                                        :detail="rupiah($denda['lunas']) . ' dari ' . rupiah($denda['total'])" />
                            <dl class="ui-dashboard__figures">
                                <div>
                                    <dt>Belum dibayar</dt>
                                    <dd>{{ rupiah($denda['belum']) }}</dd>
                                </div>
                                <div>
                                    <dt>Jumlah tagihan</dt>
                                    <dd>{{ angka($denda['jumlah']) }}</dd>
                                </div>
                            </dl>
                        </div>
                    @endif
                </x-ui.card>
            </div>
        </section>
    </div>
</x-app-layout>
