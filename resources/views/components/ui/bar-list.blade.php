{{--
  Peringkat horizontal: label di atas, bar tipis membulat, nilai di ujung bar.
  Dipakai untuk Buku Terpopuler, Peminjaman per Kategori, Jenis Denda Terbesar.

  <x-ui.bar-list :items="[
      ['label' => 'Laskar Pelangi', 'meta' => 'Andrea Hirata', 'value' => 36],
      ['label' => 'Bumi', 'meta' => 'Tere Liye', 'value' => 26],
  ]" />
  <x-ui.bar-list :items="$dendaPerJenis" format="rupiah" />

  format: number (default) | rupiah
--}}
@props(['items' => [], 'format' => 'number', 'empty' => 'Belum ada data'])

@php
    $fmt = fn ($n) => $format === 'rupiah'
        ? 'Rp' . number_format($n, 0, ',', '.')
        : number_format($n, 0, ',', '.');
    $max = collect($items)->max('value') ?: 0;
    // Room for the widest value label so it never overflows the card.
    $reserve = collect($items)->map(fn ($i) => mb_strlen($fmt($i['value'])))->max() * 7.5 + 12;
@endphp

@if ($max === 0)
    <p class="t-12-regular text-gray" style="padding: 32px 0; text-align: center">{{ $empty }}</p>
@else
    <ol {{ $attributes->merge(['class' => 'ui-bar-list']) }}>
        @foreach ($items as $item)
            <li class="ui-bar-list__row" title="{{ $item['label'] }}: {{ $fmt($item['value']) }}">
                <span class="ui-bar-list__label">
                    <span class="ui-bar-list__name">{{ $item['label'] }}</span>
                    @if (!empty($item['meta']))
                        <span class="ui-bar-list__meta">{{ $item['meta'] }}</span>
                    @endif
                </span>
                <span class="ui-bar-list__track">
                    <span class="ui-bar-list__fill"
                          style="width: calc((100% - {{ $reserve }}px) * {{ $item['value'] / $max }})"></span>
                    <span class="ui-bar-list__value">{{ $fmt($item['value']) }}</span>
                </span>
            </li>
        @endforeach
    </ol>
@endif
