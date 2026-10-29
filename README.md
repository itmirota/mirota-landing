# PT Mirota KSM — Corporate Website Revitalization

Modernisasi website perusahaan PT Mirota KSM untuk menghadirkan informasi perusahaan, produk, layanan maklon, peluang karier, dan informasi lainnya melalui platform web yang modern, responsif, dan mudah dikelola.

## 📌 Tentang Proyek

Proyek ini merupakan pengembangan dan revitalisasi website korporat PT Mirota KSM dengan fokus pada peningkatan pengalaman pengguna, penyajian informasi perusahaan, serta kemudahan pengelolaan konten.

Website dirancang untuk menjadi pusat informasi digital perusahaan yang dapat diakses oleh pelanggan, mitra bisnis, calon karyawan, dan masyarakat umum.

### Tujuan

- Memperbarui tampilan dan pengalaman pengguna website perusahaan.
- Menyajikan informasi perusahaan dan katalog produk secara terstruktur.
- Mempermudah calon mitra dalam mengakses informasi layanan maklon.
- Menyediakan informasi kunjungan industri dan peluang karier.
- Mengembangkan sistem administrasi untuk mendukung pengelolaan konten website.
- Membangun fondasi aplikasi yang mudah dikembangkan dan dipelihara.

## ✨ Fitur Utama

### Public Website

- **Homepage** — halaman utama untuk memperkenalkan perusahaan dan informasi penting.
- **Produk** — menampilkan katalog produk beserta halaman detailnya.
- **Layanan Maklon** — menyediakan informasi dan formulir permintaan layanan maklon.
- **Kunjungan Industri** — menyediakan informasi terkait kunjungan industri.
- **Karier** — menampilkan informasi peluang karier di perusahaan.

### Administration Panel

- **Superadmin** — pengelolaan administrasi dengan cakupan akses tertinggi.
- **Feature-based Admin** — pembagian akses administrasi berdasarkan fitur atau tanggung jawab pengelolaan.

> Catatan: daftar fitur menggambarkan cakupan pengembangan yang direncanakan atau sedang dibangun. Status implementasi setiap fitur perlu disesuaikan dengan kondisi terbaru repository.

## 🛠️ Tech Stack

| Teknologi | Versi / Standar | Penggunaan |
|---|---|---|
| PHP | 8.3.x (standar tim) | Bahasa pemrograman backend |
| Laravel | 12.x | Framework aplikasi web |
| Blade | Laravel 12 | Template engine |
| Tailwind CSS | Sesuai `package.json` | Styling dan antarmuka responsif |
| Vite | Sesuai `package.json` | Asset bundling dan development server |
| Database | Sesuai konfigurasi proyek | Penyimpanan data aplikasi |
| Composer | Versi yang kompatibel | Dependency management PHP |
| Node.js & npm | Sesuai kebutuhan Vite | Dependency management frontend |
| Git & GitHub | Sesuai workflow tim | Version control dan kolaborasi |

> **Environment consistency:** Seluruh anggota tim wajib menggunakan versi runtime dan dependency yang kompatibel dengan konfigurasi proyek. Perubahan versi utama harus melalui kesepakatan tim dan pengujian sebelum diterapkan.

## 📂 Project Structure

Struktur utama aplikasi Laravel:

