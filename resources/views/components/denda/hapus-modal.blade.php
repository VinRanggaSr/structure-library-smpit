@props(['denda'])

@php $nama = 'hapus-denda-' . $denda->id_denda; @endphp

<x-ui.modal :name="$nama" icon="trash-popup" tone="red"
            title="Hapus Denda {{ $denda->jenisDenda->nama_denda }}?"
            description="Jika anda menghapus denda {{ $denda->peminjaman->siswa->nama_siswa }} ini,
                         maka data denda ini akan hilang"
            :action="route('petugas.denda.destroy', $denda)" method="DELETE">
    <x-slot:footer>
        <x-ui.button block x-on:click="$dispatch('close-modal', '{{ $nama }}')">Batal</x-ui.button>
        <x-ui.button block variant="danger" type="submit">Ya, Hapus</x-ui.button>
    </x-slot:footer>
</x-ui.modal>
