PENGADUAN SARPRAS - VERSI SIAP JALAN

1. Ekstrak folder PENGADUAN_SARPRAS.
2. Jadikan folder PENGADUAN_SARPRAS sebagai document root/server folder.
3. Pastikan MariaDB/MySQL berjalan di port 3306.
4. Pastikan database db_sarpras sudah ada. File db_sarpras.sql juga disertakan jika perlu import ulang.
5. Default koneksi project:
   Host     : localhost
   Port     : 3306
   Database : db_sarpras
   Username : root
   Password : root

6. Tes koneksi terlebih dahulu:
   http://0.0.0.0:8080/db_test.php
   Jika tampil "Koneksi Berhasil", buka:
   http://0.0.0.0:8080/login.php

7. Jika password MySQL kamu bukan root, edit:
   model/Database.php
   lalu ubah:
   private $pass = 'root';

Login admin:
   username: admin
   password: admin123

Login siswa:
   gunakan NIS yang ada di tabel siswa, contoh: 10001

PENTING:
- Jangan buka controller/LoginController.php dari browser.
- Buka login.php atau index.php.


FITUR BARU: Mode Hitam Putih
Tekan tombol Hitam Putih di kanan atas dashboard. Pilihan tersimpan otomatis di browser.
