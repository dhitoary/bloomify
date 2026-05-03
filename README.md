# Bloomify - E-Commerce Toko Bunga

Bloomify adalah platform e-commerce untuk pemesanan buket bunga. Proyek ini dikembangkan menggunakan Laravel 11, Tailwind CSS v4, dan Filament PHP untuk manajemen backend.

---

## Desain Sistem dan Color Palette

### Bloom - Enhanced Lazy Days Pastel Color Palette

Bloomify menggunakan **Bloom Color Palette** - versi enhanced dari Lazy Days yang lebih vibrant namun tetap elegan. Palette ini terdiri dari 8 warna utama yang harmonis dan kaya:

| Warna | Hex Code | Nama | Penggunaan |
| :--- | :--- | :--- | :--- |
| **Teal** | `#6B9A94` | Bloom Teal | Primary color - navigasi, tombol, heading |
| **Teal Light** | `#97B3AE` | Bloom Teal Light | Accent lighter - hover states, secondary elements |
| **Mint** | `#8FCB9E` | Bloom Mint | Vibrant secondary - accents, highlights |
| **Mint Light** | `#C8E6D7` | Bloom Mint Light | Light border, subtle accents |
| **Cream** | `#F5DDD0` | Bloom Cream | Warm accent - card backgrounds |
| **Coral** | `#E89B94` | Bloom Coral | Strong accent - CTA buttons, promotions |
| **Taupe** | `#9D8B7E` | Bloom Taupe | Neutral dark - footer, secondary text |
| **Ivory** | `#FAF8F5` | Bloom Ivory | Background - page & section backgrounds |

#### Penggunaan Warna dalam Aplikasi

