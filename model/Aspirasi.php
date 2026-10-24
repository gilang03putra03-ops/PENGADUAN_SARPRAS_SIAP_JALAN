<?php
require_once __DIR__ . '/Database.php';
class Aspirasi {
    private $db;
    public function __construct() { $this->db = (new Database())->connect(); }

    public function all() {
        $sql = "SELECT a.id_aspirasi, a.status, a.feedback, ia.nis, ia.lokasi, ia.ket,
                       k.ket_kategori, s.kelas
                FROM aspirasi a
                LEFT JOIN input_aspirasi ia ON ia.id_pelaporan = a.id_aspirasi
                LEFT JOIN kategori k ON k.id_kategori = a.id_kategori
                LEFT JOIN siswa s ON s.nis = ia.nis
                ORDER BY a.id_aspirasi DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function bySiswa($nis) {
        $sql = "SELECT a.id_aspirasi, a.status, a.feedback, ia.nis, ia.lokasi, ia.ket,
                       k.ket_kategori, s.kelas
                FROM aspirasi a
                INNER JOIN input_aspirasi ia ON ia.id_pelaporan = a.id_aspirasi
                LEFT JOIN kategori k ON k.id_kategori = a.id_kategori
                LEFT JOIN siswa s ON s.nis = ia.nis
                WHERE ia.nis = ?
                ORDER BY a.id_aspirasi DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($nis));
        return $stmt->fetchAll();
    }

    public function find($id) {
        $sql = "SELECT a.id_aspirasi, a.status, a.feedback, ia.nis, ia.lokasi, ia.ket,
                       k.ket_kategori, s.kelas
                FROM aspirasi a
                LEFT JOIN input_aspirasi ia ON ia.id_pelaporan = a.id_aspirasi
                LEFT JOIN kategori k ON k.id_kategori = a.id_kategori
                LEFT JOIN siswa s ON s.nis = ia.nis
                WHERE a.id_aspirasi = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE aspirasi SET status = ? WHERE id_aspirasi = ?");
        return $stmt->execute(array($status, $id));
    }

    public function updateFeedback($id, $feedback) {
        $stmt = $this->db->prepare('UPDATE aspirasi SET feedback = ? WHERE id_aspirasi = ?');
        return $stmt->execute(array($feedback, $id));
    }

    public function stats() {
        $result = array('total'=>0, 'menunggu'=>0, 'proses'=>0, 'selesai'=>0);
        $rows = $this->db->query('SELECT status, COUNT(*) jumlah FROM aspirasi GROUP BY status')->fetchAll();
        foreach ($rows as $row) {
            $result['total'] += (int)$row['jumlah'];
            if ($row['status'] === 'Menunggu') $result['menunggu'] = (int)$row['jumlah'];
            if ($row['status'] === 'Proses') $result['proses'] = (int)$row['jumlah'];
            if ($row['status'] === 'Selesai') $result['selesai'] = (int)$row['jumlah'];
        }
        return $result;
    }
}
