# Panduan Setup & Penggunaan Bloomify

Selamat datang di **Bloomify** - Toko Bunga Online yang dilengkapi dengan Admin Dashboard yang powerful.

## 📋 Daftar Isi
1. [Instalasi & Setup](#instalasi--setup)
2. [Admin Dashboard](#admin-dashboard)
3. [Fitur Utama](#fitur-utama)
4. [Panduan Pengguna](#panduan-pengguna)
5. [Troubleshooting](#troubleshooting)

---

## 🚀 Instalasi & Setup

### Prasyarat
- PHP >= 8.1
- Composer
- PostgreSQL >= 12
- Node.js & NPM

### Langkah Instalasi

1. **Clone Repository & Install Dependencies**
```bash
cd bloomify
composer install
npm install
```

2. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Konfigurasi Database**
Edit file `.env` dan sesuaikan konfigurasi PostgreSQL Anda:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1          # Host PostgreSQL (sesuaikan jika berbeda)
DB_PORT=5432               # Port default PostgreSQL
DB_DATABASE=db_bloomify       # Nama database (buat terlebih dahulu)
DB_USERNAME=postgres       # Username PostgreSQL (sesuaikan)
DB_PASSWORD=               # Password PostgreSQL (isi dengan password Anda)
```

**Catatan**: Pastikan database `bloomify` sudah dibuat di PostgreSQL sebelum menjalankan migrasi.

4. **Jalankan Migrasi & Seeder**
```bash
php artisan migrate
php artisan db:seed
```

5. **Build Assets**
```bash
npm run build
# atau untuk development
npm run dev
```

6. **Create Storage Link**
```bash
php artisan storage:link
```

7. **Jalankan Server**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

---

## 🔐 Admin Dashboard

### Akses Admin Dashboard
- **URL**: `http://localhost:8000/admin-dashboard`
- Persyaratan: Akun dengan role admin
- Gunakan sistem autentikasi Laravel yang sudah ada

### Dashboard Admin
Dashboard admin menampilkan statistik penting:
- Total Produk
- Total Kategori
- Stok Total

Dari dashboard, admin dapat mengakses menu untuk mengelola produk dan kategori.

---

## 🛍️ Fitur Utama

### 1. **Manajemen Kategori**
Admin dapat membuat kategori produk untuk mengorganisir bunga-bunga.

**Menu**: Admin Panel → Kategori

**Fitur**:
- Tambah kategori baru
- Edit nama dan deskripsi
- Lihat jumlah produk per kategori
- Hapus kategori

### 2. **Manajemen Produk**
Fitur lengkap untuk mengelola katalog produk.

**Menu**: Admin Panel → Produk

**Informasi Produk yang Dapat Diatur**:
- ✅ Nama Produk
- ✅ Slug (URL-friendly name)
- ✅ Deskripsi Detail
- ✅ Kategori
- ✅ Harga (dalam Rupiah)
- ✅ Stok
- ✅ Gambar Produk (Max 5MB, format: JPG, PNG, WebP)

**Cara Menambah Produk**:
1. Buka Admin Panel
2. Klik **Produk** → **Tambah Produk**
3. Isi form sesuai data produk
4. Upload gambar produk
5. Klik **Simpan**

Produk akan langsung muncul di halaman katalog publik jika stok > 0.

---

## 👥 Panduan Pengguna

### Halaman Publik

#### 1. **Halaman Beranda** (`/`)
- Tampilan menarik dengan hero section
- Informasi tentang Bloomify
- Tombol untuk mulai belanja

#### 2. **Katalog Produk** (`/katalog`)
- Menampilkan semua produk yang tersedia (stok > 0)
- Filter berdasarkan kategori
- Grid layout yang responsif
- Info harga dan stok setiap produk

#### 3. **Detail Produk** (`/produk/{slug}`)
- Informasi lengkap produk
- Gambar produk yang besar
- Deskripsi lengkap
- Status ketersediaan
- Produk serupa dari kategori yang sama
- Tombol tambah ke keranjang (🚧 Dalam pengembangan)

#### 4. **Dashboard Pengguna** (`/dashboard`)
- Tampilan produk terbaru
- Manajemen profil
- Link ke halaman katalog
- (🚧 Statistik pesanan & keranjang: dalam pengembangan)

---

## 🎨 Desain & Tema

Bloomify menggunakan **Tailwind CSS** dengan palet warna Bloom yang elegan:

| Warna | Kode | Penggunaan |
|-------|------|-----------|
| Teal (Primary) | #6B9A94 | Navigasi, Button, Link |
| Coral (Accent) | #E89B94 | Tombol Action, Harga |
| Mint | #8FCB9E | Secondary Accent |
| Cream | #F5DDD0 | Background |
| Ivory | #FAF8F5 | Main Background |

---

## 🔄 Alur Data

### Saat Admin Menambah Produk:
1. Admin login ke `/admin-dashboard`
2. Buka menu **Produk** → **Tambah Produk**
3. Isi informasi produk + upload gambar
4. Klik **Simpan**
5. ✅ Produk langsung muncul di halaman katalog publik (`/katalog`)

### Pengguna Melihat Produk:
1. Pengguna membuka halaman beranda `/`
2. Klik **"Mulai Belanja"** atau **"Katalog"**
3. Melihat semua produk yang ditambahkan admin
4. Bisa filter berdasarkan kategori
5. Klik produk untuk melihat detail
6. Tombol tambah ke keranjang (🚧 fitur pembayaran: dalam pengembangan)

---

## 📁 Struktur Project

```
bloomify/
├── app/
│   ├── Filament/
│   │   ├── Resources/         # Filament Resources (ProductResource, CategoryResource)
│   │   ├── Pages/            # Filament Pages
│   │   └── Widgets/          # Filament Widgets
│   ├── Http/
│   │   ├── Controllers/      # Public & Admin Controllers
│   │   ├── Middleware/       # Custom Middleware (is_admin)
│   │   └── Requests/         # Form Requests
│   └── Models/               # Database Models
├── database/
│   ├── migrations/           # Database Schemas
│   └── seeders/             # Sample Data
├── resources/
│   ├── views/
│   │   ├── products/        # Product Views
│   │   ├── layouts/         # Main Layouts
│   │   └── vendor/          # Custom Components
│   ├── css/                 # Tailwind CSS
│   └── js/                  # JavaScript
├── routes/
│   ├── web.php             # Public Routes
│   └── auth.php            # Auth Routes
└── storage/
    └── app/public/         # Product Images
```

---

## 🔧 Troubleshooting

### Gambar Produk Tidak Muncul
```bash
# Buat symlink ke storage
php artisan storage:link
```

### Database Error
```bash
# Reset database
php artisan migrate:reset
php artisan migrate
php artisan db:seed
```

### Assets Tidak Ter-build
```bash
npm install
npm run build
```

### Port 8000 Sudah Digunakan
```bash
php artisan serve --port=8080
```

---

## 📝 Catatan Penting

1. **Gambar Produk**:
   - Ukuran maksimal: 5MB
   - Format: JPG, PNG, WebP
   - Rekomendasi: 600x600px atau lebih

2. **Harga**:
   - Input dalam Rupiah tanpa simbol
   - Contoh: 350000 (bukan Rp 350.000)

3. **Slug**:
   - Otomatis generate dari nama produk
   - Gunakan hyphens untuk pemisah kata
   - Contoh: "buket-mawar-merah" bukan "BuketMawarMerah"

4. **Stok**:
   - Produk hanya muncul di katalog jika stok > 0
   - Update stok otomatis via admin panel

---

## 🎯 Fitur Mendatang

- [ ] Shopping Cart & Checkout
- [ ] Payment Gateway (Midtrans/Stripe)
- [ ] Order Management
- [ ] Email Notifications
- [ ] Admin Reports & Analytics
- [ ] Customer Reviews & Ratings
- [ ] Wishlist
- [ ] Promo & Discount Codes

---

## 📞 Support

Untuk pertanyaan atau masalah, hubungi:
- **Email**: admin@bloomify.com
- **Support**: +62 812 3456 789

---

**Happy Selling! 🌸**
