<?php
require_once __DIR__ . '/../model/Aspirasi.php';
class SiswaController {
    public function dashboard($nis) {
        $model = new Aspirasi();
        return array('pengaduan' => $model->bySiswa($nis));
    }
}
