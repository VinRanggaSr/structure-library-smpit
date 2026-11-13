{{--
  Popup (384px, radius 24, overlay #111 50%). Dibuka dari mana saja dengan event:
      x-on:click="$dispatch('open-modal', 'tambah-kategori')"
  Ditutup dengan Esc, klik overlay, atau $dispatch('close-modal', 'tambah-kategori').

  <x-ui.modal name="tambah-kategori" icon="book-bookmark" title="Tambah Kategori Buku"
              description="Tambahkan setiap kategori dari buku yang anda miliki"
              :action="route('kategori.store')">
      <x-ui.input label="Nama Kategori" name="nama_kategori" placeholder="Masukan nama kategori" />
      <x-ui.textarea label="Deskripsi" name="deskripsi_kategori" placeholder="Masukkan deskripsi dari kategori" />

      <x-slot:footer>
          <x-ui.button block x-on:click="$dispatch('close-modal', 'tambah-kategori')">Batal</x-ui.button>
          <x-ui.button block variant="primary" type="submit">Tambah</x-ui.button>
      </x-slot:footer>
  </x-ui.modal>

  description: baris baru di dalam teks dirender sebagai <br>
  icon:   nama file di public/icons (book-bookmark, money-wavy, user-circle, warning-octagon, trash-popup, sign-out-red)
  tone:   brand (default) | red  -> lingkaran ikon Brand-Soft2 / Red-Soft
  action: jika diisi, isi popup dibungkus <form method="POST"> lengkap dengan @csrf
  method: PUT / PATCH / DELETE untuk form update & hapus
  show:   true agar langsung terbuka (mis. saat validasi gagal: :show="$errors->any()")
--}}
@props([
    'name',
    'icon' => 'book-bookmark',
    'tone' => 'brand',
    'title',
    'description' => null,
    'action' => null,
    'method' => 'POST',
    'show' => false,
])

<div x-data="{ open: @js($show) }"
     x-on:open-modal.window="if ($event.detail === '{{ $name }}') open = true"
     x-on:close-modal.window="if ($event.detail === '{{ $name }}') open = false"
     x-on:keydown.escape.window="open = false">
    <div class="ui-modal" x-show="open" x-cloak x-transition.opacity x-on:mousedown.self="open = false">
        <div class="ui-modal__panel" role="dialog" aria-modal="true" aria-labelledby="{{ $name }}-title"
             x-trap.noscroll="open">
            @if ($action)
                <form method="POST" action="{{ $action }}" class="ui-modal__form" novalidate>
                    @csrf
                    @unless (strtoupper($method) === 'POST')
                        @method($method)
                    @endunless
            @endif

            <div class="ui-modal__head">
                <span class="ui-modal__icon {{ $tone === 'red' ? 'ui-modal__icon--red' : '' }}">
                    <img src="{{ asset('icons/' . $icon . '.svg') }}" alt="" width="20" height="20">
                </span>
                <div class="ui-modal__text">
                    <h2 id="{{ $name }}-title" class="t-16-semibold">{{ $title }}</h2>
                    @if ($description)
                        {{-- Baris baru pada deskripsi dipertahankan: desain memutus kalimat di titik tertentu. --}}
                        <p class="t-12-regular text-gray">
                            {!! collect(preg_split('/\R/', e($description)))->map(fn ($baris) => trim($baris))->join('<br>') !!}
                        </p>
                    @endif
                </div>
            </div>

            {{ $slot }}

            @isset($footer)
                <div class="ui-modal__footer">{{ $footer }}</div>
            @endisset

            @if ($action)
                </form>
            @endif
        </div>
    </div>
</div>
