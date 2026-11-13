{{--
  Donut untuk komposisi (Ketepatan Pengembalian). Urutan segmen: hijau → ungu → merah,
  dengan celah putih 2px antar potongan dan legenda berisi angka + persen.

  <x-ui.donut-chart caption="tepat waktu" :segments="[
      ['label' => 'Kembali tepat waktu', 'value' => 184, 'color' => 'var(--chart-good)'],
      ['label' => 'Masih dipinjam',      'value' => 3,   'color' => 'var(--chart-series)'],
      ['label' => 'Terlambat',           'value' => 34,  'color' => 'var(--chart-critical)'],
  ]" />

  Persentase di tengah = segmen pertama.
--}}
@props(['segments' => [], 'caption' => ''])

@php
    $size = 168; $thick = 26; $r = ($size - $thick) / 2; $circ = 2 * M_PI * $r; $gap = 2;
    $total = collect($segments)->sum('value');
    $pct = fn ($v) => $total ? (int) round($v / $total * 100) : 0;
    $offset = 0;
@endphp

<div {{ $attributes }}>
    @if ($total === 0)
        <p class="t-12-regular text-gray" style="padding: 32px 0; text-align: center">Belum ada data pada periode ini</p>
    @else
        <div class="ui-donut">
            <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 {{ $size }} {{ $size }}" role="img"
                 aria-label="{{ collect($segments)->map(fn ($s) => $s['label'] . ' ' . $s['value'])->join(', ') }}">
                <g transform="rotate(-90 {{ $size / 2 }} {{ $size / 2 }})">
                    @foreach ($segments as $s)
                        @continue($s['value'] <= 0)
                        @php $len = $s['value'] / $total * $circ; $dash = max($len - $gap, 0.5); @endphp
                        <circle class="ui-donut__slice" cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $r }}"
                                fill="none" stroke="{{ $s['color'] }}" stroke-width="{{ $thick }}"
                                stroke-dasharray="{{ $dash }} {{ $circ - $dash }}" stroke-dashoffset="{{ -$offset }}">
                            <title>{{ $s['label'] }}: {{ $s['value'] }} ({{ $pct($s['value']) }}%)</title>
                        </circle>
                        @php $offset += $len; @endphp
                    @endforeach
                </g>
            </svg>
            <div class="ui-donut__center" aria-hidden="true">
                <span class="ui-donut__value">{{ $pct($segments[0]['value']) }}%</span>
                <span class="ui-donut__caption">{{ $caption }}</span>
            </div>
        </div>
    @endif

    <ul class="ui-legend">
        @foreach ($segments as $s)
            <li class="ui-legend__row">
                <span class="ui-legend__swatch" style="background: {{ $s['color'] }}" aria-hidden="true"></span>
                <span>{{ $s['label'] }}</span>
                <span class="ui-legend__value">{{ $s['value'] }}</span>
                <span class="ui-legend__pct">{{ $pct($s['value']) }}%</span>
            </li>
        @endforeach
    </ul>
</div>
