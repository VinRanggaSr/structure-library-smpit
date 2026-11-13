{{--
  Pemilih rentang tanggal untuk dashboard. Pilihan cepat berupa link (?start=&end=),
  rentang kustom berupa form GET. Alpine hanya untuk buka/tutup panel.

  <x-ui.date-range-picker :start="$start" :end="$end" :min="$awalData" :max="today()->toDateString()" :presets="[
      ['label' => '7 hari terakhir',  'start' => today()->subDays(6)->toDateString()],
      ['label' => '30 hari terakhir', 'start' => today()->subDays(29)->toDateString()],
      ['label' => 'Bulan ini',        'start' => today()->startOfMonth()->toDateString()],
      ['label' => '6 bulan terakhir', 'start' => today()->subMonths(5)->startOfMonth()->toDateString()],
  ]" />

  Controller:
      $start = $request->date('start') ?? today()->subMonths(5)->startOfMonth();
      $end   = $request->date('end') ?? today();
      $request->validate(['start' => 'nullable|date|before_or_equal:end', 'end' => 'nullable|date|before_or_equal:today']);
--}}
@props(['start', 'end', 'min' => null, 'max' => null, 'presets' => []])

@php
    $fmt = fn ($d) => \Illuminate\Support\Carbon::parse($d)->locale('id')->translatedFormat('d M Y');
    $end = \Illuminate\Support\Carbon::parse($end)->toDateString();
    $start = \Illuminate\Support\Carbon::parse($start)->toDateString();
@endphp

<div class="ui-range" x-data="{ open: false }" x-on:click.outside="open = false" x-on:keydown.escape="open = false">
    <button type="button" class="ui-range__trigger" x-on:click="open = !open" x-bind:aria-expanded="open"
            aria-label="Rentang waktu: {{ $fmt($start) }} sampai {{ $fmt($end) }}">
        {{ $fmt($start) }} – {{ $fmt($end) }}
        <img src="{{ asset('icons/caret-down.svg') }}" alt="" width="18" height="18"
             x-bind:style="open && 'transform: rotate(180deg)'">
    </button>

    <div class="ui-range__panel" x-show="open" x-cloak role="dialog" aria-label="Rentang waktu">
        <ul class="ui-range__presets">
            @foreach ($presets as $p)
                @php $active = $p['start'] === $start && ($p['end'] ?? $max) === $end; @endphp
                <li>
                    <a href="{{ request()->fullUrlWithQuery(['start' => $p['start'], 'end' => $p['end'] ?? $max]) }}"
                       class="ui-range__preset {{ $active ? 'ui-range__preset--active' : '' }}">
                        {{ $p['label'] }}
                        @if ($active)
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                <path d="M3 8.5l3.2 3.2L13 4.8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>

        <form method="GET" class="ui-range__custom">
            <p class="t-12-medium">Rentang kustom</p>
            <x-ui.field-row>
                <x-ui.date label="Dari" name="start" :value="$start" :min="$min" :max="$max" />
                <x-ui.date label="Sampai" name="end" :value="$end" :min="$min" :max="$max" />
            </x-ui.field-row>
            <x-ui.button variant="primary" type="submit">Terapkan</x-ui.button>
        </form>
    </div>
</div>
