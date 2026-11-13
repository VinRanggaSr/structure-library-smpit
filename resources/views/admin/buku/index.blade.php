<x-app-layout :nav="config('menu.superadmin')" title="Buku">
    @php
        $kategoriTerpilih = request('kategori');
    @endphp

    <x-ui.page-header title="Buku">
        <x-ui.button x-data x-on:click="$dispatch('open-modal', 'impor-buku')">Impor</x-ui.button>
        <x-ui.button variant="primary" :href="route('admin.buku.create')">Tambah Buku</x-ui.button>
    </x-ui.page-header>

    <div class="ui-toolbar">
        <x-ui.tabs label="Filter kategori buku" :items="collect([[
            'label' => 'Semua',
            'href' => route('admin.buku.index', request()->except(['kategori', 'page'])),
            'active' => ! $kategoriTerpilih,
        ]])->concat($kategori->map(fn ($k) => [
            'label' => $k->nama_kategori,
            'href' => route('admin.buku.index', ['kategori' => $k->id_kategori] + request()->except('page')),
            'active' => (int) $kategoriTerpilih === $k->id_kategori,
        ]))" />
        <x-ui.search placeholder="Cari judul atau penulis..." />
    </div>

    <div class="ui-section">
        @if ($buku->isEmpty())
            <p class="ui-empty-card">
                {{ request('q') || $kategoriTerpilih ? 'Tidak ada buku yang cocok' : 'Belum ada data buku' }}
            </p>
        @else
            <div class="ui-book-grid">
                @foreach ($buku as $b)
                    <x-ui.book-card :buku="$b" :href="route('admin.buku.show', $b)" />
                @endforeach
            </div>
        @endif
    </div>

    <x-ui.modal name="impor-buku" icon="book-bookmark" title="Impor Data Buku"
                description="Gunakan file CSV dengan urutan kolom: Judul, Penulis, Penerbit, Tahun Terbit, Kategori"
                :action="route('admin.buku.store')">
        <div class="ui-field">
            <label for="berkas_buku" class="ui-field__label">File CSV</label>
            <input id="berkas_buku" name="berkas" type="file" accept=".csv,text/csv" class="ui-control ui-control--file">
            <p class="ui-field__hint">Contoh baris: Laskar Pelangi, Andrea Hirata, Bentang Pustaka, 2005, Fiksi</p>
        </div>

        <x-slot:footer>
            <x-ui.button block x-on:click="$dispatch('close-modal', 'impor-buku')">Batal</x-ui.button>
            <x-ui.button block variant="primary" type="submit">Impor</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>
</x-app-layout>
