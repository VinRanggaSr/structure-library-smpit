{{--
  Aksi di ujung kanan baris tabel: ikon ubah + ikon hapus.
  Hapus membuka popup konfirmasi lewat event Alpine (lihat <x-ui.confirm-delete>).

  <x-ui.row-actions
      label="kategori {{ $kategori->nama_kategori }}"
      :edit="route('kategori.edit', $kategori)"
      delete-modal="hapus-kategori-{{ $kategori->id_kategori }}" />
--}}
@props([
    'label',
    'edit' => null,
    'editModal' => null,
    'deleteModal' => null,
])

<div {{ $attributes->merge(['class' => 'ui-row-actions']) }}>
    @if ($editModal)
        <x-ui.icon-button icon="pencil-simple" :label="'Ubah ' . $label"
            x-data x-on:click.stop="$dispatch('open-modal', '{{ $editModal }}')" />
    @elseif ($edit)
        <x-ui.icon-button icon="pencil-simple" :label="'Ubah ' . $label" :href="$edit" />
    @endif
    @if ($deleteModal)
        <x-ui.icon-button icon="trash" :label="'Hapus ' . $label"
            x-data x-on:click.stop="$dispatch('open-modal', '{{ $deleteModal }}')" />
    @endif
</div>
