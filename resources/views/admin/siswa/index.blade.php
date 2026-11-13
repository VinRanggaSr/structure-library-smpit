<x-app-layout :nav="config('menu.superadmin')" title="Data Siswa">
    <x-ui.page-header title="Data Siswa">
        <x-ui.search placeholder="Cari data siswa..." />
        <x-ui.button x-data x-on:click="$dispatch('open-modal', 'impor-siswa')">Impor</x-ui.button>
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-modal', 'tambah-siswa')">
            Tambah Siswa
        </x-ui.button>
    </x-ui.page-header>

    <div class="ui-section">
        <x-ui.table caption="Daftar siswa" :paginator="$siswa">
            <x-slot:head>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Jenis Kelamin</th>
                <th>Status</th>
                <th style="width: 133px"><span class="sr-only">Aksi</span></th>
            </x-slot:head>

            @forelse ($siswa as $s)
                <tr>
                    <td>{{ $s->NISN_siswa }}</td>
                    <td>{{ $s->nama_siswa }}</td>
                    <td>{{ $s->jenis_kelamin_siswa }}</td>
                    <td>
                        <x-ui.badge :tone="$s->status_siswa === \App\Models\Siswa::STATUS_AKTIF ? 'green' : 'gray'">
                            {{ $s->status_siswa }}
                        </x-ui.badge>
                    </td>
                    <td>
                        <x-ui.row-actions
                            label="siswa {{ $s->nama_siswa }}"
                            edit-modal="ubah-siswa-{{ $s->id_siswa }}"
                            delete-modal="hapus-siswa-{{ $s->id_siswa }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="ui-table__empty">
                        {{ request('q') ? 'Tidak ada siswa yang cocok' : 'Belum ada data siswa' }}
                    </td>
                </tr>
            @endforelse
        </x-ui.table>
    </div>

    <x-ui.modal name="tambah-siswa" icon="user-circle" title="Tambah Data Siswa"
                description="Tambahkan semua data siswa dari sekolah anda"
                :action="route('admin.siswa.store')">
        <x-siswa.fields />

        <x-slot:footer>
            <x-ui.button block x-on:click="$dispatch('close-modal', 'tambah-siswa')">Batal</x-ui.button>
            <x-ui.button block variant="primary" type="submit">Tambah</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>

    <x-ui.modal name="impor-siswa" icon="user-circle" title="Impor Data Siswa"
                description="Gunakan file CSV dengan urutan kolom: NISN, Nama, Jenis Kelamin, Status"
                :action="route('admin.siswa.impor')">
        <div class="ui-field">
            <label for="berkas_siswa" class="ui-field__label">File CSV</label>
            <input id="berkas_siswa" name="berkas" type="file" accept=".csv,text/csv" class="ui-control ui-control--file">
            <p class="ui-field__hint">Contoh baris: 0081234567, Ahmad Fauzan, Laki-laki, Aktif</p>
        </div>

        <x-slot:footer>
            <x-ui.button block x-on:click="$dispatch('close-modal', 'impor-siswa')">Batal</x-ui.button>
            <x-ui.button block variant="primary" type="submit">Impor</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>

    @foreach ($siswa as $s)
        <x-ui.modal name="ubah-siswa-{{ $s->id_siswa }}" icon="user-circle"
                    title="Ubah Siswa {{ $s->nama_siswa }}"
                    description="Perbarui jika ada perubahan terkait dengan data siswa"
                    :action="route('admin.siswa.update', $s)" method="PUT">
            <x-siswa.fields :siswa="$s" />

            <x-slot:footer>
                <x-ui.button block x-on:click="$dispatch('close-modal', 'ubah-siswa-{{ $s->id_siswa }}')">Batal</x-ui.button>
                <x-ui.button block variant="primary" type="submit">Simpan</x-ui.button>
            </x-slot:footer>
        </x-ui.modal>

        <x-ui.confirm-delete
            name="hapus-siswa-{{ $s->id_siswa }}"
            title="Hapus Siswa {{ $s->nama_siswa }}?"
            description="Jika anda menghapus data siswa ini,
            maka data siswa ini akan hilang"
            :action="route('admin.siswa.destroy', $s)"
            :blocked-title="'Siswa ' . $s->nama_siswa . ' tidak dapat dihapus'"
            :blocker="$s->peminjaman_count
                ? 'Siswa ini memiliki riwayat peminjaman. Ubah statusnya menjadi Tidak Aktif sebagai gantinya.'
                : null" />
    @endforeach
</x-app-layout>
