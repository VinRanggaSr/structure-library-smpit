@props(['peminjaman'])

@php
    use App\Models\Peminjaman;

    $nama = 'hapus-peminjaman-' . $peminjaman->id_peminjaman;
    $masihDipinjam = $peminjaman->status_peminjaman === Peminjaman::STATUS_DIPINJAM;

    $alasan = collect([
        'Jika anda menghapus peminjaman “' . e($peminjaman->itemBuku->buku->judul_buku) . '”,',
        'maka data peminjaman ini akan hilang',
        $masihDipinjam ? 'dan buku ' . e($peminjaman->itemBuku->kode_buku) . ' kembali tersedia' : null,
        $peminjaman->denda ? '<span class="text-red">Denda terkait juga akan ikut terhapus.</span>' : null,
    ])->filter()->join('<br>');
@endphp

<x-ui.modal :name="$nama" icon="trash-popup" tone="red"
            title="Hapus Peminjaman {{ $peminjaman->siswa->nama_siswa }}?"
            :description="new \Illuminate\Support\HtmlString($alasan)"
            :action="route('petugas.peminjaman.destroy', $peminjaman)" method="DELETE">
    <x-slot:footer>
        <x-ui.button block x-on:click="$dispatch('close-modal', '{{ $nama }}')">Batal</x-ui.button>
        <x-ui.button block variant="danger" type="submit">Ya, Hapus</x-ui.button>
    </x-slot:footer>
</x-ui.modal>
