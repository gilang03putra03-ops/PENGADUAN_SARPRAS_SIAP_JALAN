<?php
require_once __DIR__ . '/../model/Kategori.php';
class KategoriController {
    public function all() { return (new Kategori())->all(); }
    public function create($nama) { return (new Kategori())->create($nama); }
    public function update($id, $nama) { return (new Kategori())->update($id, $nama); }
    public function delete($id) { return (new Kategori())->delete($id); }
}
