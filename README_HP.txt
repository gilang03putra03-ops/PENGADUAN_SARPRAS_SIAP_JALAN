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
