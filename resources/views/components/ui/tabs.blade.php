{{--
  Tab segmented untuk filter (server-side, berupa link).

  <x-ui.tabs label="Filter status peminjaman" :items="[
      ['label' => 'Semua', 'href' => route('peminjaman.index'), 'active' => !request('status'), 'count' => $total],
      ['label' => 'Dipinjam', 'href' => route('peminjaman.index', ['status' => 'dipinjam']), 'active' => request('status') === 'dipinjam', 'count' => $dipinjam],
  ]" />

  count opsional.
--}}
@props([
    'items' => [],
    'label' => 'Filter',
])

<nav {{ $attributes->merge(['class' => 'ui-tabs']) }} aria-label="{{ $label }}">
    @foreach ($items as $item)
        <a href="{{ $item['href'] }}"
           class="ui-tabs__item {{ ($item['active'] ?? false) ? 'ui-tabs__item--active' : '' }}"
           @if ($item['active'] ?? false) aria-current="page" @endif>
            {{ $item['label'] }}
            @isset($item['count'])
                <span class="ui-tabs__count">{{ $item['count'] }}</span>
            @endisset
        </a>
    @endforeach
</nav>
