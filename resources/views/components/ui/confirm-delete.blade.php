{{--
  Popup konfirmasi hapus (ikon trash merah, tombol "Ya, Hapus").
  Jika data masih dipakai relasi (FK), isi :blocker dengan alasannya:
  popup berubah jadi pemberitahuan dengan satu tombol "Tutup".

  <x-ui.confirm-delete
      name="hapus-kategori-{{ $kategori->id_kategori }}"
      title="Hapus Kategori {{ $kategori->nama_kategori }}?"
      description="Jika anda menghapus kategori ini, maka kategori ini akan hilang"
      :action="route('kategori.destroy', $kategori)"
      :blocker="$kategori->buku()->exists() ? 'Masih ada buku dalam kategori ini.' : null" />

  Contoh pemicu: <x-ui.row-actions ... delete-modal="hapus-kategori-{{ $kategori->id_kategori }}" />
--}}
@props([
    'name',
    'title',
    'description' => null,
    'action',
    'blocker' => null,
    'blockedTitle' => 'Data tidak dapat dihapus',
])

@php
    // Alasan terkunci ditulis merah, deskripsi biasa tetap abu-abu.
    $pesan = $blocker
        ? new \Illuminate\Support\HtmlString('<span class="text-red">' . e($blocker) . '</span>')
        : $description;
@endphp

<x-ui.modal :name="$name" icon="trash-popup" tone="red"
            :title="$blocker ? $blockedTitle : $title"
            :description="$pesan"
            :action="$blocker ? null : $action"
            method="DELETE">
    <x-slot:footer>
        @if ($blocker)
            <x-ui.button block x-on:click="$dispatch('close-modal', '{{ $name }}')">Tutup</x-ui.button>
        @else
            <x-ui.button block x-on:click="$dispatch('close-modal', '{{ $name }}')">Batal</x-ui.button>
            <x-ui.button block variant="danger" type="submit">Ya, Hapus</x-ui.button>
        @endif
    </x-slot:footer>
</x-ui.modal>
