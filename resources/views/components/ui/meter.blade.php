{{--
  Rasio terhadap batas (mis. denda sudah dibayar). Track = tingkatan lebih muda dari warna isinya.

  <x-ui.meter label="Sudah dibayar" :value="185000" :max="213000" tone="good"
              detail="Rp185.000 dari Rp213.000" />

  tone: series (ungu, default) | good (hijau)
--}}
@props(['label', 'value', 'max', 'detail' => null, 'tone' => 'series'])

@php
    $ratio = $max > 0 ? min(1, $value / $max) : 0;
    $percent = (int) round($ratio * 100);
@endphp

<div {{ $attributes->merge(['class' => 'ui-meter' . ($tone === 'good' ? ' ui-meter--good' : '')]) }}>
    <div class="ui-meter__head">
        <span class="ui-meter__label">{{ $label }}</span>
        <span class="ui-meter__value">{{ $percent }}%</span>
    </div>
    <div class="ui-meter__track" role="meter" aria-label="{{ $label }}"
         aria-valuemin="0" aria-valuemax="{{ $max }}" aria-valuenow="{{ $value }}">
        <span class="ui-meter__fill" style="width: {{ $ratio * 100 }}%"></span>
    </div>
    @if ($detail)
        <span class="ui-meter__detail">{{ $detail }}</span>
    @endif
</div>
