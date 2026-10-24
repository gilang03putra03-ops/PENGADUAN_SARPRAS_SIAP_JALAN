<?php
/**
 * Koneksi database Pengaduan Sarpras.
 * Default sesuai database project: root / root.
 */
class Database {
    private $host = '127.0.0.1';
    private $port = '3306';
    private $db = 'db_sarpras';
    private $user = 'root';
    private $pass = 'root';
    private $charset = 'utf8mb4';
    private $pdo = null;

    public function connect() {
        if ($this->pdo instanceof PDO) return $this->pdo;

        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db};charset={$this->charset}";
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            return $this->pdo;
        } catch (PDOException $e) {
            http_response_code(500);
            echo '<!doctype html><html lang="id"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">';
            echo '<style>body{font-family:Arial;background:#f5f7fb;padding:24px}.box{max-width:700px;margin:auto;background:#fff;padding:24px;border-radius:14px;box-shadow:0 4px 18px #0001}code{background:#eee;padding:3px 6px;border-radius:5px}.ok{color:#087f23}</style>';
            echo '<div class="box"><h2>Koneksi database gagal</h2>';
            echo '<p>Project sudah membaca <code>model/Database.php</code> yang baru.</p>';
            echo '<p>Host: <b>'.htmlspecialchars($this->host).'</b> | Port: <b>'.htmlspecialchars($this->port).'</b><br>Database: <b>'.htmlspecialchars($this->db).'</b> | User: <b>'.htmlspecialchars($this->user).'</b></p>';
            echo '<p>Error: <code>'.htmlspecialchars($e->getMessage()).'</code></p>';
            echo '<p>Jika password MySQL bukan <b>root</b>, buka <code>model/Database.php</code> lalu ubah <code>$pass</code>.</p>';
            echo '<p>Jika phpMyAdmin bisa masuk tetapi PHP tidak, gunakan host <code>localhost</code> seperti file ini.</p></div></html>';
            exit;
        }
    }
}
