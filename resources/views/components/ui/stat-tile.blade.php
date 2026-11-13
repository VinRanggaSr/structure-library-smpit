{{--
  Angka ringkasan dashboard: label · nilai · perubahan vs periode sebelumnya / keterangan.

  <x-ui.stat-tile label="Total peminjaman" :value="number_format($total, 0, ',', '.')"
                  :delta="$deltaPersen" good-when-up versus="vs 184 hari sebelumnya" />
  <x-ui.stat-tile label="Denda tercatat" value="Rp213.000" :delta="-26" versus="vs 184 hari sebelumnya" />
  <x-ui.stat-tile label="Rata-rata lama pinjam" value="5,6 hari" sub="Batas pinjaman harian 7 hari" />

  delta:       angka persen (boleh negatif). null = "Belum ada data pembanding". Tidak diisi = tidak tampil.
  goodWhenUp:  true jika kenaikan itu baik (peminjaman). Denda: biarkan false (turun = baik).
  Warna: hijau = kabar baik, merah = kabar buruk, abu-abu = tetap.
--}}
@props([
    'label',
    'value',
    'sub' => null,
    'delta' => 'none',
    'goodWhenUp' => false,
    'versus' => 'vs periode sebelumnya',
])

<div {{ $attributes->merge(['class' => 'ui-tile']) }}>
    <span class="ui-tile__label">{{ $label }}</span>
    <span class="ui-tile__value">{{ $value }}</span>

    @if ($delta !== 'none')
        @if ($delta === null)
            <span class="ui-tile__delta ui-tile__delta--neutral">Belum ada data pembanding</span>
        @else
            @php
                $up = $delta > 0;
                $tone = $delta == 0 ? 'neutral' : (($up === (bool) $goodWhenUp) ? 'good' : 'bad');
            @endphp
            <span class="ui-tile__delta ui-tile__delta--{{ $tone }}">
                <span aria-hidden="true">{{ $delta == 0 ? '■' : ($up ? '▲' : '▼') }}</span>
                {{ $up ? '+' : '' }}{{ $delta }}%
                <span class="ui-tile__versus">{{ $versus }}</span>
            </span>
        @endif
    @endif

    @if ($sub)
        <span class="ui-tile__sub">{{ $sub }}</span>
    @endif
</div>
