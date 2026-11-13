@php
    use App\Models\Denda;
    use App\Models\Peminjaman;

    $buku = $peminjaman->itemBuku->buku;
    $denda = $peminjaman->denda;
    $masihDipinjam = $peminjaman->status_peminjaman === Peminjaman::STATUS_DIPINJAM;

    $tone = [
        Peminjaman::STATUS_DIPINJAM => 'brand',
        Peminjaman::STATUS_TERLAMBAT => 'red',
        Peminjaman::STATUS_DIKEMBALIKAN => 'green',
    ];
    $jenisLabel = [
        Peminjaman::JENIS_HARIAN => 'Harian',
        Peminjaman::JENIS_SEMESTER => 'Buku Pelajaran (Semester)',
    ];
@endphp

<x-app-layout :nav="config('menu.penjaga')" :title="'Peminjaman ' . $peminjaman->siswa->nama_siswa">
    <div class="ui-detail__top">
        <x-ui.back-link :href="route('petugas.peminjaman.index')">Kembali ke Peminjaman</x-ui.back-link>
        <div class="ui-actions">
            <x-ui.button :href="route('petugas.peminjaman.edit', $peminjaman)">Ubah Peminjaman</x-ui.button>
            @if ($masihDipinjam)
                <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-modal', 'kembalikan-buku')">
                    Kembalikan Buku
                </x-ui.button>
            @endif
            <x-ui.button variant="danger" x-data
                         x-on:click="$dispatch('open-modal', 'hapus-peminjaman-{{ $peminjaman->id_peminjaman }}')">
                Hapus
            </x-ui.button>
        </div>
    </div>

    <div class="ui-detail__content">
        <x-ui.book-cover size="lg" :judul="$buku->judul_buku" :penulis="$buku->penulis_buku" />

        <div class="ui-detail__column">
            <dl class="ui-detail__info">
                <div class="ui-detail__row"><dt>Peminjam</dt><dd>{{ $peminjaman->siswa->nama_siswa }}</dd></div>
                <div class="ui-detail__row"><dt>NISN</dt><dd>{{ $peminjaman->siswa->NISN_siswa }}</dd></div>
                <div class="ui-detail__row"><dt>Kode Buku</dt><dd>{{ $peminjaman->itemBuku->kode_buku }}</dd></div>
                <div class="ui-detail__row">
                    <dt>Jenis Peminjaman</dt><dd>{{ $jenisLabel[$peminjaman->jenis_peminjaman] }}</dd>
                </div>
                <div class="ui-detail__row">
                    <dt>Tanggal Pinjam</dt><dd>{{ tanggal($peminjaman->tanggal_peminjaman) }}</dd>
                </div>
                <div class="ui-detail__row">
                    <dt>Harus Kembali</dt><dd>{{ tanggal($peminjaman->tanggal_harus_kembali) }}</dd>
                </div>
                <div class="ui-detail__row">
                    <dt>Tanggal Kembali</dt><dd>{{ tanggal($peminjaman->tanggal_kembali) }}</dd>
                </div>
                <div class="ui-detail__row">
                    <dt>Status</dt>
                    <dd>
                        <span class="ui-detail__inline">
                            <x-ui.badge :tone="$tone[$peminjaman->status_tampilan]">
                                {{ $peminjaman->status_tampilan }}
                            </x-ui.badge>
                            @if ($peminjaman->hari_terlambat > 0)
                                <span class="text-red">Terlambat {{ $peminjaman->hari_terlambat }} hari</span>
                            @endif
                        </span>
                    </dd>
                </div>
                <div class="ui-detail__row">
                    <dt>Dicatat oleh</dt><dd>{{ $peminjaman->petugas?->nama_pengguna ?? '-' }}</dd>
                </div>
            </dl>

            <div class="ui-detail__sub">
                <div class="ui-detail__sub-head">
                    <p class="t-12-medium">Denda</p>
                    @unless ($denda)
                        <button type="button" class="ui-link-btn"
                                x-data x-on:click="$dispatch('open-modal', 'tambah-denda')">Tambah Denda</button>
                    @endunless
                </div>

                <x-ui.table caption="Denda untuk peminjaman ini" :min-width="644">
                    <x-slot:head>
                        <th>Jenis Denda</th>
                        <th style="width: 110px">Total</th>
                        <th style="width: 130px">Status</th>
                        <th style="width: 110px">Tgl Bayar</th>
                        <th style="width: 133px"><span class="sr-only">Aksi</span></th>
                    </x-slot:head>

                    @if ($denda)
                        <tr>
                            <td>{{ $denda->jenisDenda->nama_denda }}</td>
                            <td>{{ rupiah($denda->total_denda) }}</td>
                            <td>
                                <x-ui.badge :tone="$denda->status_denda === Denda::STATUS_LUNAS ? 'green' : 'red'">
                                    {{ $denda->status_denda }}
                                </x-ui.badge>
                            </td>
                            <td class="ui-table__muted">{{ tanggal($denda->tanggal_bayar) }}</td>
                            <td>
                                <x-ui.row-actions label="denda"
                                                  edit-modal="ubah-denda-{{ $denda->id_denda }}"
                                                  delete-modal="hapus-denda-{{ $denda->id_denda }}" />
                            </td>
                        </tr>
                    @else
                        <tr><td colspan="5" class="ui-table__empty">Tidak ada denda untuk peminjaman ini</td></tr>
                    @endif
                </x-ui.table>
            </div>
        </div>
    </div>

    @if ($masihDipinjam)
        <x-ui.modal name="kembalikan-buku" icon="book-bookmark" title="Kembalikan {{ $buku->judul_buku }}"
                    description="Catat tanggal buku {{ $peminjaman->itemBuku->kode_buku }} dikembalikan oleh {{ $peminjaman->siswa->nama_siswa }}"
                    :action="route('petugas.peminjaman.kembalikan', $peminjaman)" method="PATCH">
            <x-ui.date label="Tanggal Kembali" name="tanggal_kembali" :value="today()->toDateString()"
                       :min="$peminjaman->tanggal_peminjaman->toDateString()"
                       :hint="$peminjaman->hari_terlambat > 0
                           ? 'Terlambat ' . $peminjaman->hari_terlambat . ' hari dari batas pengembalian'
                           : 'Dikembalikan tepat waktu'" />

            <x-slot:footer>
                <x-ui.button block x-on:click="$dispatch('close-modal', 'kembalikan-buku')">Batal</x-ui.button>
                <x-ui.button block variant="primary" type="submit">Kembalikan</x-ui.button>
            </x-slot:footer>
        </x-ui.modal>
    @endif

    <x-peminjaman.hapus-modal :peminjaman="$peminjaman" />

    <x-denda.form-modal :peminjaman="$peminjaman" :denda="$denda" :jenis-denda="$jenisDenda" />

    @if ($denda)
        <x-denda.hapus-modal :denda="$denda" />
    @endif
</x-app-layout>
