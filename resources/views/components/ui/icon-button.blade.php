{{--
  Tombol ikon. Dua bentuk:
  - frame="false" (default): ikon polos, untuk aksi baris tabel (ubah / hapus)
  - frame="true": ikon di dalam bingkai tombol secondary (mis. tombol keluar di header)

  <x-ui.icon-button icon="pencil-simple" label="Ubah buku Bumi" href="{{ route('buku.edit', $buku) }}" />
  <x-ui.icon-button icon="sign-out" label="Keluar" frame x-on:click="$dispatch('open-modal', 'logout')" />

  label wajib: dipakai sebagai aria-label karena tombol tidak punya teks.
--}}
@props([
    'icon',
    'label',
    'href' => null,
    'frame' => false,
    'type' => 'button',
])

@php
    $classes = $frame ? 'ui-btn ui-btn--secondary ui-btn--icon' : 'ui-icon-btn';
@endphp

@if ($href)
    <a href="{{ $href }}" aria-label="{{ $label }}" title="{{ $label }}" {{ $attributes->merge(['class' => $classes]) }}>
        <img src="{{ asset('icons/' . $icon . '.svg') }}" alt="" width="20" height="20">
    </a>
@else
    <button type="{{ $type }}" aria-label="{{ $label }}" title="{{ $label }}" {{ $attributes->merge(['class' => $classes]) }}>
        <img src="{{ asset('icons/' . $icon . '.svg') }}" alt="" width="20" height="20">
    </button>
@endif
