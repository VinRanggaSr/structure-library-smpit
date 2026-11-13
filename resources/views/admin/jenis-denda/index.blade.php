<x-app-layout :nav="config('menu.superadmin')" title="Jenis Denda">
    <x-ui.page-header title="Jenis Denda">
        <x-ui.search placeholder="Cari data denda..." />
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-modal', 'tambah-jenis-denda')">
            Tambah Denda
        </x-ui.button>
    </x-ui.page-header>

    <div class="ui-section">
        <x-ui.table caption="Daftar jenis denda" :paginator="$jenisDenda">
            <x-slot:head>
                <th style="width: 318px">Nama Denda</th>
                <th style="width: 318px">Nominal Denda</th>
                <th>Keterangan</th>
                <th style="width: 133px"><span class="sr-only">Aksi</span></th>
            </x-slot:head>

            @forelse ($jenisDenda as $j)
                <tr>
                    <td>{{ $j->nama_denda }}</td>
                    <td>{{ rupiah($j->nominal_denda) }}</td>
                    <td class="ui-table__wrap">{{ $j->keterangan_denda }}</td>
                    <td>
                        <x-ui.row-actions
                            label="denda {{ $j->nama_denda }}"
                            edit-modal="ubah-jenis-denda-{{ $j->id_jenis_denda }}"
                            delete-modal="hapus-jenis-denda-{{ $j->id_jenis_denda }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="ui-table__empty">
                        {{ request('q') ? 'Tidak ada denda yang cocok' : 'Belum ada data denda' }}
                    </td>
                </tr>
            @endforelse
        </x-ui.table>
    </div>

    <x-ui.modal name="tambah-jenis-denda" icon="money-wavy" title="Tambah Jenis Denda"
                description="Tambahkan berbagai jenis denda yang berlaku"
                :action="route('admin.jenis-denda.store')">
        <x-jenis-denda.fields />

        <x-slot:footer>
            <x-ui.button block x-on:click="$dispatch('close-modal', 'tambah-jenis-denda')">Batal</x-ui.button>
            <x-ui.button block variant="primary" type="submit">Tambah</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>

    @foreach ($jenisDenda as $j)
        <x-ui.modal name="ubah-jenis-denda-{{ $j->id_jenis_denda }}" icon="money-wavy"
                    title="Ubah Denda {{ $j->nama_denda }}"
                    description="Perbarui jika ada perubahan terkait dengan denda"
                    :action="route('admin.jenis-denda.update', $j)" method="PUT">
            <x-jenis-denda.fields :jenis-denda="$j" />

            <x-slot:footer>
                <x-ui.button block x-on:click="$dispatch('close-modal', 'ubah-jenis-denda-{{ $j->id_jenis_denda }}')">Batal</x-ui.button>
                <x-ui.button block variant="primary" type="submit">Simpan</x-ui.button>
            </x-slot:footer>
        </x-ui.modal>

        <x-ui.confirm-delete
            name="hapus-jenis-denda-{{ $j->id_jenis_denda }}"
            title="Hapus Denda {{ $j->nama_denda }}?"
            description="Jika anda menghapus jenis denda ini,
            maka jenis denda ini akan hilang"
            :action="route('admin.jenis-denda.destroy', $j)"
            :blocked-title="'Denda ' . $j->nama_denda . ' tidak dapat dihapus'"
            :blocker="$j->denda_count
                ? 'Jenis denda ini dipakai oleh ' . $j->denda_count . ' data denda sehingga tidak dapat dihapus.'
                : null" />
    @endforeach
</x-app-layout>
