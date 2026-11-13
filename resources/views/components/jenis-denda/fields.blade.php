@props(['jenisDenda' => null])

<x-ui.input label="Nama" name="nama_denda" placeholder="Masukan nama denda" :value="$jenisDenda?->nama_denda" />
<x-ui.input label="Nominal" name="nominal_denda" type="number" inputmode="numeric" min="1" step="1"
            placeholder="Masukan nominal denda dalam rupiah" :value="$jenisDenda?->nominal_denda" />
<x-ui.textarea label="Keterangan" name="keterangan_denda" placeholder="Masukan keterangan terkait denda"
               :value="$jenisDenda?->keterangan_denda" />
