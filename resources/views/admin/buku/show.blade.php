@php
    $item = $buku->itemBuku;
    $tersedia = $item->where('status_buku', \App\Models\ItemBuku::STATUS_TERSEDIA)->count();
@endphp

<x-app-layout :nav="config('menu.superadmin')" :title="$buku->judul_buku">
    <div class="ui-detail__top">
        <x-ui.back-link :href="route('admin.buku.index')">Kembali ke Buku</x-ui.back-link>
        <div class="ui-actions">
            <x-ui.button :href="route('admin.buku.edit', $buku)">Ubah Detail Buku</x-ui.button>
            <x-ui.button variant="danger" x-data x-on:click="$dispatch('open-modal', 'hapus-buku')">Hapus</x-ui.button>
        </div>
    </div>

    <div class="ui-detail__content">
        <x-ui.book-cover size="lg" :judul="$buku->judul_buku" :penulis="$buku->penulis_buku" />

        <div class="ui-detail__column">
            <dl class="ui-detail__info">
                <div class="ui-detail__row">
                    <dt>Kategori</dt>
                    <dd>
                        <button type="button" class="ui-detail__link"
                                x-data x-on:click="$dispatch('open-modal', 'kategori-buku')">
                            {{ $buku->kategori->nama_kategori }}
                            <img src="{{ asset('icons/arrow-right.svg') }}" alt="" width="24" height="24"
                                 class="ui-detail__arrow">
                        </button>
                    </dd>
                </div>
                <div class="ui-detail__row">
                    <dt>Penerbit</dt>
                    <dd>{{ $buku->penerbit_buku ?: '-' }}</dd>
                </div>
                <div class="ui-detail__row">
                    <dt>Tahun Terbit</dt>
                    <dd>{{ $buku->tahun_terbit_buku ?: '-' }}</dd>
                </div>
                <div class="ui-detail__row">
                    <dt>Jumlah Buku</dt>
                    <dd>{{ $item->count() }}</dd>
                </div>
                <div class="ui-detail__row">
                    <dt>Tersedia</dt>
                    <dd>{{ $tersedia }} dari {{ $item->count() }}</dd>
                </div>
            </dl>

            <div class="ui-detail__sub">
                <div class="ui-detail__sub-head">
                    <p class="t-12-medium">Buku Terdaftar</p>
                    <button type="button" class="ui-link-btn"
                            x-data x-on:click="$dispatch('open-modal', 'tambah-item-buku')">Tambah Buku</button>
                </div>

                <x-ui.table caption="Item buku {{ $buku->judul_buku }}" :min-width="643">
                    <x-slot:head>
                        <th style="width: 169px">Kode</th>
                        <th style="width: 180px">Status</th>
                        <th>Tgl Beli</th>
                        <th style="width: 133px"><span class="sr-only">Aksi</span></th>
                    </x-slot:head>

                    @forelse ($item as $i)
                        <tr>
                            <td>{{ $i->kode_buku }}</td>
                            <td>
                                <x-ui.badge :tone="$i->status_buku === \App\Models\ItemBuku::STATUS_TERSEDIA ? 'green' : 'brand'">
                                    {{ $i->status_buku }}
                                </x-ui.badge>
                            </td>
                            <td class="ui-table__muted">{{ tanggal($i->tanggal_pembelian) }}</td>
                            <td>
                                <x-ui.row-actions
                                    label="item {{ $i->kode_buku }}"
                                    edit-modal="ubah-item-buku-{{ $i->id_item_buku }}"
                                    delete-modal="hapus-item-buku-{{ $i->id_item_buku }}" />
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="ui-table__empty">Belum ada item buku yang terdaftar</td></tr>
                    @endforelse
                </x-ui.table>
            </div>
        </div>
    </div>

    <x-ui.modal name="kategori-buku" icon="book-bookmark" title="Buku {{ $buku->kategori->nama_kategori }}"
                :description="$buku->kategori->deskripsi_kategori ?: 'Belum ada deskripsi untuk kategori ini.'">
        <x-slot:footer>
            <x-ui.button block x-on:click="$dispatch('close-modal', 'kategori-buku')">Tutup</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>

    <x-ui.modal name="tambah-item-buku" icon="book-bookmark" title="Tambah Item Buku {{ $buku->judul_buku }}"
                description="Tambahkan setiap buku yang anda miliki"
                :action="route('admin.buku.item.store', $buku)">
        <x-buku.item-fields />

        <x-slot:footer>
            <x-ui.button block x-on:click="$dispatch('close-modal', 'tambah-item-buku')">Batal</x-ui.button>
            <x-ui.button block variant="primary" type="submit">Tambah</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>

    @foreach ($item as $i)
        <x-ui.modal name="ubah-item-buku-{{ $i->id_item_buku }}" icon="book-bookmark"
                    title="Edit Item Buku {{ $buku->judul_buku }}"
                    description="Edit buku yang anda miliki"
                    :action="route('admin.buku.item.update', [$buku, $i])" method="PUT">
            <x-buku.item-fields :item-buku="$i" />

            <x-slot:footer>
                <x-ui.button block x-on:click="$dispatch('close-modal', 'ubah-item-buku-{{ $i->id_item_buku }}')">Batal</x-ui.button>
                <x-ui.button block variant="primary" type="submit">Simpan</x-ui.button>
            </x-slot:footer>
        </x-ui.modal>

        <x-ui.confirm-delete
            name="hapus-item-buku-{{ $i->id_item_buku }}"
            title="Hapus buku {{ $i->kode_buku }} ini?"
            description="Jika anda menghapus, maka item buku tersebut akan
            permanen terhapus"
            :action="route('admin.buku.item.destroy', [$buku, $i])"
            :blocked-title="'Buku ' . $i->kode_buku . ' tidak dapat dihapus'"
            :blocker="$i->status_buku === \App\Models\ItemBuku::STATUS_DIPINJAM
                ? 'Item buku sedang dipinjam. Tunggu hingga dikembalikan.'
                : null" />
    @endforeach

    <x-ui.confirm-delete
        name="hapus-buku"
        title="Hapus detail buku ini?"
        description="Jika anda menghapus, maka item buku yang berkaitan
        dengan detail buku ini juga akan terhapus"
        :action="route('admin.buku.destroy', $buku)"
        blocked-title="Buku tidak dapat dihapus" />
</x-app-layout>
