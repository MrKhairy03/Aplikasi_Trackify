# Trackify (Laravel) — Activity Analytics Dashboard

Trackify adalah aplikasi *activity analytics dashboard* berbasis **Laravel** untuk mencatat dan menganalisis aktivitas pengguna secara **realtime**.  
Sistem ini merekam aktivitas seperti **login, logout, akses halaman, dan filter data**, lalu menyajikannya dalam bentuk **dashboard analitik** berupa *statistic cards, area chart, pie chart, dan progress bar*.

Seluruh perhitungan dilakukan di **level database** (tanpa looping PHP) dengan dukungan **filter rentang waktu dan action**, sehingga efisien, scalable, dan siap digunakan sebagai sistem monitoring aktivitas pengguna.

---

## Fitur Utama

### Activity Logging (Realtime)
- Pencatatan aktivitas pengguna secara otomatis:
  - `login`
  - `logout`
  - `view_dashboard`
  - `view_activities`
  - `filter_dashboard`
- Logging dilakukan secara terpusat menggunakan:
  - Service (`ActivityLogger`)
  - Event Listener (Login & Logout)
  - Middleware (View halaman)
- Mekanisme anti-duplicate logging untuk mencegah event tercatat ganda.

---

### Dashboard Analitik
- **Statistic Cards**
  - Total Activities
  - Total Active Users
  - Total Action Types
  - Aktivitas terbanyak oleh user
- **Area Chart**
  - Total activity per hari
  - Default 7 hari terakhir
  - Menyesuaikan filter rentang waktu
- **Pie Chart**
  - Top 5 user paling aktif
  - Berdasarkan jumlah aktivitas
- **Progress Bar**
  - Top 3 action terbanyak
  - Persentase dihitung dari total activity

---

### Filtering & Analisis
- Filter berdasarkan:
  - Rentang waktu (`from` – `to`)
  - Action (opsional)
- Semua filter memengaruhi:
  - Statistic cards
  - Area chart
  - Pie chart
  - Progress bar
- Seluruh perhitungan dilakukan di query database (GROUP BY, COUNT).

---

## Teknologi
- Laravel 12
- PHP 8+
- MySQL / MariaDB
- Bootstrap (SB Admin 2 Template)
- Chart.js

---

## Setup & Menjalankan Project

### 1) Clone Repository
git clone https://github.com/MrKhairy03/Aplikasi_Trackify.git
cd Trackify


### 2) Install Dependency
composer install
npm install
npm run build

### 3) Buat Environment
cp .env.example .env
php artisan key:generate

### 4) Konfigurasi Database
DB_DATABASE=trackify
DB_USERNAME=root
DB_PASSWORD=

### 5) Migrasi & Seeder
php artisan migrate --seed
Seeder akan menyiapkan:
- User dummy
- Data aktivitas (±10.000 data)
- Berbagai jenis action untuk kebutuhan analitik

### 6) Jalankan Aplikasi
php artisan serve

---

## Struktur Project

- `app/Http/Controllers/`
  - `DashboardController.php` → statistik, filter, chart, progress bar
  - `ActivitiesController.php` → list data aktivitas
- `app/Models/`
  - `Activities.php` → model aktivitas + relasi  `user`
- `app/Services/`
  - `ActivityLogger.php` → service logging terpusat
- `app/Listeners/`
  - `LogLoginActivity.php`
  - `LogLogoutActivity.php`
- `app/Http/Middleware/`
  - `LogViewActivity.php`
- `resources/views/environments/`
  - `dashboard/` → halaman utama, dashboard analitik
  - `activities` → halaman data aktivitas
- `public/assets/js/dashboard/`
  - `chart-area.js/`
  - `chart-pie.js/`

---

## Business Rule (Ringkas)

- Semua aktivitas dicatat otomatis tanpa manual insert di controller
- Login & Logout dicatat melalui event listener
- Akses halaman dicatat melalui middleware
- Filter dashboard dicatat saat query parameter digunakan
- Seluruh statistik dihitung di level database
- Duplicate logging dicegah menggunakan cache singkat

---

## Testing & Analisis

### Skenario Pengujian
- Login user → activity login tercatat
- Akses dashboard → view_dashboard tercatat
- Menggunakan filter → filter_dashboard tercatat
- Akses halaman activities → view_activities tercatat
- Logout user → logout tercatat
- Refresh halaman → tidak terjadi duplicate log

### Verifikasi Data
- php artisan tinker
- App\Models\Activities::latest()->take(10)->get();

---

## Catatan Teknis

- Project ini menggunakan pendekatan service + event + middleware
- Logging dibuat terpusat agar mudah dikembangkan dan tidak mencemari business logic
- Struktur siap untuk dikembangkan ke skala analitik yang lebih besar
