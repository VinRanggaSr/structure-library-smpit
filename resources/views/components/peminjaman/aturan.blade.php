{{-- Aturan dari Superadmin, ditampilkan agar petugas bisa menyampaikannya saat mencatat peminjaman. --}}
@props(['aturan'])

<section class="ui-rules" aria-labelledby="aturan-peminjaman">
    <div class="ui-rules__head">
        <h2 id="aturan-peminjaman" class="t-12-medium">Aturan Peminjaman</h2>
        <p class="t-12-regular text-gray">Sampaikan aturan berikut kepada siswa saat meminjam buku</p>
    </div>

    <div class="ui-rules__card">
        @if ($aturan->isEmpty())
            <p class="ui-rules__empty">Belum ada aturan yang berlaku</p>
        @else
            <ol class="ui-rules__list">
                @foreach ($aturan as $a)
                    <li class="ui-rules__item">
                        <span class="ui-rules__number" aria-hidden="true">{{ $loop->iteration }}</span>
                        <div class="ui-rules__text">
                            <p class="t-12-medium">{{ $a->judul_aturan }}</p>
                            <p class="t-12-regular text-gray">{{ $a->deskripsi_aturan }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        @endif
    </div>
</section>
