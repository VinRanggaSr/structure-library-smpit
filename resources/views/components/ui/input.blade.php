{{--
  Input teks dengan label, hint, dan pesan error dari validasi Laravel.
  Error diambil otomatis dari $errors berdasarkan name; nilai lama dari old().

  <x-ui.input label="Judul" name="judul_buku" placeholder="Masukan judul buku" :value="$buku->judul_buku ?? null" />
  <x-ui.input label="NISN" name="NISN_siswa" inputmode="numeric" hint="Hanya angka" />
  <x-ui.input label="Password" name="password_pengguna" type="password" />

  States: default · hover · focus · terisi · error · disabled (tambahkan atribut disabled)
--}}
@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'hint' => null,
    'placeholder' => null,
    'prefill' => false,
])

@php
    $id = $attributes->get('id', $name);
    $error = $errors->first($name);
    $current = $type === 'password' && ! $prefill ? null : old($name, $value);
@endphp

<div class="ui-field">
    <label for="{{ $id }}" class="ui-field__label">{{ $label }}</label>
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $current }}"
        placeholder="{{ $placeholder }}"
        @if ($error) aria-invalid="true" @endif
        @if ($error || $hint) aria-describedby="{{ $id }}-msg" @endif
        {{ $attributes->except('id')->merge(['class' => 'ui-control' . ($error ? ' ui-control--invalid' : '')]) }}
    >
    @if ($error)
        <p id="{{ $id }}-msg" class="ui-field__error" role="alert">{{ $error }}</p>
    @elseif ($hint)
        <p id="{{ $id }}-msg" class="ui-field__hint">{{ $hint }}</p>
    @endif
</div>
