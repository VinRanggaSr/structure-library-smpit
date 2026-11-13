{{--
  <x-ui.back-link :href="route('buku.index')">Kembali ke Buku</x-ui.back-link>
--}}
@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'ui-back-link']) }}>
    <img src="{{ asset('icons/arrow-left.svg') }}" alt="" width="14" height="14">
    {{ $slot }}
</a>
