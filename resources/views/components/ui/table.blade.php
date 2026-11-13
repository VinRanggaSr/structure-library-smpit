{{--
  Kartu tabel putih (radius 24). Header abu-abu 41px, baris 51px, garis Gray-line.

  <x-ui.table caption="Daftar kategori">
      <x-slot:head>
          <th style="width: 300px">Nama Kategori</th>
          <th>Deskripsi</th>
          <th style="width: 133px"><span class="sr-only">Aksi</span></th>
      </x-slot:head>

      @forelse ($kategori as $k)
          <tr>
              <td>{{ $k->nama_kategori }}</td>
              <td class="ui-table__wrap">{{ $k->deskripsi_kategori }}</td>
              <td><x-ui.row-actions label="kategori {{ $k->nama_kategori }}" :edit="route('kategori.edit', $k)" delete-modal="hapus-kategori-{{ $k->id_kategori }}" /></td>
          </tr>
      @empty
          <tr><td colspan="3" class="ui-table__empty">Belum ada data kategori</td></tr>
      @endforelse
  </x-ui.table>

  Lebih dari 15 baris? Kirim paginator: <x-ui.table :paginator="$kategori"> (lihat x-ui.pagination).

  min-width: lebar minimum tabel sebelum menggulir (bawaan 760px dari perpustakaan.css).
  Tabel di dalam kolom detail 672px mengirim nilai yang lebih kecil, mis. :min-width="643".

  Kelas sel: ui-table__muted (teks abu-abu, mis. tanggal) · ui-table__wrap (teks panjang boleh turun baris)
  Baris bisa diklik: <tr class="ui-table__clickable" onclick="location='{{ route('...') }}'">
--}}
@props(['caption' => null, 'paginator' => null, 'minWidth' => null])

<div {{ $attributes->merge(['class' => 'ui-table-card']) }}>
    <div class="ui-table-scroll">
        <table class="ui-table" @if ($minWidth) style="min-width: {{ $minWidth }}px" @endif>
            @if ($caption)
                <caption class="sr-only">{{ $caption }}</caption>
            @endif
            <thead>
                <tr>{{ $head }}</tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if ($paginator)
        <x-ui.pagination :paginator="$paginator" />
    @endif
</div>
