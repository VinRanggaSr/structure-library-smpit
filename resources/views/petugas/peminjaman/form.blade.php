@php
    use App\Models\Peminjaman;

    $kembali = $peminjaman
        ? route('petugas.peminjaman.show', $peminjaman)
        : route('petugas.peminjaman.index');

    $jenis = old('jenis_peminjaman', $peminjaman?->jenis_peminjaman ?? Peminjaman::JENIS_HARIAN);
    $tanggalPinjam = $peminjaman?->tanggal_peminjaman?->toDateString() ?? today()->toDateString();

    // Batas pinjaman harian 7 hari; buku pelajaran dipinjam sampai akhir semester.
    $harusKembali = $peminjaman?->tanggal_harus_kembali?->toDateString()
        ?? ($jenis === Peminjaman::JENIS_SEMESTER
            ? (today()->month <= 6 ? today()->year . '-06-30' : today()->year . '-12-31')
            : today()->addDays(7)->toDateString());
@endphp

<x-app-layout :nav="config('menu.penjaga')" :title="$peminjaman ? 'Ubah Peminjaman' : 'Catat Peminjaman'">
    <div class="ui-form-page">
        <div class="ui-form-page__back">
            <x-ui.back-link :href="$kembali">
                {{ $peminjaman ? 'Kembali ke Detail Peminjaman' : 'Kembali ke Peminjaman' }}
            </x-ui.back-link>
        </div>

        <h1 class="t-28-semibold">
            {{ $peminjaman ? 'Edit Detail Peminjaman' : 'Catat Peminjaman Buku Baru' }}
        </h1>

        <form method="POST" class="ui-form-page__card" novalidate
              action="{{ $peminjaman ? route('petugas.peminjaman.update', $peminjaman) : route('petugas.peminjaman.store') }}">
            @csrf
            @if ($peminjaman)
                @method('PUT')
            @endif

            <div class="ui-form-page__fields">
                <x-ui.combobox label="Siswa" name="id_siswa" placeholder="Cari nama atau NISN siswa"
                               empty="Siswa tidak ditemukan" :value="$peminjaman?->id_siswa"
                               :options="$siswa->map(fn ($s) => [
                                   'value' => $s->id_siswa,
                                   'label' => $s->nama_siswa,
                                   'meta' => $s->NISN_siswa,
                               ])" />

                <x-ui.field-row>
                    <x-ui.combobox label="Buku" name="id_item_buku"
                                   :placeholder="$itemTersedia->isEmpty() ? 'Tidak ada buku yang tersedia' : 'Cari judul, penulis, atau kode buku'"
                                   empty="Buku tidak ditemukan atau sedang dipinjam"
                                   :value="$peminjaman?->id_item_buku"
                                   :options="$itemTersedia->map(fn ($i) => [
                                       'value' => $i->id_item_buku,
                                       'label' => $i->buku->judul_buku,
                                       'meta' => $i->kode_buku,
                                       'keywords' => $i->buku->penulis_buku,
                                   ])" />
                    <x-ui.combobox label="Jenis Peminjaman" name="jenis_peminjaman"
                                   placeholder="Pilih jenis peminjaman" :value="$jenis"
                                   :options="[
                                       ['value' => Peminjaman::JENIS_HARIAN, 'label' => 'Harian'],
                                       ['value' => Peminjaman::JENIS_SEMESTER, 'label' => 'Buku Pelajaran (Semester)'],
                                   ]" />
                </x-ui.field-row>

                <x-ui.field-row>
                    <x-ui.date label="Tanggal Pinjam" name="tanggal_peminjaman" :value="$tanggalPinjam" />
                    <x-ui.date label="Tanggal Harus Kembali" name="tanggal_harus_kembali" :value="$harusKembali"
                               :min="$tanggalPinjam"
                               :hint="$jenis === Peminjaman::JENIS_SEMESTER
                                   ? 'Otomatis diisi akhir semester'
                                   : 'Otomatis diisi 7 hari setelah tanggal pinjam'" />
                </x-ui.field-row>

                @if ($peminjaman)
                    <x-ui.field-row :x-data="json_encode(['status' => $peminjaman->status_peminjaman])"
                                    x-on:change="status = $event.detail ?? status">
                        <x-ui.combobox label="Status" name="status_peminjaman" placeholder="Pilih status peminjaman"
                                       :value="$peminjaman->status_peminjaman"
                                       :options="[
                                           ['value' => Peminjaman::STATUS_DIPINJAM, 'label' => 'Dipinjam'],
                                           ['value' => Peminjaman::STATUS_DIKEMBALIKAN, 'label' => 'Dikembalikan'],
                                       ]" />
                        <div class="ui-form-page__spacer">
                            <template x-if="status === @js(Peminjaman::STATUS_DIKEMBALIKAN)">
                                <x-ui.date label="Tanggal Kembali" name="tanggal_kembali" :min="$tanggalPinjam"
                                           :value="$peminjaman->tanggal_kembali?->toDateString() ?? today()->toDateString()" />
                            </template>
                        </div>
                    </x-ui.field-row>
                @endif
            </div>

            <div class="ui-form-page__footer">
                <x-ui.button :href="$kembali">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit">
                    {{ $peminjaman ? 'Simpan Perubahan' : 'Catat Peminjaman' }}
                </x-ui.button>
            </div>
        </form>

        <x-peminjaman.aturan :aturan="$aturan" />
    </div>
</x-app-layout>
