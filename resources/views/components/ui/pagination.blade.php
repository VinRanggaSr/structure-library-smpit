{{--
  Catatan ikon: arrow-right.svg gambarnya menghadap kiri, jadi panah "berikutnya" diputar 180° lewat kelas ui-pagination__next.

  Paginasi tabel: "Menampilkan 1–15 dari 450" + tombol halaman. Tampil otomatis hanya jika
  datanya lebih dari 15 (satu halaman = tidak ada footer). Dipakai di dalam <x-ui.table>.

  <x-ui.pagination :paginator="$siswa" />

  Controller (maksimal 15 baris per halaman, filter/search ikut terbawa):
      $siswa = Siswa::query()->when($request->q, ...)->paginate(15)->withQueryString();
--}}
@props(['paginator'])

@if ($paginator->hasPages())
    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        // Selalu tampil halaman 1, terakhir, dan tetangga halaman aktif; celah jadi "…"
        $keep = collect([1, $last, $current - 1, $current, $current + 1])->filter(fn ($p) => $p >= 1 && $p <= $last)->unique()->sort()->values();
    @endphp

    <nav class="ui-pagination" aria-label="Halaman data">
        <p class="ui-pagination__range">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }}
        </p>
        <div class="ui-pagination__pages">
            <a class="ui-pagination__btn" @if ($paginator->onFirstPage()) aria-disabled="true" @else href="{{ $paginator->previousPageUrl() }}" @endif aria-label="Halaman sebelumnya">
                <img src="{{ asset('icons/arrow-right.svg') }}" alt="" width="14" height="14">
            </a>

            @foreach ($keep as $i => $page)
                @if ($i > 0 && $page - $keep[$i - 1] > 1)
                    <span class="ui-pagination__gap" aria-hidden="true">…</span>
                @endif
                <a href="{{ $paginator->url($page) }}"
                   class="ui-pagination__btn {{ $page === $current ? 'ui-pagination__btn--active' : '' }}"
                   aria-label="Halaman {{ $page }}" @if ($page === $current) aria-current="page" @endif>{{ $page }}</a>
            @endforeach

            <a class="ui-pagination__btn" @if (! $paginator->hasMorePages()) aria-disabled="true" @else href="{{ $paginator->nextPageUrl() }}" @endif aria-label="Halaman berikutnya">
                <img src="{{ asset('icons/arrow-right.svg') }}" alt="" width="14" height="14" class="ui-pagination__next">
            </a>
        </div>
    </nav>
@endif
