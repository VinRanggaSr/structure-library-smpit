@php
    use App\Models\Peminjaman;

    $statusTerpilih = request('status');
    $tone = [
        Peminjaman::STATUS_DIPINJAM => 'brand',
        Peminjaman::STATUS_TERLAMBAT => 'red',
        Peminjaman::STATUS_DIKEMBALIKAN => 'green',
    ];
@endphp

<x-app-layout :nav="config('menu.penjaga')" title="Peminjaman">
    <x-ui.page-header title="Peminjaman">
        <x-ui.button variant="primary" :href="route('petugas.peminjaman.create')">Catat Peminjaman</x-ui.button>
    </x-ui.page-header>

    <div class="ui-toolbar">
        <x-ui.tabs label="Filter status peminjaman" :items="collect($jumlahPerStatus)->map(fn ($jumlah, $status) => [
            'label' => $status,
            'count' => $jumlah,
            'href' => $status === 'Semua'
                ? route('petugas.peminjaman.index', request()->except(['status', 'page']))
                : route('petugas.peminjaman.index', ['status' => $status] + request()->except('page')),
            'active' => $status === 'Semua' ? ! $statusTerpilih : $statusTerpilih === $status,
        ])->values()" />
        <x-ui.search placeholder="Cari siswa, judul, atau kode..." />
    </div>

    <div class="ui-section">
        <x-ui.table caption="Daftar peminjaman buku" :paginator="$peminjaman">
            <x-slot:head>
                <th style="width: 200px">Nama Siswa</th>
                <th>Judul Buku</th>
                <th style="width: 110px">Kode</th>
                <th style="width: 100px">Jenis</th>
                <th style="width: 130px">Tgl Pinjam</th>
                <th style="width: 130px">Harus Kembali</th>
                <th style="width: 150px">Status</th>
                <th style="width: 133px"><span class="sr-only">Aksi</span></th>
            </x-slot:head>

            @forelse ($peminjaman as $p)
                <tr class="ui-table__clickable" onclick="location='{{ route('petugas.peminjaman.show', $p) }}'">
                    <td>{{ $p->siswa->nama_siswa }}</td>
                    <td>{{ $p->itemBuku->buku->judul_buku }}</td>
                    <td>{{ $p->itemBuku->kode_buku }}</td>
                    <td>{{ $p->jenis_peminjaman }}</td>
                    <td class="ui-table__muted">{{ tanggal($p->tanggal_peminjaman) }}</td>
                    <td class="ui-table__muted">{{ tanggal($p->tanggal_harus_kembali) }}</td>
                    <td><x-ui.badge :tone="$tone[$p->status_tampilan]">{{ $p->status_tampilan }}</x-ui.badge></td>
                    <td>
                        <x-ui.row-actions
                            label="peminjaman {{ $p->siswa->nama_siswa }}"
                            :edit="route('petugas.peminjaman.edit', $p)"
                            delete-modal="hapus-peminjaman-{{ $p->id_peminjaman }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="ui-table__empty">
                        {{ request('q') || $statusTerpilih ? 'Tidak ada peminjaman yang cocok' : 'Belum ada data peminjaman' }}
                    </td>
                </tr>
            @endforelse
        </x-ui.table>
    </div>

    @foreach ($peminjaman as $p)
        <x-peminjaman.hapus-modal :peminjaman="$p" />
    @endforeach
</x-app-layout>
