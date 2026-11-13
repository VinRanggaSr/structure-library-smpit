<x-app-layout :nav="config('menu.superadmin')" title="Akun Pengguna">
    <x-ui.page-header title="Akun Pengguna">
        <x-ui.search placeholder="Cari data pengguna..." />
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-modal', 'tambah-pengguna')">
            Tambah Pengguna
        </x-ui.button>
    </x-ui.page-header>

    <div class="ui-section">
        <x-ui.table caption="Daftar pengguna" :paginator="$pengguna">
            <x-slot:head>
                <th>Nama Pengguna</th>
                <th>Username</th>
                <th>Password</th>
                <th>Role</th>
                <th style="width: 133px"><span class="sr-only">Aksi</span></th>
            </x-slot:head>

            @forelse ($pengguna as $u)
                <tr>
                    <td>{{ $u->nama_pengguna }}</td>
                    <td>{{ $u->username_pengguna }}</td>
                    {{-- Ditampilkan apa adanya supaya admin bisa membacakannya ke pemilik akun. --}}
                    <td>{{ $u->password_pengguna }}</td>
                    <td><x-ui.badge tone="brand">{{ $u->role_pengguna }}</x-ui.badge></td>
                    <td>
                        <x-ui.row-actions
                            label="pengguna {{ $u->nama_pengguna }}"
                            edit-modal="ubah-pengguna-{{ $u->id_pengguna }}"
                            delete-modal="hapus-pengguna-{{ $u->id_pengguna }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="ui-table__empty">
                        {{ request('q') ? 'Tidak ada pengguna yang cocok' : 'Belum ada data pengguna' }}
                    </td>
                </tr>
            @endforelse
        </x-ui.table>
    </div>

    <x-ui.modal name="tambah-pengguna" icon="user-circle" title="Tambah Pengguna"
                description="Tambahkan akun dari pengguna yang menggunakan sistem perpustakaan ini"
                :action="route('admin.pengguna.store')">
        <x-pengguna.fields />

        <x-slot:footer>
            <x-ui.button block x-on:click="$dispatch('close-modal', 'tambah-pengguna')">Batal</x-ui.button>
            <x-ui.button block variant="primary" type="submit">Tambah</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>

    @foreach ($pengguna as $u)
        <x-ui.modal name="ubah-pengguna-{{ $u->id_pengguna }}" icon="user-circle"
                    title="Ubah Pengguna {{ $u->nama_pengguna }}"
                    description="Perbarui jika ada perubahan terkait dengan akun pengguna"
                    :action="route('admin.pengguna.update', $u)" method="PUT">
            <x-pengguna.fields :pengguna="$u" />

            <x-slot:footer>
                <x-ui.button block x-on:click="$dispatch('close-modal', 'ubah-pengguna-{{ $u->id_pengguna }}')">Batal</x-ui.button>
                <x-ui.button block variant="primary" type="submit">Simpan</x-ui.button>
            </x-slot:footer>
        </x-ui.modal>

        @php
            $akunSendiri = $u->id_pengguna === auth()->id();
        @endphp

        <x-ui.confirm-delete
            name="hapus-pengguna-{{ $u->id_pengguna }}"
            title="Hapus Pengguna {{ $u->nama_pengguna }}?"
            description="Jika anda menghapus akun ini,
            maka pengguna tidak dapat lagi masuk ke sistem"
            :action="route('admin.pengguna.destroy', $u)"
            :blocked-title="'Pengguna ' . $u->nama_pengguna . ' tidak dapat dihapus'"
            :blocker="match (true) {
                $akunSendiri => 'Anda tidak dapat menghapus akun yang sedang digunakan.',
                (bool) $u->peminjaman_count => 'Pengguna ini pernah mencatat peminjaman sehingga tidak dapat dihapus.',
                default => null,
            }" />
    @endforeach
</x-app-layout>
