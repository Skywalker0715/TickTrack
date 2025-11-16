# TickTrack - Sistem Manajemen Tiket

TickTrack adalah aplikasi web modern untuk manajemen tiket yang memungkinkan pengguna melaporkan masalah, mengikuti status penyelesaian, dan berkomunikasi dengan tim dukungan. Aplikasi ini dibangun dengan arsitektur full-stack menggunakan Laravel untuk backend API dan Vue.js untuk frontend.

## 🎯 Tujuan Aplikasi

TickTrack dirancang untuk menyelesaikan masalah umum dalam manajemen dukungan pelanggan dan pengelolaan masalah internal perusahaan, yaitu:

- **Pelacakan Masalah Terstruktur**: Sistem yang terorganisir untuk melacak setiap laporan masalah dari awal hingga penyelesaian
- **Komunikasi Efisien**: Platform komunikasi terpusat antara pelapor dan penyelesai masalah
- **Monitoring Real-time**: Dashboard untuk memantau status dan performa penyelesaian tiket
- **Manajemen Prioritas**: Sistem prioritas untuk mengatur urgensi penanganan masalah

## 🛠️ Masalah yang Diatasi

### Masalah Tradisional:
- **Komunikasi Terfragmentasi**: Email dan telepon yang sulit dilacak historinya
- **Kurangnya Transparansi**: Pelapor tidak tahu status penyelesaian masalah
- **Kesulitan Monitoring**: Sulit memantau performa tim dukungan
- **Data Tersebar**: Informasi tiket tersimpan di berbagai tempat

### Solusi TickTrack:
- **Sistem Tiket Terpusat**: Semua komunikasi dan status dalam satu platform
- **Status Real-time**: Pelapor dapat melihat progress penyelesaian secara langsung
- **Dashboard Analytics**: Statistik lengkap untuk monitoring performa
- **Role-based Access**: Pemisahan akses antara user biasa dan admin

## 🚀 Fitur Utama

### Untuk Pengguna (User):
- ✅ Registrasi dan login
- ✅ Membuat tiket baru dengan judul, deskripsi, dan prioritas
- ✅ Melihat daftar tiket pribadi dengan filter pencarian
- ✅ Melihat detail tiket dan riwayat komunikasi
- ✅ Membalas pesan dari admin
- ✅ Monitoring status tiket (Open → On Progress → Resolved/Rejected)

### Untuk Admin:
- ✅ Dashboard dengan statistik lengkap
- ✅ Melihat semua tiket dari semua pengguna
- ✅ Filter tiket berdasarkan status, prioritas, dan pencarian
- ✅ Mengubah status tiket
- ✅ Membalas tiket pengguna
- ✅ Monitoring performa penyelesaian tiket

## 🏗️ Arsitektur & Teknologi

### Backend API (Laravel):
- **Framework**: Laravel 12.x
- **Bahasa**: PHP 8.2+
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Sanctum
- **API Structure**: RESTful API dengan Resource

### Frontend Client (Vue.js):
- **Framework**: Vue 3 dengan Composition API
- **Router**: Vue Router 4
- **State Management**: Pinia
- **HTTP Client**: Axios
- **UI Components**: Custom components dengan Tailwind CSS
- **Icons**: Feather Icons
- **Charts**: Chart.js untuk dashboard admin

### Database Schema:
- **Users**: Informasi pengguna dengan role (user/admin)
- **Tickets**: Data tiket dengan status dan prioritas
- **Ticket Replies**: Riwayat komunikasi pada setiap tiket

## ⚡ Tantangan Teknis & Solusi

### Tantangan 1: State Management Kompleks
**Masalah**: Sinkronisasi state antara komponen Vue dan API calls
**Solusi**: Implementasi Pinia stores terstruktur dengan actions async

### Tantangan 2: Authentication & Authorization
**Masalah**: Perlindungan route dan API berdasarkan role
**Solusi**: Middleware Laravel Sanctum + route guards Vue Router

### Tantangan 3: Real-time Updates
**Masalah**: User perlu melihat update status tanpa refresh
**Solusi**: Polling periodik + optimistic updates pada UI

