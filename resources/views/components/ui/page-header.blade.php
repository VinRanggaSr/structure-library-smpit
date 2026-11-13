{{--
  Judul halaman (30/SemiBold) dengan area aksi di kanan.

  <x-ui.page-header title="Buku">
      <x-ui.button>Impor</x-ui.button>
      <x-ui.button variant="primary" :href="route('buku.create')">Tambah Buku</x-ui.button>
  </x-ui.page-header>
--}}
@props(['title'])

<div {{ $attributes->merge(['class' => 'ui-page-header']) }}>
    <h1 class="t-30-semibold">{{ $title }}</h1>
    @if ($slot->isNotEmpty())
        <div class="ui-actions">{{ $slot }}</div>
    @endif
</div>
