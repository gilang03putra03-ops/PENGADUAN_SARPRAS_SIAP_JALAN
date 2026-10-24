<?php
require_once __DIR__ . '/model/Database.php';
try {
    $db = (new Database())->connect();
    $dbName = $db->query('SELECT DATABASE()')->fetchColumn();
    echo '<!doctype html><html lang="id"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">';
    echo '<style>body{font-family:Arial;background:#f5f7fb;padding:25px}.box{max-width:600px;margin:auto;background:#fff;padding:25px;border-radius:15px;text-align:center;box-shadow:0 5px 20px #0001}.ok{color:#148a38}</style>';
    echo '<div class="box"><h1 class="ok">✓ Koneksi Berhasil</h1><p>PHP sudah terhubung ke database <b>'.htmlspecialchars($dbName).'</b>.</p><p><a href="login.php">Buka halaman login</a></p></div></html>';
} catch (Throwable $e) { echo 'Gagal: '.htmlspecialchars($e->getMessage()); }
