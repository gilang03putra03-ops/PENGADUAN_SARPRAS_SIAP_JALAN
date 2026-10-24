<?php
require_once __DIR__ . '/../model/Aspirasi.php';
require_once __DIR__ . '/../model/InputAspirasi.php';
require_once __DIR__ . '/../model/Kategori.php';

class AspirasiController {
    public function create($nis, $kategori, $lokasi, $ket) {
        return (new InputAspirasi())->create($nis, $kategori, $lokasi, $ket);
    }
    public function all() { return (new Aspirasi())->all(); }
    public function mine($nis) { return (new Aspirasi())->bySiswa($nis); }
    public function find($id) { return (new Aspirasi())->find($id); }
    public function updateStatus($id, $status) { return (new Aspirasi())->updateStatus($id, $status); }
    public function updateFeedback($id, $feedback) { return (new Aspirasi())->updateFeedback($id, $feedback); }
}
