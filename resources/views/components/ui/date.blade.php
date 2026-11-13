{{--
  Input tanggal (native) bergaya design system: nilai + ikon CaretDown.
  Seluruh kotak membuka kalender bawaan browser.

  <x-ui.date label="Tanggal Pinjam" name="tanggal_peminjaman" :value="now()->toDateString()" />
  <x-ui.date label="Tanggal Harus Kembali" name="tanggal_harus_kembali" :min="$pinjam->tanggal_peminjaman" />
--}}
@props([
    'label',
    'name',
    'value' => null,
    'hint' => null,
])

@php
    $id = $attributes->get('id', $name);
    $error = $errors->first($name);
@endphp

<div class="ui-field">
    <label for="{{ $id }}" class="ui-field__label">{{ $label }}</label>
    <div class="ui-control-wrap">
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="date"
            value="{{ old($name, $value) }}"
            @if ($error) aria-invalid="true" @endif
            @if ($error || $hint) aria-describedby="{{ $id }}-msg" @endif
            {{ $attributes->except('id')->merge(['class' => 'ui-control ui-control--date' . ($error ? ' ui-control--invalid' : '')]) }}
        >
        <img src="{{ asset('icons/caret-down.svg') }}" alt="" width="18" height="18" class="ui-control__caret">
    </div>
    @if ($error)
        <p id="{{ $id }}-msg" class="ui-field__error" role="alert">{{ $error }}</p>
    @elseif ($hint)
        <p id="{{ $id }}-msg" class="ui-field__hint">{{ $hint }}</p>
    @endif
</div>
