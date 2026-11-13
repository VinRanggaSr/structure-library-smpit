@props(['aturan' => null])

<x-ui.input label="Nama" name="judul_aturan" placeholder="Masukan nama aturan" :value="$aturan?->judul_aturan" />
<x-ui.textarea label="Deskripsi" name="deskripsi_aturan" placeholder="Masukkan deskripsi aturan"
               :value="$aturan?->deskripsi_aturan" />
