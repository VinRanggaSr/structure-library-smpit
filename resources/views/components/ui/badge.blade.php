{{--
  Label status berbentuk pill.

  <x-ui.badge tone="green">Tersedia</x-ui.badge>
  <x-ui.badge tone="red">Terlambat</x-ui.badge>
  <x-ui.badge tone="brand">Dipinjam</x-ui.badge>
  <x-ui.badge tone="gray">Tidak Aktif</x-ui.badge>

  Pemetaan status di sistem:
  - green: Tersedia, Dikembalikan, Lunas, Aktif
  - red:   Terlambat, Belum Lunas
  - brand: Dipinjam, role pengguna
  - gray:  Tidak Aktif
--}}
@props(['tone' => 'brand'])

<span {{ $attributes->merge(['class' => 'ui-badge ui-badge--' . $tone]) }}>{{ $slot }}</span>
