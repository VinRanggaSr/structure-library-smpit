<x-app-layout polos title="Pilih Peran — Perpustakaan SMP IT">
    <div class="ui-auth">
        <div class="ui-auth__brand">
            <span class="ui-auth__logo"><img src="{{ asset('images/logo.png') }}" alt=""></span>
            <h1 class="t-28-semibold">Perpustakaan SMP IT</h1>
            <p class="t-12-regular text-gray">Pilih peran anda untuk masuk ke sistem</p>
        </div>

        <ul class="ui-auth__roles">
            @foreach ($peran as $p)
                <li>
                    <a href="{{ route('login', $p['slug']) }}" class="ui-auth__role">
                        <span class="ui-auth__icon">
                            <img src="{{ asset('icons/' . $p['ikon'] . '.svg') }}" alt="" width="20" height="20">
                        </span>
                        <span class="ui-auth__role-text">
                            <span class="t-16-semibold">{{ $p['nama'] }}</span>
                            <span class="t-12-regular text-gray">{{ $p['deskripsi'] }}</span>
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
