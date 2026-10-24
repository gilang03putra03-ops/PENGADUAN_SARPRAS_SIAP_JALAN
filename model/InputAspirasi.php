<?php
require_once __DIR__ . '/Database.php';
class InputAspirasi {
    private $db;
    public function __construct() { $this->db = (new Database())->connect(); }

    public function create($nis, $idKategori, $lokasi, $ket) {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare('INSERT INTO input_aspirasi (nis, id_kategori, lokasi, ket) VALUES (?, ?, ?, ?)');
            $stmt->execute(array($nis, $idKategori, $lokasi, $ket));
            $id = (int)$this->db->lastInsertId();

            // Database asli tidak memiliki FK antara input_aspirasi dan aspirasi.
            // ID dibuat sama agar kedua tabel tetap dapat dihubungkan oleh aplikasi.
            $stmt2 = $this->db->prepare("INSERT INTO aspirasi (id_aspirasi, status, id_kategori, feedback) VALUES (?, 'Menunggu', ?, NULL)");
            $stmt2->execute(array($id, $idKategori));
            $this->db->commit();
            return $id;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
