<?php
require_once __DIR__ . '/Database.php';
class Siswa {
    private $db;
    public function __construct() { $this->db = (new Database())->connect(); }
    public function find($nis) {
        $stmt = $this->db->prepare('SELECT nis, kelas FROM siswa WHERE nis = ? LIMIT 1');
        $stmt->execute(array($nis));
        return $stmt->fetch();
    }
    public function all() {
        return $this->db->query('SELECT nis, kelas FROM siswa ORDER BY nis')->fetchAll();
    }
}
