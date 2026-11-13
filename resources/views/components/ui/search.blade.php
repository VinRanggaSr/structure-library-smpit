{{--
  Kolom cari berbentuk pill. Bekerja sebagai form GET sehingga hasil bisa dibagikan lewat URL.

  <x-ui.search placeholder="Cari judul atau penulis..." :action="route('buku.index')" />
  Di controller: $q = $request->string('q');
--}}
@props([
    'placeholder' => 'Cari...',
    'name' => 'q',
    'action' => null,
])

<form method="GET" action="{{ $action ?? url()->current() }}" role="search">
    @foreach (request()->except($name, 'page') as $key => $val)
        @if (is_scalar($val))
            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
        @endif
    @endforeach
    <input
        type="search"
        name="{{ $name }}"
        value="{{ request($name) }}"
        placeholder="{{ $placeholder }}"
        aria-label="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'ui-search']) }}
    >
</form>
