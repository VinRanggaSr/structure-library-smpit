{{--
  Dua field berdampingan dengan jarak 20px (menumpuk di mobile).

  <x-ui.field-row>
      <x-ui.input label="Penerbit (opsional)" name="penerbit_buku" />
      <x-ui.input label="Tahun Terbit (opsional)" name="tahun_terbit_buku" />
  </x-ui.field-row>
--}}
<div {{ $attributes->merge(['class' => 'ui-field-row']) }}>{{ $slot }}</div>
