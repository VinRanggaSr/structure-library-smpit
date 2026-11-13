{{--
  Sampul buku (Brand-Soft). Ukuran md (160x226) untuk kartu, lg (320x425) untuk halaman detail.

  <x-ui.book-cover :judul="$buku->judul_buku" :penulis="$buku->penulis_buku" />
  <x-ui.book-cover size="lg" :judul="$buku->judul_buku" :penulis="$buku->penulis_buku" />
--}}
@props(['judul', 'penulis', 'size' => 'md'])

<div {{ $attributes->merge(['class' => 'ui-book' . ($size === 'lg' ? ' ui-book--lg' : '')]) }}>
    <p class="ui-book__title">{{ $judul }}</p>
    <p class="ui-book__author">{{ $penulis }}</p>
</div>