- **Background Page**: Bloom Ivory (#FAF8F5) - warm, clean base
- **Text Primary**: Dark Gray (#1F2937) - excellent readability on light backgrounds
- **Text Secondary**: Bloom Taupe (#9D8B7E) - softer secondary text
- **Navigation & Headers**: Bloom Teal (#6B9A94) - strong, professional, eye-catching
- **Primary Buttons**: Bloom Teal dengan hover effect ke darker shade
- **Secondary Buttons**: Bloom Mint untuk gentle, friendly call-to-action
- **Cards & Sections**: Bloom Cream (#F5DDD0) untuk product cards dan content sections
- **Borders & Dividers**: Bloom Mint Light (#C8E6D7) untuk subtle separation
- **Special Highlights**: Bloom Coral (#E89B94) untuk limited offers atau promotions

#### Filosofi Design

Palette ini dipilih untuk mencerminkan karakteristik Bloomify:
- **Vibrant & Professional**: Warna lebih saturated namun tetap elegan & pastel
- **Warm & Inviting**: Tone yang hangat membuat user merasa welcome
- **Nature-Inspired**: Harmoni dengan tema bunga dan alam
- **High Contrast**: Readable text dengan warna yang jelas & tidak pucat
- **Premium Feel**: Sophisticated color combination untuk marketplace terpercaya

---

## Struktur Tim dan Pembagian Tugas

| Anggota | Role | Fokus Utama |
| :--- | :--- | :--- |
| **Dhito** | Fullstack Integrasi dan Admin | Infrastruktur, Admin Panel (Filament), dan Integrasi Midtrans. |
| **Cindy** | Frontend UI/UX dan Marketing | Desain Katalog Frontend dan Strategi Digital Marketing. |
| **Surya** | Frontend System Logic Marketplace | Flowchart, Business Logic, dan Sistem Keranjang Belanja. |

---

## Manajemen Version Control (Git Branching)

Untuk menjaga stabilitas sistem, seluruh anggota tim diwajibkan menggunakan sistem *branching* dengan aturan berikut:

1.  **Branch Utama (`master`):**
    Berisi kode yang sudah stabil dan berjalan dengan baik. Dilarang melakukan *push* kode yang belum selesai atau masih *error* ke dalam branch ini.

2.  **Branch Fitur:**
    Setiap anggota yang akan mengerjakan modul baru harus membuat *branch* baru dari `master` dengan format penamaan `feature/nama-fitur`.
    * Dhito: `feature/midtrans-payment` `feature/admin-dashboard`
    * Cindy: `feature/ui-katalog`
    * Surya: `feature/cart-system`

3.  **Alur Kerja Standar:**
    * Perbarui lokal repositori sebelum bekerja: `git pull origin master`
    * Pindah atau buat branch baru: `git checkout -b feature/nama-fitur`
    * Lakukan *commit* secara berkala.
    * *Push* ke branch masing-masing: `git push origin feature/nama-fitur`
    * Lakukan koordinasi untuk melakukan *Merge* kode ke `master`.

---

## Tech Stack dan Fitur

* **Backend:** Laravel 11 dengan database MySQL/MariaDB.
* **Frontend:** Tailwind CSS v4 dengan build tool Vite.
* **Admin Panel:** Custom Admin Dashboard (Diakses melalui URL `/admin-dashboard`).
* **Authentication:** Laravel Breeze dengan sistem role admin
* **UI Components:** Custom components mengikuti Bloom color palette.

---

## Fitur-Fitur Marketplace

### Customer Features (Frontend) - Sudah Diimplementasikan ✅
- **Katalog Produk**: Menampilkan buket bunga dengan filter kategori
- **Product Details**: Informasi lengkap produk dengan foto berkualitas
- **Filter Kategori**: Browse produk berdasarkan kategori
- **User Dashboard**: Dashboard untuk pengguna yang sudah login
- **User Profile**: Kelola profil pengguna

### Customer Features - Dalam Pengembangan 🚧
- **Shopping Cart**: Keranjang belanja dengan update real-time
- **Checkout**: Proses checkout dengan shipping info
- **Payment Gateway**: Integrasi Midtrans untuk berbagai metode pembayaran
- **Order History**: Riwayat pembelian dan status order

### Admin Features - Sudah Diimplementasikan ✅
- **Product Management**: CRUD lengkap untuk buket bunga dengan foto
- **Category Management**: Kelola kategori produk
- **Dashboard Admin**: Statistik produk dan kategori
- **Stock Management**: Monitor stok produk

### Admin Features - Dalam Pengembangan 🚧
- **Order Management**: Tracking dan management pesanan
- **Discount Management**: Buat dan kelola promo discount
- **Voucher Management**: Create dan manage voucher codes
- **Analytics**: Dashboard untuk metrics penjualan dan traffic

---

## Struktur Penempatan File

* **Admin Dashboard:** Terletak pada direktori `app/Filament/`. Digunakan untuk pengelolaan data produk dan pesanan.
* **Frontend Views:** Terletak pada direktori `resources/views/`. Digunakan untuk pengembangan antarmuka pengguna.
* **Controller:** Terletak pada direktori `app/Http/Controllers/`. Digunakan untuk penempatan logika sistem.
* **Models:** Terletak pada direktori `app/Models/`. Models untuk Cart, Category, Order, OrderItem, Product, User.

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
    Admin account dapat dibuat melalui database seeders atau manual via command:
    ```bash
    php artisan tinker
    >>> $user = new \App\Models\User();
    >>> $user->name = 'Admin Name';
    >>> $user->email = 'admin@bloomify.com';
    >>> $user->password = bcrypt('password');
    >>> $user->is_admin = true;
    >>> $user->save();
    ```
4.  **Menjalankan Aplikasi:**
    Jalankan server Laravel dan Vite secara bersamaan:
    * Terminal 1: `php artisan serve`
    * Terminal 2: `npm run dev`

---

## Integrasi Pembayaran

Konfigurasi API Key Midtrans tersedia pada file .env. Saat ini fitur pembayaran masih dalam pengembangan.

**Status**: 🚧 Dalam Pengembangan - Integrasi Midtrans untuk payment gateway akan segera ditambahkan.

---

## Akses Admin Dashboard

- **URL**: `http://localhost:8000/admin-dashboard` 
- **Persyaratan**: Akun dengan role admin
- **Login**: Gunakan sistem autentikasi Laravel yang sudah ada

Setelah login sebagai admin, Anda dapat:
- Mengelola kategori produk
- Menambah, edit, atau hapus produk
- Melihat dashboard dengan statistik produk dan kategori

---

## Panduan UI/UX

### Design Principles

1. **Konsistensi Warna**: Selalu gunakan Bloom color palette
2. **No Emoticons**: Aplikasi dibuat professional tanpa emoticon
3. **Readable Text**: Gunakan text color yang cukup gelap untuk readability
4. **Responsive Design**: Semua pages harus responsive mobile-first
5. **Accessibility**: Pastikan contrast ratio dan readability terjaga
6. **Minimalist**: Design simple dan fokus pada user experience

### Tailwind Custom Colors

Gunakan custom color names di Tailwind:
```html
<!-- Primary (Teal) -->
<div class="bg-bloom-teal text-white">...</div>

<!-- Secondary (Mint) -->
<div class="border-bloom-mint-light">...</div>

<!-- Accents -->
<div class="bg-bloom-cream">...</div>
<div class="bg-bloom-coral">...</div>

<!-- Text & Backgrounds -->
<div class="text-bloom-taupe">...</div>
<div class="bg-bloom-ivory">...</div>

<!-- Light Variants -->
<div class="text-bloom-teal-light">...</div>
<div class="bg-bloom-mint">...</div>
```

---

## Daftar Route

### Public Routes
- `GET /` - Halaman beranda
- `GET /katalog` - Katalog produk
- `GET /produk/{slug}` - Detail produk
- `GET /kategori/{slug}` - Filter produk berdasarkan kategori
- `GET /dashboard` - Dashboard pengguna (authenticated)

### Admin Routes
- `GET /admin-dashboard` - Admin dashboard (authenticated + admin role)
- `GET /admin-dashboard/products` - Daftar produk (admin)
- `POST /admin-dashboard/products` - Tambah produk (admin)
- `GET /admin-dashboard/products/{id}/edit` - Edit produk (admin)
- `PUT /admin-dashboard/products/{id}` - Update produk (admin)
- `DELETE /admin-dashboard/products/{id}` - Hapus produk (admin)
- `GET /admin-dashboard/categories` - Daftar kategori (admin)
- `POST /admin-dashboard/categories` - Tambah kategori (admin)
- `GET /admin-dashboard/categories/{id}/edit` - Edit kategori (admin)
- `PUT /admin-dashboard/categories/{id}` - Update kategori (admin)
- `DELETE /admin-dashboard/categories/{id}` - Hapus kategori (admin)

---

**Catatan:** Jika aset pada halaman admin tidak terbaca, pastikan telah menjalankan perintah `php artisan storage:link`.
