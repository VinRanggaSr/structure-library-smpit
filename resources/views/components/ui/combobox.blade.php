{{--
  Dropdown yang bisa dicari (dipakai untuk SEMUA pilihan di sistem: siswa, buku,
  kategori, jenis denda, status, role, dll). Butuh Alpine.js + uiCombobox() di perpustakaan.js.
  Nilai terpilih dikirim lewat <input type="hidden" name="...">.

  <x-ui.combobox
      label="Siswa"
      name="id_siswa"
      placeholder="Cari nama atau NISN siswa"
      empty="Siswa tidak ditemukan"
      :value="$peminjaman->id_siswa ?? null"
      :options="$siswa->map(fn ($s) => [
          'value' => $s->id_siswa,
          'label' => $s->nama_siswa,
          'meta'  => $s->NISN_siswa,        // teks abu-abu di kanan (opsional)
          'keywords' => $s->kelas ?? '',     // ikut dicari tapi tidak ditampilkan (opsional)
      ])" />

  States: tertutup · terbuka · sedang mencari · opsi aktif (keyboard/hover) · opsi terpilih · kosong · error · disabled
  Keyboard: ↑ ↓ pindah opsi, Enter pilih, Esc tutup.
--}}
@props([
    'label',
    'name',
    'options' => [],
    'value' => null,
    'placeholder' => 'Pilih...',
    'empty' => 'Data tidak ditemukan',
    'hint' => null,
    'disabled' => false,
])

@php
    $id = $attributes->get('id', $name);
    $error = $errors->first($name);
    $options = collect($options)->values()->all();
@endphp

<div class="ui-field"
     x-data="uiCombobox({ options: @js($options), value: @js(old($name, $value)), placeholder: @js($placeholder) })"
     x-on:click.outside="close()">
    <label for="{{ $id }}" class="ui-field__label">{{ $label }}</label>

    <div class="ui-control-wrap">
        <input type="hidden" name="{{ $name }}" x-bind:value="value ?? ''">

        <input
            id="{{ $id }}"
            type="text"
            role="combobox"
            autocomplete="off"
            aria-autocomplete="list"
            aria-controls="{{ $id }}-list"
            x-bind:aria-expanded="open"
            x-bind:placeholder="open && selected ? selectedText : placeholder"
            x-bind:value="open ? query : selectedText"
            x-on:input="search($event.target.value)"
            x-on:focus="openList()"
            x-on:click="openList()"
            x-on:keydown.arrow-down.prevent="move(1)"
            x-on:keydown.arrow-up.prevent="move(-1)"
            x-on:keydown.enter.prevent="choose()"
            x-on:keydown.escape.stop="close()"
            x-on:keydown.tab="close()"
            @disabled($disabled)
            @if ($error) aria-invalid="true" @endif
            class="ui-control ui-control--combobox {{ $error ? 'ui-control--invalid' : '' }}"
        >
        <img src="{{ asset('icons/caret-down.svg') }}" alt="" width="18" height="18"
             class="ui-control__caret" x-bind:class="open && 'ui-control__caret--open'">

        <ul id="{{ $id }}-list" role="listbox" aria-label="{{ $label }}" class="ui-combobox__list" x-show="open" x-cloak>
            <template x-for="(o, i) in filtered" x-bind:key="o.value">
                <li role="option"
                    class="ui-combobox__option"
                    x-bind:class="{ 'ui-combobox__option--active': i === active, 'ui-combobox__option--selected': o.value == value }"
                    x-bind:aria-selected="o.value == value"
                    x-on:mousedown.prevent
                    x-on:mouseenter="active = i"
                    x-on:click="pick(o)">
                    <span class="ui-combobox__label" x-text="o.label"></span>
                    <span class="ui-combobox__meta" x-show="o.meta" x-text="o.meta"></span>
                </li>
            </template>
            <li class="ui-combobox__empty" x-show="filtered.length === 0">{{ $empty }}</li>
        </ul>
    </div>

    @if ($error)
        <p class="ui-field__error" role="alert">{{ $error }}</p>
    @elseif ($hint)
        <p class="ui-field__hint">{{ $hint }}</p>
    @endif
</div>
