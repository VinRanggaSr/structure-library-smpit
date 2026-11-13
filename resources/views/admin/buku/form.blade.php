@php
    $kembali = $buku ? route('admin.buku.show', $buku) : route('admin.buku.index');
@endphp

<x-app-layout :nav="config('menu.superadmin')" :title="$buku ? 'Ubah Buku' : 'Tambah Buku'">
    <div class="ui-form-page">
        <div class="ui-form-page__back">
            <x-ui.back-link :href="$kembali">
                {{ $buku ? 'Kembali ke Detail Buku' : 'Kembali ke Buku' }}
            </x-ui.back-link>
        </div>

        <h1 class="t-28-semibold">
            {{ $buku ? 'Edit Detail Informasi Buku Anda' : 'Tambahkan Informasi Detail Buku' }}
        </h1>

        <form method="POST" class="ui-form-page__card" novalidate
              action="{{ $buku ? route('admin.buku.update', $buku) : route('admin.buku.store') }}">
            @csrf
            @if ($buku)
                @method('PUT')
            @endif

            <div class="ui-form-page__fields">
                <x-ui.input label="Judul" name="judul_buku" placeholder="Masukan judul buku"
                            :value="$buku?->judul_buku" />

                <x-ui.field-row>
                    <x-ui.combobox label="Kategori" name="id_kategori" placeholder="Cari kategori buku"
                                   empty="Kategori tidak ditemukan" :value="$buku?->id_kategori"
                                   :options="$kategori->map(fn ($k) => [
                                       'value' => $k->id_kategori,
                                       'label' => $k->nama_kategori,
                                   ])" />
                    <x-ui.input label="Penulis" name="penulis_buku" placeholder="Masukan penulis"
                                :value="$buku?->penulis_buku" />
                </x-ui.field-row>

                <x-ui.field-row>
                    <x-ui.input label="Penerbit (opsional)" name="penerbit_buku" placeholder="Masukan penerbit buku"
                                :value="$buku?->penerbit_buku" />
                    <x-ui.input label="Tahun Terbit (opsional)" name="tahun_terbit_buku" inputmode="numeric"
                                maxlength="4" placeholder="Masukan tahun terbit buku"
                                :value="$buku?->tahun_terbit_buku" />
                </x-ui.field-row>
            </div>

            <div class="ui-form-page__footer">
                <x-ui.button :href="$kembali">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit">Simpan Perubahan</x-ui.button>
            </div>
        </form>
    </div>
</x-app-layout>
