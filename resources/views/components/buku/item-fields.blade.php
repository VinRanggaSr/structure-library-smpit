@props(['itemBuku' => null])

<x-ui.input label="Kode Buku" name="kode_buku" placeholder="Masukan kode buku" :value="$itemBuku?->kode_buku" />

@if ($itemBuku)
    {{-- Status eksemplar mengikuti data peminjaman, jadi tidak bisa diubah dari sini. --}}
    <x-ui.input label="Status" name="status_buku" :value="$itemBuku->status_buku" disabled
                hint="Status mengikuti data peminjaman" />
@endif

<x-ui.date label="Tanggal Pembelian" name="tanggal_pembelian"
           :value="$itemBuku?->tanggal_pembelian?->toDateString() ?? today()->toDateString()"
           :max="today()->toDateString()" />
