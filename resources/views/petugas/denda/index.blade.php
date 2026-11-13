@php
    use App\Models\Denda;

    $statusTerpilih = request('status');
@endphp

<x-app-layout :nav="config('menu.penjaga')" title="Denda">
    <x-ui.page-header title="Denda">
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-modal', 'tambah-denda')">
            Tambah Denda
        </x-ui.button>
    </x-ui.page-header>

    <div class="ui-toolbar">
        <x-ui.tabs label="Filter status denda" :items="collect($jumlahPerStatus)->map(fn ($jumlah, $status) => [
            'label' => $status,
            'count' => $jumlah,
            'href' => $status === 'Semua'
                ? route('petugas.denda.index', request()->except(['status', 'page']))
                : route('petugas.denda.index', ['status' => $status] + request()->except('page')),
            'active' => $status === 'Semua' ? ! $statusTerpilih : $statusTerpilih === $status,
        ])->values()" />

        <div class="ui-toolbar__group">
            <p class="t-12-regular text-gray">
                Belum lunas: <span class="t-12-medium text-red">{{ rupiah($totalBelumLunas) }}</span>
            </p>
            <x-ui.search placeholder="Cari data denda..." />
        </div>
    </div>

    <div class="ui-section">
        <x-ui.table caption="Daftar denda siswa" :paginator="$denda">
            <x-slot:head>
                <th style="width: 190px">Nama Siswa</th>
                <th>Peminjaman</th>
                <th style="width: 150px">Jenis Denda</th>
                <th style="width: 80px">Jumlah</th>
                <th style="width: 120px">Total Denda</th>
                <th style="width: 140px">Status</th>
                <th style="width: 120px">Tgl Bayar</th>
                <th style="width: 133px"><span class="sr-only">Aksi</span></th>
            </x-slot:head>

            @forelse ($denda as $d)
                <tr class="ui-table__clickable"
                    x-data x-on:click="$dispatch('open-modal', 'ubah-denda-{{ $d->id_denda }}')">
                    <td>{{ $d->peminjaman->siswa->nama_siswa }}</td>
                    <td>
                        <a href="{{ route('petugas.peminjaman.show', $d->peminjaman) }}" class="ui-table__link"
                           x-on:click.stop>
                            {{ $d->peminjaman->itemBuku->buku->judul_buku }} · {{ $d->peminjaman->itemBuku->kode_buku }}
                        </a>
                    </td>
                    <td>{{ $d->jenisDenda->nama_denda }}</td>
                    <td>{{ $d->jumlah_denda }}</td>
                    <td>{{ rupiah($d->total_denda) }}</td>
                    <td>
                        <x-ui.badge :tone="$d->status_denda === Denda::STATUS_LUNAS ? 'green' : 'red'">
                            {{ $d->status_denda }}
                        </x-ui.badge>
                    </td>
                    <td class="ui-table__muted">{{ tanggal($d->tanggal_bayar) }}</td>
                    <td>
                        <x-ui.row-actions
                            label="denda {{ $d->peminjaman->siswa->nama_siswa }}"
                            edit-modal="ubah-denda-{{ $d->id_denda }}"
                            delete-modal="hapus-denda-{{ $d->id_denda }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="ui-table__empty">
                        {{ request('q') || $statusTerpilih ? 'Tidak ada denda yang cocok' : 'Belum ada data denda' }}
                    </td>
                </tr>
            @endforelse
        </x-ui.table>
    </div>

    <x-denda.form-modal :jenis-denda="$jenisDenda" :pilihan-peminjaman="$pilihanPeminjaman" />

    @foreach ($denda as $d)
        <x-denda.form-modal :denda="$d" :jenis-denda="$jenisDenda" :pilihan-peminjaman="$pilihanPeminjaman" />
        <x-denda.hapus-modal :denda="$d" />
    @endforeach
</x-app-layout>
