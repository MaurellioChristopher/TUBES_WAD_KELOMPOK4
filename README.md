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

## Struktur Folder Utama

```
skill-exchange/
├── App/
│   ├── Http/Controllers/     
│   ├── Models/               
│   └── ...
├── database/
│   ├── migrations/           
│   └── seeders/              
├── resources/
│   └── views/                
├── routes/
│   └── web.php               
└── public/                   
```

---

## Akun Default (Setelah Seeding)

| Role  | Email                    | Password |
| ----- | ------------------------ | -------- |
| Admin | admin@skillexchange.test | password |

---

## REST API Endpoints

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
