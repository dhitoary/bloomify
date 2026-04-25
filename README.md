# Bloomify - E-Commerce Toko Bunga

Bloomify adalah platform e-commerce untuk pemesanan buket bunga. Proyek ini dikembangkan menggunakan Laravel 11, Tailwind CSS v4, dan Filament PHP untuk manajemen backend.

---

## Struktur Tim dan Pembagian Tugas

| Anggota | Role | Fokus Utama |
| :--- | :--- | :--- |
| **Dhito** | Fullstack dan Admin | Infrastruktur, Admin Panel (Filament), dan Integrasi Midtrans. |
| **Cindy** | Frontend UI/UX dan Marketing | Desain Katalog Frontend dan Strategi Digital Marketing. |
| **Surya** | Frontend System Logic Marketplace | Flowchart, Business Logic, dan Sistem Keranjang Belanja. |

---

## Tech Stack dan Fitur
* **Backend:** Laravel 11 dengan database PostgreSQL.
* **Frontend:** Tailwind CSS v4 dengan build tool Vite.
* **Admin Panel:** Filament PHP v3 (Dapat diakses melalui URL /admin).
* **Payment Gateway:** Midtrans Snap (Mode Sandbox untuk pengujian).

---

## Struktur Penempatan File

* **Admin Dashboard:** Terletak pada direktori `app/Filament/`. Digunakan untuk pengelolaan data produk dan pesanan.
* **Frontend Views:** Terletak pada direktori `resources/views/`. Digunakan untuk pengembangan antarmuka pengguna.
* **Controller:** Terletak pada direktori `app/Http/Controllers/`. Digunakan untuk penempatan logika sistem.

---

## Instruksi Instalasi untuk Tim (Cindy dan Surya)

Setelah melakukan pull dari repository, jalankan perintah berikut secara berurutan:

1.  **Update Library:**
    ```bash
    composer install
    npm install
    ```
2.  **Sinkronisasi Database:**
    ```bash
    php artisan migrate
    ```
3.  **Pembuatan Akun Admin:**
    Gunakan perintah berikut untuk membuat akun akses ke dashboard admin:
    ```bash
    php artisan make:filament-user
    ```
4.  **Menjalankan Aplikasi:**
    Jalankan server Laravel dan Vite secara bersamaan:
    * Terminal 1: `php artisan serve`
    * Terminal 2: `npm run dev`

---

## Integrasi Pembayaran
Konfigurasi API Key Midtrans tersedia pada file .env. Pastikan nilai MIDTRANS_IS_PRODUCTION tetap pada status false untuk keperluan pengembangan dan pengujian.

---

**Catatan:** Jika aset pada halaman admin tidak terbaca, pastikan telah menjalankan perintah `php artisan storage:link`.