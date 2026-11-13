@props(['siswa' => null])

@php use App\Models\Siswa; @endphp

<x-ui.input label="NISN" name="NISN_siswa" placeholder="Masukan nomor NISN siswa" inputmode="numeric"
            :value="$siswa?->NISN_siswa" />
<x-ui.input label="Nama" name="nama_siswa" placeholder="Masukan nama siswa" :value="$siswa?->nama_siswa" />
<x-ui.combobox label="Jenis Kelamin" name="jenis_kelamin_siswa" placeholder="Pilih jenis kelamin siswa"
               :value="$siswa?->jenis_kelamin_siswa"
               :options="collect([Siswa::JENIS_KELAMIN_LAKI, Siswa::JENIS_KELAMIN_PEREMPUAN])
                   ->map(fn ($v) => ['value' => $v, 'label' => $v])" />
<x-ui.combobox label="Status" name="status_siswa" placeholder="Pilih status siswa"
               :value="$siswa?->status_siswa ?? Siswa::STATUS_AKTIF"
               :options="collect([Siswa::STATUS_AKTIF, Siswa::STATUS_TIDAK_AKTIF])
                   ->map(fn ($v) => ['value' => $v, 'label' => $v])" />