### Tantangan 4: Responsive Design
**Masalah**: UI yang konsisten di desktop dan mobile
**Solusi**: Tailwind CSS dengan grid system dan mobile-first approach

### Tantangan 5: Error Handling
**Masalah**: Menangani berbagai error dari API dan user input
**Solusi**: Centralized error handling dengan toast notifications

## 📋 Prasyarat Sistem

- **PHP**: 8.2 atau lebih tinggi
- **Composer**: 2.x
- **Node.js**: 18.x atau lebih tinggi
- **NPM**: 8.x atau lebih tinggi
- **Database**: MySQL 8.0 / PostgreSQL 13+ / SQLite 3+

## 🚀 Instalasi & Setup

### 1. Clone Repository
```bash
git clone https://github.com/username/ticktrack.git
cd ticktrack
```

### 2. Setup Backend (Laravel API)

#### Install Dependencies PHP
```bash
cd api-tick-track
composer install
```

#### Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

#### Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticktrack
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### Migrasi Database
```bash
php artisan migrate
php artisan db:seed  # Optional: untuk data dummy
```

#### Generate Passport Keys (jika menggunakan OAuth)
```bash
php artisan passport:install
```

### 3. Setup Frontend (Vue.js Client)

#### Install Dependencies Node.js
```bash
cd ../client
npm install
```

#### Environment Setup
Edit file `.env` (jika ada) atau konfigurasi API base URL di `src/plugins/axios.js`:
```javascript
// src/plugins/axios.js
const apiClient = axios.create({
  baseURL: 'http://localhost:8000/api', // URL backend API
  // ...
});
```

### 4. Menjalankan Aplikasi

#### Development Mode (Recommended)
```bash
# Terminal 1: Backend API
cd api-tick-track
php artisan serve

# Terminal 2: Frontend Client
cd client
npm run dev
```

#### Atau menggunakan script Laravel Sail (Docker)
```bash
cd api-tick-track
./vendor/bin/sail up
```

#### Production Build
```bash
# Build frontend
cd client
npm run build

# Serve backend dengan assets
cd ../api-tick-track
php artisan serve
```

### 5. Akses Aplikasi

- **Frontend**: http://localhost:5173 (development) atau http://localhost:8000 (production)
- **Backend API**: http://localhost:8000/api
- **Admin Dashboard**: /admin setelah login sebagai admin

## 🔧 Konfigurasi Tambahan

### Email Configuration (untuk notifikasi)
Edit `.env` di folder `api-tick-track`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email
MAIL_FROM_NAME="TickTrack Support"
```

### File Upload Configuration
```env
FILESYSTEM_DISK=public
# atau untuk cloud storage
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket
```

## 📊 Testing

### Backend Tests
```bash
cd api-tick-track
php artisan test
```

### Frontend Tests (jika ada)
```bash
cd client
npm run test
```

## 🚀 Deployment

### Production Checklist:
- [ ] Set `APP_ENV=production` di `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Konfigurasi proper database credentials
- [ ] Setup web server (Apache/Nginx) dengan proper permissions
- [ ] Install SSL certificate
- [ ] Setup queue worker untuk background jobs
- [ ] Configure caching (Redis/Memcached)
- [ ] Setup log monitoring

### Contoh Nginx Configuration:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/ticktrack/api-tick-track/public;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location /api {
        proxy_pass http://127.0.0.1:8000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}
```

## 🤝 Contributing

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 License

Distributed under the MIT License. See `LICENSE` for more information.

## 📞 Support

Jika Anda mengalami masalah atau memiliki pertanyaan:

- Buat issue di GitHub repository ini
- Email: support@ticktrack.com
- Dokumentasi lengkap: [Link ke dokumentasi]

## 🙏 Acknowledgments

- Laravel Framework
- Vue.js Ecosystem
- Tailwind CSS
- Chart.js
- Feather Icons
- Dan komunitas open source lainnya

---

**TickTrack** - Membuat manajemen tiket menjadi lebih mudah dan efisien! 🎫✨