```text
project-root/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   └── web.php
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

Struktur tersebut merupakan gambaran umum Laravel. Detail direktori dan file dapat berbeda mengikuti implementasi aktual proyek.

## ⚙️ Installation & Setup

### Prerequisites

Pastikan lingkungan pengembangan sudah memiliki:

- PHP dengan versi yang kompatibel dengan Laravel 12.
- Composer.
- Node.js dan npm.
- Database yang sesuai dengan konfigurasi aplikasi, jika diperlukan.
- Git.

### 1. Clone Repository

```bash
git clone <REPOSITORY_URL>
cd <PROJECT_DIRECTORY>
```

Ganti placeholder dengan URL repository dan nama direktori yang sebenarnya.

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Configure Environment

Salin file environment contoh jika tersedia:

```bash
cp .env.example .env
```

Pada Windows, file tersebut juga dapat disalin melalui File Explorer.

Sesuaikan konfigurasi `.env`, termasuk pengaturan aplikasi dan database jika digunakan.

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Prepare Database

Jika proyek menggunakan database dan migration Laravel:

```bash
php artisan migrate
```

Jalankan seeder hanya apabila seeder yang dibutuhkan telah tersedia dan dikonfigurasi.

### 6. Run the Application

Jalankan backend Laravel:

```bash
php artisan serve
```

Pada terminal terpisah, jalankan Vite:

```bash
npm run dev
```

Buka alamat lokal yang ditampilkan oleh Laravel development server di browser.

### Production Build

Untuk membuat build aset frontend:

```bash
npm run build
```

**Penting:** Perintah setup di atas merupakan panduan umum Laravel. Sesuaikan dengan konfigurasi aktual proyek sebelum digunakan sebagai instruksi resmi.

## 🔐 Environment & Security

- Jangan mengunggah file `.env` atau kredensial ke repository.
- Gunakan `.env.example` untuk mendokumentasikan variabel konfigurasi tanpa nilai rahasia.
- Jangan menyimpan password, API key, token, atau kredensial database di dalam source code.
- Pastikan autentikasi dan otorisasi diterapkan sesuai peran pengguna.
- Lakukan validasi input dan pengujian akses sebelum deployment.

## 🧪 Testing

Pengujian dilakukan untuk memastikan fungsi aplikasi berjalan sesuai kebutuhan.

Contoh perintah pengujian Laravel:

```bash
php artisan test
```

Cakupan pengujian dapat meliputi:

- Navigasi dan tampilan halaman publik.
- Pengambilan dan penyajian data produk.
- Validasi formulir.
- Autentikasi administrator.
- Pembatasan akses berdasarkan peran.
- Pengelolaan konten melalui panel administrasi.

Daftar di atas merupakan cakupan pengujian yang disarankan, bukan pernyataan bahwa seluruh pengujian telah selesai dilaksanakan.

## 🚀 Development Workflow

Pengembangan proyek dilakukan melalui tahapan berikut:

1. **Discovery & Audit** — memahami kondisi website dan kebutuhan pengguna.
2. **Planning** — menetapkan ruang lingkup, prioritas, dan kebutuhan fungsional.
3. **Design** — merancang struktur halaman dan pengalaman pengguna.
4. **Development** — mengimplementasikan frontend dan backend.
5. **Testing** — memvalidasi fungsi, keamanan, dan responsivitas.
6. **Deployment** — menyiapkan dan merilis aplikasi ke lingkungan produksi.
7. **Maintenance** — melakukan pemantauan, perbaikan, dan pengembangan lanjutan.

Perubahan kode dikelola menggunakan Git agar riwayat pengembangan dapat ditelusuri dan kolaborasi lebih terstruktur.

## 🗺️ Roadmap

Roadmap berikut dapat digunakan untuk mencatat perkembangan proyek:

- [x] Inisialisasi dan pengembangan dasar aplikasi
- [ ] Penyelesaian seluruh halaman website publik
- [ ] Penyelesaian sistem administrasi dan pembagian hak akses
- [ ] Integrasi serta validasi data
- [ ] Pengujian fungsional dan keamanan
- [ ] Optimasi performa dan responsivitas
- [ ] Deployment ke lingkungan produksi
- [ ] Dokumentasi teknis dan pemeliharaan

Perbarui status checklist sesuai progres aktual. Item yang belum selesai tidak perlu ditandai sebagai completed hanya karena sudah direncanakan.

## 👨‍💻 Project Role

Proyek ini juga menjadi sarana penerapan praktik pengembangan perangkat lunak yang lebih terstruktur, termasuk perencanaan proyek, dokumentasi kebutuhan, pengelolaan source code, pembagian tugas, code review, dan pengujian.

**Project Lead / Developer:** Tri Cahya Wibawa

**Team:** Tim Magang PT Mirota KSM

**Organization:** PT Mirota KSM

**Project Type:** Corporate Website Revitalization

## 📄 License & Usage

Proyek ini dikembangkan untuk kebutuhan revitalisasi website korporat PT Mirota KSM.

Hak penggunaan, distribusi, dan publikasi source code mengikuti kebijakan serta ketentuan yang berlaku di perusahaan. Jangan mengasumsikan bahwa source code dapat digunakan ulang atau didistribusikan secara bebas tanpa izin yang sesuai.

---

*Built with Laravel 12 for the continued development of PT Mirota KSM's digital presence.*
