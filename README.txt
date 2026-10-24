PENGADUAN SARPRAS SEKOLAH - MVC PHP

1. Buat database MySQL bernama db_sarpras.
2. Import file db_sarpras.sql dari database asli yang diberikan.
3. Salin folder PENGADUAN_SARPRAS ke htdocs XAMPP.
4. Jika username/password MySQL berbeda, edit model/Database.php.
5. Buka http://localhost/PENGADUAN_SARPRAS/login.php

LOGIN ADMIN:
username: admin
password: admin123

LOGIN SISWA:
Masukkan NIS yang ada di tabel siswa, contoh: 10001

Catatan:
Database asli memiliki tabel input_aspirasi dan aspirasi tanpa foreign key langsung di antara keduanya. Aplikasi ini menyamakan id_pelaporan dengan id_aspirasi saat membuat pengaduan baru agar status dapat dihubungkan.
PENGADUAN SARPRAS - VERSI HP ANDROID

1. Extract folder PENGADUAN_SARPRAS.
2. Import db_sarpras.sql ke MySQL/MariaDB di HP.
3. Pastikan MySQL/MariaDB berjalan pada port 3306.
4. Buka model/Database.php.
5. Jika MySQL root TANPA password:
      private $pass = '';
   Jika memakai password, isi:
      private $pass = 'PASSWORD_MYSQL';
6. Jalankan PHP server pada HP, lalu buka alamat servernya.

Konfigurasi default:
Host     = 127.0.0.1
Port     = 3306
Database = db_sarpras
User     = root
Password = kosong

Jika kamu menggunakan Termux:
- Jalankan MariaDB/MySQL terlebih dahulu.
- Pastikan database db_sarpras sudah dibuat/import.
- Pastikan server menerima koneksi TCP pada 127.0.0.1:3306.

Jika PHP server dan MySQL berada di aplikasi Android yang berbeda dan 127.0.0.1 tidak bisa dipakai, gunakan alamat IP/host MySQL yang benar pada Database.php.
