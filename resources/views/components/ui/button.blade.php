{{--
  Tombol standar.
  <x-ui.button variant="primary">Tambah Buku</x-ui.button>
  <x-ui.button href="{{ route('buku.create') }}" variant="primary">Tambah Buku</x-ui.button>
  <x-ui.button variant="danger" type="submit">Ya, Hapus</x-ui.button>

  variant: primary | secondary | danger   (default: secondary)
  block:   true agar tombol mengisi sisa lebar (dipakai berdua di footer popup)
  href:    jika diisi, dirender sebagai <a>
--}}
@props([
    'variant' => 'secondary',
    'block' => false,
    'href' => null,
    'type' => 'button',
])

@php
    $classes = 'ui-btn ui-btn--' . $variant . ($block ? ' ui-btn--block' : '');
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
