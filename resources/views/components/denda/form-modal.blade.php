{{--
    Popup tambah/ubah denda. Dipakai halaman Denda dan halaman detail Peminjaman.
    Isi $peminjaman jika dibuka dari detail peminjaman: pilihan peminjamannya dikunci
    dan jenis + jumlah denda diisi awal dari keterlambatannya.
--}}
@props([
    'denda' => null,
    'jenisDenda',
    'peminjaman' => null,
    'pilihanPeminjaman' => null,
])

@php
    use App\Models\Denda;

    $nama = $denda ? 'ubah-denda-' . $denda->id_denda : 'tambah-denda';

    $pilihan = match (true) {
        (bool) $peminjaman => collect([$peminjaman]),
        (bool) $denda => collect($pilihanPeminjaman)->concat([$denda->peminjaman]),
        default => collect($pilihanPeminjaman),
    };

    $hariTerlambat = $peminjaman?->hari_terlambat ?? 0;
    $keterlambatan = $jenisDenda->firstWhere('nama_denda', 'Keterlambatan');

    $jenisAwal = $denda?->id_jenis_denda ?? ($hariTerlambat > 0 ? $keterlambatan?->id_jenis_denda : null);
    $jumlahAwal = $denda?->jumlah_denda ?? max(1, $hariTerlambat);
    $statusAwal = $denda?->status_denda ?? Denda::STATUS_BELUM_LUNAS;
@endphp

<x-ui.modal :name="$nama" icon="money-wavy"
            :title="$denda ? 'Ubah Denda ' . $denda->peminjaman->siswa->nama_siswa : 'Tambah Denda'"
            :description="$denda
                ? 'Perbarui jika ada perubahan terkait dengan denda'
                : 'Catat denda yang dikenakan pada peminjaman siswa'"
            :action="$denda ? route('petugas.denda.update', $denda) : route('petugas.denda.store')"
            :method="$denda ? 'PUT' : 'POST'">
    <x-ui.combobox label="Peminjaman" name="id_peminjaman"
                   :placeholder="$pilihan->isEmpty() ? 'Semua peminjaman sudah memiliki denda' : 'Cari siswa, buku, atau kode buku'"
                   empty="Peminjaman tidak ditemukan"
                   :value="$denda?->id_peminjaman ?? $peminjaman?->id_peminjaman"
                   :disabled="(bool) $peminjaman"
                   :options="$pilihan->map(fn ($p) => [
                       'value' => $p->id_peminjaman,
                       'label' => $p->siswa->nama_siswa . ' — ' . $p->itemBuku->buku->judul_buku,
                       'meta' => $p->itemBuku->kode_buku,
                   ])" />

    <x-ui.combobox label="Jenis Denda" name="id_jenis_denda" placeholder="Cari jenis denda"
                   empty="Jenis denda tidak ditemukan" :value="$jenisAwal"
                   :options="$jenisDenda->map(fn ($j) => [
                       'value' => $j->id_jenis_denda,
                       'label' => $j->nama_denda,
                       'meta' => rupiah($j->nominal_denda),
                   ])" />

    <x-ui.input label="Jumlah" name="jumlah_denda" type="number" inputmode="numeric" min="1" step="1"
                placeholder="Masukan jumlah denda" :value="$jumlahAwal"
                :hint="$denda ? rupiah($denda->jenisDenda->nominal_denda) . ' × jumlah' : null" />

    <div class="ui-field">
        <span class="ui-field__label">Total Denda</span>
        <div class="ui-control ui-control--static" aria-live="polite">{{ rupiah($denda?->total_denda ?? 0) }}</div>
    </div>

    <div x-data="{ status: @js($statusAwal) }" x-on:change="status = $event.detail ?? status" class="ui-passthrough">
        <x-ui.combobox label="Status" name="status_denda" placeholder="Pilih status denda" :value="$statusAwal"
                       :options="[
                           ['value' => Denda::STATUS_BELUM_LUNAS, 'label' => 'Belum Lunas'],
                           ['value' => Denda::STATUS_LUNAS, 'label' => 'Lunas'],
                       ]" />
        <template x-if="status === @js(Denda::STATUS_LUNAS)">
            <x-ui.date label="Tanggal Bayar" name="tanggal_bayar" :max="today()->toDateString()"
                       :value="$denda?->tanggal_bayar?->toDateString() ?? today()->toDateString()" />
        </template>
    </div>

    <x-slot:footer>
        <x-ui.button block x-on:click="$dispatch('close-modal', '{{ $nama }}')">Batal</x-ui.button>
        <x-ui.button block variant="primary" type="submit">{{ $denda ? 'Simpan' : 'Tambah' }}</x-ui.button>
    </x-slot:footer>
</x-ui.modal>
