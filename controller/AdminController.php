<?php
require_once __DIR__ . '/../model/Aspirasi.php';
require_once __DIR__ . '/../model/Kategori.php';
class AdminController {
    public function dashboard() {
        $model = new Aspirasi();
        return array('stats' => $model->stats(), 'recent' => array_slice($model->all(), 0, 5));
    }
}
