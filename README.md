# Skill Exchange Platform

Platform berbagi dan pertukaran keahlian antar pengguna dengan fitur manajemen konten lengkap.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

---

## Deskripsi

**Skill Exchange** adalah aplikasi web yang memungkinkan pengguna untuk berbagi keahlian, mencari partner belajar, dan mengelola portofolio serta tujuan pembelajaran mereka. Aplikasi ini dilengkapi dengan panel admin untuk manajemen konten secara menyeluruh.

---

## Teknologi yang Digunakan

| Kategori               | Teknologi              |
| ---------------------- | ---------------------- |
| **Backend Framework**  | Laravel 12.x           |
| **Bahasa Pemrograman** | PHP 8.2+               |
| **Database**           | SQLite / MySQL         |
| **Authentication**     | Laravel Sanctum        |
| **Frontend**           | Blade Templates + Vite |
| **Styling**            | CSS                    |
| **Package Manager**    | Composer & NPM         |

---

## 6 Fitur CRUD Utama

### 1. **Posts (Postingan)**

Pengguna dapat membuat postingan untuk menawarkan atau mencari keahlian tertentu.

| Operasi    | Deskripsi                                                                                |
| ---------- | ---------------------------------------------------------------------------------------- |
| **Create** | Membuat postingan baru dengan tipe "open" (menawarkan skill) atau "need" (mencari skill) |
| **Read**   | Melihat daftar semua postingan di dashboard dengan filter dan pencarian                  |
| **Update** | Mengedit postingan yang sudah dibuat                                                     |
| **Delete** | Menghapus postingan sendiri atau oleh admin                                              |

---

### 2. **Portfolios (Portofolio)**

Showcase keahlian dan proyek yang pernah dikerjakan pengguna.

| Operasi    | Deskripsi                                                             |
| ---------- | --------------------------------------------------------------------- |
| **Create** | Menambah portofolio dengan judul, deskripsi, link, dan skills terkait |
| **Read**   | Melihat daftar portofolio di halaman profil                           |
| **Update** | Mengedit detail portofolio                                            |
| **Delete** | Menghapus portofolio beserta file terkait                             |

---

### 3. **Learning Goals (Tujuan Pembelajaran)**

Pengguna dapat menetapkan dan melacak target pembelajaran.

| Operasi    | Deskripsi                                                            |
| ---------- | -------------------------------------------------------------------- |
| **Create** | Membuat tujuan pembelajaran baru dengan target tanggal dan status    |
| **Read**   | Melihat daftar tujuan pembelajaran dengan filter status              |
| **Update** | Mengupdate progress dan status (not_started, in_progress, completed) |
| **Delete** | Menghapus tujuan pembelajaran                                        |

---

### 4. **Skills (Keahlian)**

Manajemen keahlian/skill yang tersedia di platform (Admin Only).

| Operasi    | Deskripsi                                          |
| ---------- | -------------------------------------------------- |
| **Create** | Admin menambah skill baru dengan nama dan kategori |
| **Read**   | Melihat daftar semua skills yang tersedia          |
| **Update** | Admin mengedit detail skill                        |
| **Delete** | Admin menghapus skill (jika tidak digunakan)       |

---

### 5. **Topics (Topik)**

Kategori topik untuk mengelompokkan postingan (Admin Only).

| Operasi    | Deskripsi                   |
| ---------- | --------------------------- |
| **Create** | Admin membuat topik baru    |
| **Read**   | Melihat daftar semua topik  |
| **Update** | Admin mengedit detail topik |
| **Delete** | Admin menghapus topik       |

---

### 6. **Users (Pengguna)**

Manajemen akun pengguna oleh administrator.

| Operasi    | Deskripsi                                             |
| ---------- | ----------------------------------------------------- |
| **Create** | Admin membuat akun pengguna baru                      |
| **Read**   | Admin melihat daftar semua pengguna                   |
| **Update** | Admin mengedit data pengguna (nama, email, role, dll) |
| **Delete** | Admin menghapus akun pengguna                         |

---

### Alur Pengguna Biasa:

1. **Register/Login** - Buat akun atau masuk ke sistem
2. **Dashboard** - Lihat semua postingan dari pengguna lain
3. **Create Post** - Buat postingan untuk menawarkan atau mencari skill
4. **Profile** - Kelola profil, tambah portfolio, dan kelola skills pribadi
5. **Learning Goals** - Tetapkan dan lacak target pembelajaran

### Alur Administrator:

1. **Login** - Masuk dengan akun admin
2. **Admin Dashboard** - Lihat statistik platform
3. **Manage Data** - Kelola users, posts, portfolios, skills, dan topics

---

## 📁 Struktur Folder Utama

```
skill-exchange/
├── App/
│   ├── Http/Controllers/     # Controller untuk logic aplikasi
│   ├── Models/               # Model Eloquent (User, Post, Skill, dll)
│   └── ...
├── database/
│   ├── migrations/           # File migrasi database
│   └── seeders/              # Seeder untuk data awal
├── resources/
│   └── views/                # Blade templates
├── routes/
│   └── web.php               # Definisi routing
└── public/                   # Assets publik
```

---

## 🔐 Akun Default (Setelah Seeding)

| Role  | Email                    | Password |
| ----- | ------------------------ | -------- |
| Admin | admin@skillexchange.test | password |

---

## 🛠️ Troubleshooting

### Reset Database (Database Lama Bermasalah)

**Kapan Menggunakan:**

-   Database dari versi project sebelumnya masih ada dan menyebabkan konflik
-   Migration gagal karena struktur database lama berbeda
-   Ingin memulai dengan database bersih (fresh install)
-   Terjadi error saat menjalankan `php artisan migrate`

**Solusi:**

```bash
# Reset database dan jalankan semua migration dari awal + seeder
php artisan migrate:fresh --seed
```

**Apa yang Dilakukan Command Ini:**

1. ✅ **Drop semua table** yang ada di database (hapus struktur lama)
2. ✅ **Jalankan semua migration** dari awal (struktur bersih sesuai project terbaru)
3. ✅ **Jalankan seeder** untuk mengisi data dummy dan akun admin default

> ⚠️ **Peringatan:** Command ini akan **menghapus semua data** di database. Gunakan hanya untuk development, **JANGAN** di production!

**Alternatif (Jika Mau Manual):**

```bash
# Opsi 1: Via MySQL Command Line
mysql -u root -p
DROP DATABASE db_skill_exchange;
CREATE DATABASE db_skill_exchange;
EXIT;

php artisan migrate --seed

# Opsi 2: Hanya reset migration (tanpa drop database)
php artisan migrate:refresh --seed
```

---

## 📄 REST API Endpoints

Aplikasi ini juga menyediakan REST API untuk akses data secara programmatic:

| Endpoint              | Method | Deskripsi                   |
| --------------------- | ------ | --------------------------- |
| `/api/posts`          | GET    | Daftar semua postingan      |
| `/api/portfolios`     | GET    | Daftar semua portofolio     |
| `/api/learning-goals` | GET    | Daftar semua learning goals |
| `/api/users`          | GET    | Daftar semua pengguna       |
| `/api/skills`         | GET    | Daftar semua skills         |
| `/api/topics`         | GET    | Daftar semua topics         |

---
