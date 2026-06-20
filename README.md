# SIMBIMA

SIMBIMA adalah Sistem Informasi Bimbingan Mahasiswa berbasis Laravel untuk
mengelola proses pengajuan dosen pembimbing, slot dosen, catatan bimbingan, dan
status tugas akhir dalam satu aplikasi web.

Live demo: https://simbima.up.railway.app

## Fitur

- Autentikasi dan dashboard terpisah untuk admin, dosen, dan mahasiswa.
- Admin dapat mengelola data dosen, mahasiswa, slot bimbingan, reset password,
  dan import mahasiswa dari file.
- Mahasiswa dapat memilih bidang minat, mengajukan dosen pembimbing, memantau
  status pengajuan, dan memperbarui progres bimbingan.
- Dosen dapat menerima atau menolak pengajuan, mengelola status bimbingan,
  menambahkan dosen pembimbing kedua, dan memberi catatan.
- Statistik dosen dengan fitur export.
- Notifikasi untuk alur pengajuan dan perubahan status.

## Teknologi

- Laravel 11
- PHP 8.2+
- MySQL
- Tailwind CSS
- Alpine.js
- Vite
- Docker
- Railway

## Menjalankan Lokal

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

Untuk mode development frontend:

```bash
npm run dev
```

## Environment Utama

```env
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simbima
DB_USERNAME=root
DB_PASSWORD=
```

## Deploy

Project ini sudah disiapkan untuk deploy Docker di Railway. Service aplikasi
menggunakan `Dockerfile`, sedangkan database menggunakan service MySQL Railway.

Variabel penting di Railway:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://simbima.up.railway.app
DB_CONNECTION=mysql
DB_URL=${{MySQL.MYSQL_URL}}
PORT=8080
```

## Status

Production-ready untuk demo portofolio dan pengujian alur bimbingan mahasiswa.
