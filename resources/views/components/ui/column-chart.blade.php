{{--
  Grafik kolom (tren peminjaman). Murni HTML/CSS: responsif tanpa JavaScript,
  tooltip muncul saat hover/fokus, nilai periode terakhir ditulis di atas kolom.

  <x-ui.column-chart :items="[
      ['tick' => 'Mei', 'label' => 'Mei 2026', 'value' => 41],
      ['tick' => 'Jun', 'label' => 'Juni 2026', 'value' => 28],
      ['tick' => 'Okt', 'label' => 'Oktober 2026 (sebagian)', 'value' => 35],
  ]" />
--}}
@props(['items' => []])

@php
    $max = max(collect($items)->max('value') ?? 0, 1);
    // Clean round ticks (0 / 20 / 40 / 60) covering the max.
    $raw = $max / 4;
    $pow = 10 ** floor(log10($raw));
    $step = collect([1, 2, 2.5, 5, 10])->map(fn ($m) => $m * $pow)->first(fn ($s) => $s >= $raw) ?? $raw;
    $top = ceil($max / $step) * $step;
    $ticks = range(0, $top, $step);
    $last = count($items) - 1;
@endphp

<div {{ $attributes->merge(['class' => 'ui-columns']) }} role="img"
     aria-label="{{ collect($items)->map(fn ($i) => $i['label'] . ' ' . $i['value'])->join(', ') }}">
    <div class="ui-columns__axis">
        @foreach ($ticks as $t)
            <span class="ui-columns__tick" style="bottom: {{ $t / $top * 100 }}%">{{ $t }}</span>
        @endforeach
    </div>

    <div class="ui-columns__plot">
        @foreach ($ticks as $t)
            <span class="ui-columns__grid" style="bottom: {{ $t / $top * 100 }}%"></span>
        @endforeach
        @foreach ($items as $i => $item)
            <div class="ui-columns__col" tabindex="0"
                 style="--h: {{ $item['value'] / $top * 100 }}%"
                 data-tooltip="{{ $item['label'] }}: {{ $item['value'] }}">
                <span class="ui-columns__bar"></span>
                @if ($i === $last)
                    <span class="ui-columns__label">{{ $item['value'] }}</span>
                @endif
            </div>
        @endforeach
    </div>

    <span></span>
    <div class="ui-columns__x">
        @foreach ($items as $item)
            <span>{{ $item['tick'] }}</span>
        @endforeach
    </div>
</div>
