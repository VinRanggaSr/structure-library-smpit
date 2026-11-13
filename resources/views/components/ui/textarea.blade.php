{{--
  Text-area 72px untuk deskripsi / keterangan.

  <x-ui.textarea label="Deskripsi" name="deskripsi_kategori" placeholder="Masukkan deskripsi dari kategori" />
--}}
@props([
    'label',
    'name',
    'value' => null,
    'hint' => null,
    'placeholder' => null,
])

@php
    $id = $attributes->get('id', $name);
    $error = $errors->first($name);
@endphp

<div class="ui-field">
    <label for="{{ $id }}" class="ui-field__label">{{ $label }}</label>
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        @if ($error) aria-invalid="true" @endif
        @if ($error || $hint) aria-describedby="{{ $id }}-msg" @endif
        {{ $attributes->except('id')->merge(['class' => 'ui-control ui-control--textarea' . ($error ? ' ui-control--invalid' : '')]) }}
    >{{ old($name, $value) }}</textarea>
    @if ($error)
        <p id="{{ $id }}-msg" class="ui-field__error" role="alert">{{ $error }}</p>
    @elseif ($hint)
        <p id="{{ $id }}-msg" class="ui-field__hint">{{ $hint }}</p>
    @endif
</div>
