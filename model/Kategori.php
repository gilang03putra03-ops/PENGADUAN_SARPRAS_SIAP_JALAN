<?php
require_once __DIR__ . '/Database.php';
class Kategori {
    private $db;
    public function __construct() { $this->db = (new Database())->connect(); }
    public function all() { return $this->db->query('SELECT * FROM kategori ORDER BY id_kategori')->fetchAll(); }
    public function find($id) {
        $stmt = $this->db->prepare('SELECT * FROM kategori WHERE id_kategori = ?');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }
    public function create($nama) {
        $stmt = $this->db->prepare('INSERT INTO kategori (ket_kategori) VALUES (?)');
        return $stmt->execute(array($nama));
    }
    public function update($id, $nama) {
        $stmt = $this->db->prepare('UPDATE kategori SET ket_kategori = ? WHERE id_kategori = ?');
        return $stmt->execute(array($nama, $id));
    }
    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM kategori WHERE id_kategori = ?');
        return $stmt->execute(array($id));
    }
}
