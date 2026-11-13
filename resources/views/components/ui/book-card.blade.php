{{--
  Kartu buku di halaman daftar Buku. Bungkus beberapa kartu dengan <div class="ui-book-grid">.

  <div class="ui-book-grid">
      @foreach ($buku as $b)
          <x-ui.book-card :buku="$b" :href="route('admin.buku.show', $b)" />
      @endforeach
  </div>

  Butuh: $b->judul_buku, penulis_buku, tahun_terbit_buku, serta jumlah item_buku
  (tersedia / total) -> gunakan withCount di query:
      Buku::withCount(['itemBuku', 'itemBuku as tersedia_count' => fn ($q) => $q->where('status_buku', 'Tersedia')])
--}}
@props(['buku', 'href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'ui-book-card']) }} aria-label="Lihat detail {{ $buku->judul_buku }}">
    <div class="ui-book-card__meta">
        <span>Tersedia {{ $buku->tersedia_count }} dari {{ $buku->item_buku_count }}</span>
        <span>{{ $buku->tahun_terbit_buku ?: '-' }}</span>
    </div>
    <div class="ui-book-card__cover">
        <x-ui.book-cover :judul="$buku->judul_buku" :penulis="$buku->penulis_buku" />
    </div>
    <span class="t-12-medium">Lihat detail</span>
</a>
