<x-app-layout :nav="config('menu.superadmin')" title="Aturan Perpustakaan">
    <x-ui.page-header title="Aturan Perpustakaan">
        <x-ui.search placeholder="Cari aturan..." />
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-modal', 'tambah-aturan')">
            Tambah Aturan
        </x-ui.button>
    </x-ui.page-header>

    <div class="ui-section">
        <x-ui.table caption="Daftar aturan" :paginator="$aturan">
            <x-slot:head>
                <th style="width: 300px">Nama Aturan</th>
                <th>Deskripsi</th>
                <th style="width: 133px"><span class="sr-only">Aksi</span></th>
            </x-slot:head>

            @forelse ($aturan as $a)
                <tr>
                    <td>{{ $a->judul_aturan }}</td>
                    <td class="ui-table__wrap">{{ $a->deskripsi_aturan }}</td>
                    <td>
                        <x-ui.row-actions
                            label="aturan {{ $a->judul_aturan }}"
                            edit-modal="ubah-aturan-{{ $a->id_aturan }}"
                            delete-modal="hapus-aturan-{{ $a->id_aturan }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="ui-table__empty">
                        {{ request('q') ? 'Tidak ada aturan yang cocok' : 'Belum ada data aturan' }}
                    </td>
                </tr>
            @endforelse
        </x-ui.table>
    </div>

    <x-ui.modal name="tambah-aturan" icon="warning-octagon" title="Tambah Aturan Perpustakaan"
                description="Tambahkan aturan perpustakaan sehingga dapat dikomunikasikan oleh petugas perpustakaan"
                :action="route('admin.aturan.store')">
        <x-aturan.fields />

        <x-slot:footer>
            <x-ui.button block x-on:click="$dispatch('close-modal', 'tambah-aturan')">Batal</x-ui.button>
            <x-ui.button block variant="primary" type="submit">Tambah</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>

    @foreach ($aturan as $a)
        <x-ui.modal name="ubah-aturan-{{ $a->id_aturan }}" icon="warning-octagon"
                    title="Ubah Aturan {{ $a->judul_aturan }}"
                    description="Perbarui jika ada perubahan terkait dengan aturan"
                    :action="route('admin.aturan.update', $a)" method="PUT">
            <x-aturan.fields :aturan="$a" />

            <x-slot:footer>
                <x-ui.button block x-on:click="$dispatch('close-modal', 'ubah-aturan-{{ $a->id_aturan }}')">Batal</x-ui.button>
                <x-ui.button block variant="primary" type="submit">Simpan</x-ui.button>
            </x-slot:footer>
        </x-ui.modal>

        <x-ui.confirm-delete
            name="hapus-aturan-{{ $a->id_aturan }}"
            title="Hapus Aturan {{ $a->judul_aturan }}?"
            description="Jika anda menghapus aturan ini,
            maka aturan ini tidak lagi ditampilkan ke petugas"
            :action="route('admin.aturan.destroy', $a)" />
    @endforeach
</x-app-layout>
