{{--
  Header aplikasi: logo + nama, menu sesuai role, nama pengguna, tombol keluar (dengan konfirmasi).

  <x-ui.header :nav="[
      ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
      ['label' => 'Buku', 'route' => 'admin.buku.index'],
      ['label' => 'Kategori', 'route' => 'admin.kategori.index'],
  ]" />

  Menu aktif ditentukan dari request()->routeIs(route . '*').
--}}
@props(['nav' => []])

@php $user = auth()->user(); @endphp

<header class="ui-header">
    <div class="ui-header__container">
        <a href="{{ url('/') }}" class="ui-header__brand">
            <span class="ui-header__logo"><img src="{{ asset('images/logo.png') }}" alt=""></span>
            <span class="ui-header__name">Perpustakaan SMP IT</span>
        </a>

        <div class="ui-header__right">
            <nav class="ui-header__nav" aria-label="Navigasi utama">
                @foreach ($nav as $item)
                    @php $active = request()->routeIs(\Illuminate\Support\Str::beforeLast($item['route'], '.') . '*'); @endphp
                    <a href="{{ route($item['route']) }}"
                       class="ui-header__link {{ $active ? 'ui-header__link--active' : '' }}"
                       @if ($active) aria-current="page" @endif>{{ $item['label'] }}</a>
                @endforeach
            </nav>

            <div class="ui-header__account">
                <div class="ui-header__profile">
                    <span class="t-12-medium">{{ $user?->nama_pengguna }}</span>
                    <span class="t-12-regular text-gray">{{ $user?->role_pengguna }}</span>
                </div>
                <x-ui.icon-button icon="sign-out" label="Keluar" frame
                    x-data x-on:click="$dispatch('open-modal', 'logout')" />
            </div>
        </div>
    </div>
</header>

<x-ui.modal name="logout" icon="sign-out-red" tone="red" title="Keluar dari sistem?"
            description="Anda akan keluar sebagai {{ $user?->nama_pengguna }} dan perlu masuk kembali untuk melanjutkan"
            :action="route('logout')">
    <x-slot:footer>
        <x-ui.button block x-on:click="$dispatch('close-modal', 'logout')">Batal</x-ui.button>
        <x-ui.button block variant="danger" type="submit">Ya, Keluar</x-ui.button>
    </x-slot:footer>
</x-ui.modal>
