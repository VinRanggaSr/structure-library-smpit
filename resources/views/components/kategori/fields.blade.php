@props(['kategori' => null])

<x-ui.input label="Nama Kategori" name="nama_kategori" placeholder="Masukan nama kategori"
            :value="$kategori?->nama_kategori" />
<x-ui.textarea label="Deskripsi" name="deskripsi_kategori" placeholder="Masukkan deskripsi dari kategori"
               :value="$kategori?->deskripsi_kategori" />
