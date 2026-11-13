<x-app-layout :nav="config('menu.superadmin')" title="Kategori Buku">
    <x-ui.page-header title="Kategori Buku">
        <x-ui.search placeholder="Cari nama kategori..." />
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-modal', 'tambah-kategori')">
            Tambah Kategori
        </x-ui.button>
    </x-ui.page-header>

    <div class="ui-section">
        <x-ui.table caption="Daftar kategori" :paginator="$kategori">
            <x-slot:head>
                <th style="width: 300px">Nama Kategori</th>
                <th>Deskripsi</th>
                <th style="width: 133px"><span class="sr-only">Aksi</span></th>
            </x-slot:head>

            @forelse ($kategori as $k)
                <tr>
                    <td>{{ $k->nama_kategori }}</td>
                    <td class="ui-table__wrap">{{ $k->deskripsi_kategori }}</td>
                    <td>
                        <x-ui.row-actions
                            label="kategori {{ $k->nama_kategori }}"
                            edit-modal="ubah-kategori-{{ $k->id_kategori }}"
                            delete-modal="hapus-kategori-{{ $k->id_kategori }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="ui-table__empty">
                        {{ request('q') ? 'Tidak ada kategori yang cocok' : 'Belum ada data kategori' }}
                    </td>
                </tr>
            @endforelse
        </x-ui.table>
    </div>

    <x-ui.modal name="tambah-kategori" icon="book-bookmark" title="Tambah Kategori Buku"
                description="Tambahkan setiap kategori dari buku yang anda miliki sehingga semua buku anda dapat terorganisir dengan baik"
                :action="route('admin.kategori.store')">
        <x-kategori.fields />

        <x-slot:footer>
            <x-ui.button block x-on:click="$dispatch('close-modal', 'tambah-kategori')">Batal</x-ui.button>
            <x-ui.button block variant="primary" type="submit">Tambah</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>

    @foreach ($kategori as $k)
        <x-ui.modal name="ubah-kategori-{{ $k->id_kategori }}" icon="book-bookmark"
                    title="Ubah Kategori {{ $k->nama_kategori }}"
                    description="Perbarui jika ada perubahan terkait dengan kategori"
                    :action="route('admin.kategori.update', $k)" method="PUT">
            <x-kategori.fields :kategori="$k" />

            <x-slot:footer>
                <x-ui.button block x-on:click="$dispatch('close-modal', 'ubah-kategori-{{ $k->id_kategori }}')">Batal</x-ui.button>
                <x-ui.button block variant="primary" type="submit">Simpan</x-ui.button>
            </x-slot:footer>
        </x-ui.modal>

        <x-ui.confirm-delete
            name="hapus-kategori-{{ $k->id_kategori }}"
            title="Hapus Kategori {{ $k->nama_kategori }}?"
            description="Jika anda menghapus kategori ini,
            maka kategori ini akan hilang"
            :action="route('admin.kategori.destroy', $k)"
            :blocked-title="'Kategori ' . $k->nama_kategori . ' tidak dapat dihapus'"
            :blocker="$k->buku_count
                ? 'Masih ada ' . $k->buku_count . ' buku dalam kategori ini. Pindahkan atau hapus bukunya terlebih dahulu.'
                : null" />
    @endforeach
</x-app-layout>
