@props(['pengguna' => null])

@php use App\Models\Pengguna; @endphp

<x-ui.input label="Nama" name="nama_pengguna" placeholder="Masukan nama pengguna" :value="$pengguna?->nama_pengguna" />
<x-ui.input label="Username" name="username_pengguna" placeholder="Masukan username"
            :value="$pengguna?->username_pengguna" />
<x-ui.input label="Password" name="password_pengguna" type="password"
            :placeholder="$pengguna ? 'Kosongkan jika tidak diubah' : 'Masukan password'" />
<x-ui.combobox label="Role" name="role_pengguna" placeholder="Pilih role pengguna"
               :value="$pengguna?->role_pengguna"
               :options="[
                   ['value' => Pengguna::ROLE_PENJAGA, 'label' => 'Penjaga (Petugas Perpustakaan)'],
                   ['value' => Pengguna::ROLE_SUPERADMIN, 'label' => 'Superadmin (Master Admin)'],
               ]" />
