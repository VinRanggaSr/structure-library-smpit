# Perpustakaan SMP IT

Sistem perpustakaan sekolah: Laravel 12 + Blade + Alpine.js, tanpa framework CSS tambahan.
Seluruh gaya berasal dari satu berkas, `resources/css/perpustakaan.css`.

Tahap saat ini **baru tampilan**. Controller mengembalikan data contoh dari
`app/Support/ContohData.php`; belum ada query database, autentikasi, maupun validasi.

## Menjalankan

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
npm run build
php artisan serve
```

Buka `http://127.0.0.1:8000`. Setelah `npm run build` sekali, cukup `php artisan serve`
untuk menjalankannya lagi — Vite tidak perlu ikut hidup. Pakai `npm run dev`
hanya kalau sedang mengubah CSS/JS dan ingin perubahannya langsung terlihat.

Database belum diperlukan. Buat `perpustakaan_smpit` (MySQL/MariaDB) lalu
`php artisan migrate` bila ingin menyiapkan tabelnya; aplikasi belum membacanya.

Halaman awal `/` memilih peran, lalu `/admin/...` (Superadmin) atau `/petugas/...` (Penjaga).

## Peta berkas

| Berkas | Isi |
|---|---|
| `resources/css/perpustakaan.css` | Satu-satunya sumber gaya: token, komponen, halaman |
| `resources/js/perpustakaan.js` | Perilaku Alpine untuk `<x-ui.combobox>` |
| `resources/views/components/ui/` | 27 komponen design system (`<x-ui.button>`, `<x-ui.table>`, …) |
| `config/menu.php` | Menu header per peran |
| `resources/views/components/` | Komponen aplikasi: field set & popup per domain |
| `app/Support/ContohData.php` | Data contoh tahap visual — dihapus saat query asli masuk |
| `app/Support/ContohDashboard.php` | Angka contoh untuk dashboard |
| `app/Support/helpers.php` | `tanggal()`, `rupiah()`, `angka()` |

## Saat backend dikerjakan

Yang berubah hanya isi method controller: ganti pemanggilan `ContohData::...`
dengan query Eloquent, isi `rules()` pada Form Request, dan lepas middleware
`contoh-pengguna` di `routes/web.php` setelah login sungguhan tersedia.
Berkas Blade tidak perlu ikut berubah.
