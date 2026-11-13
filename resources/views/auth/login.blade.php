<x-app-layout polos :title="'Masuk sebagai ' . $peran['nama']">
    <div class="ui-auth ui-auth--login">
        <x-ui.back-link :href="route('pilih-peran')">Kembali pilih peran</x-ui.back-link>

        <div class="ui-auth__brand">
            <span class="ui-auth__icon ui-auth__icon--brand">
                <img src="{{ asset('icons/' . $peran['ikon'] . '.svg') }}" alt="" width="20" height="20">
            </span>
            <h1 class="t-28-semibold">Masuk sebagai {{ $peran['nama'] }}</h1>
            <p class="t-12-regular text-gray">Mode pengujian — username dan password sudah diisi otomatis</p>
        </div>

        <form method="POST" action="{{ route('login.store', $peran['slug']) }}" class="ui-auth__card" novalidate>
            @csrf
            <x-ui.input label="Username" name="username_pengguna" placeholder="Masukan username"
                        autocomplete="username" :value="$akun?->username_pengguna" />
            <x-ui.input label="Password" name="password_pengguna" type="password" placeholder="Masukan password"
                        autocomplete="current-password" prefill :value="$akun?->password_pengguna" />
            <x-ui.button variant="primary" type="submit" block>Masuk</x-ui.button>
        </form>
    </div>
</x-app-layout>
