<?php
session_start();
if (empty($_SESSION['login'])) { header('Location: login.php'); exit; }

$page = isset($_GET['page']) ? $_GET['page'] : ($_SESSION['role'] === 'admin' ? 'admin' : 'siswa');
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

function e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function requireRole($role) { if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) { header('Location: index.php'); exit; } }

require_once __DIR__ . '/controller/AspirasiController.php';
require_once __DIR__ . '/controller/KategoriController.php';
require_once __DIR__ . '/controller/AdminController.php';

if ($page === 'admin') requireRole('admin');
if ($page === 'siswa') requireRole('siswa');

$message = '';
$error = '';

if ($page === 'siswa' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan_pengaduan'])) {
    try {
        (new AspirasiController())->create($_SESSION['nis'], (int)$_POST['id_kategori'], trim($_POST['lokasi']), trim($_POST['ket']));
        $message = 'Pengaduan berhasil dikirim.';
        $action = 'pengaduan';
    } catch (Exception $ex) { $error = 'Pengaduan gagal disimpan: ' . $ex->getMessage(); }
}

if ($page === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['ubah_status'])) {
            (new AspirasiController())->updateStatus((int)$_POST['id'], $_POST['status']);
            $message = 'Status berhasil diperbarui.';
            $action = 'detail';
            $_GET['id'] = (int)$_POST['id'];
        } elseif (isset($_POST['ubah_feedback'])) {
            $feedback = (int)$_POST['feedback'];
            if ($feedback < 1 || $feedback > 5) throw new Exception('Feedback harus 1 sampai 5.');
            (new AspirasiController())->updateFeedback((int)$_POST['id'], $feedback);
            $message = 'Feedback berhasil disimpan.';
            $action = 'detail';
            $_GET['id'] = (int)$_POST['id'];
        }
    } catch (Exception $ex) { $error = $ex->getMessage(); }
}

$kategori = (new KategoriController())->all();
?>
<!DOCTYPE html>
<html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $page === 'admin' ? 'Dashboard Admin' : 'Dashboard Siswa'; ?> - Pengaduan Sarpras</title>
<link rel="stylesheet" href="asset/css/style.css?v=20261003">
</head><body>
<div class="app">
<aside class="sidebar">
    <div class="logo">🏫 <span>SARPRAS</span></div>
    <a class="nav <?php echo $action === 'dashboard' ? 'active' : ''; ?>" href="index.php?page=<?php echo e($page); ?>&action=dashboard">🏠 Dashboard</a>
    <?php if ($page === 'admin'): ?>
        <a class="nav <?php echo $action === 'aspirasi' || $action === 'detail' ? 'active' : ''; ?>" href="index.php?page=admin&action=aspirasi">📋 Data Pengaduan</a>
        <a class="nav <?php echo $action === 'kategori' ? 'active' : ''; ?>" href="index.php?page=admin&action=kategori">🏷️ Kategori</a>
    <?php else: ?>
        <a class="nav <?php echo $action === 'tambah' ? 'active' : ''; ?>" href="index.php?page=siswa&action=tambah">➕ Buat Pengaduan</a>
        <a class="nav <?php echo $action === 'pengaduan' || $action === 'detail' ? 'active' : ''; ?>" href="index.php?page=siswa&action=pengaduan">📋 Pengaduan Saya</a>
    <?php endif; ?>
    <a class="nav logout" href="logout.php">🚪 Logout</a>
</aside>
<main class="main">
<header class="topbar"><div><h2><?php echo $page === 'admin' ? 'Dashboard Admin' : 'Dashboard Siswa'; ?></h2><span>Pengaduan Sarana dan Prasarana Sekolah</span></div><div class="topbar-actions"><button type="button" class="theme-toggle" id="blackWhiteToggle" aria-pressed="false" title="Aktifkan mode hitam putih">⚫⚪ <span>Hitam Putih</span></button><div class="user">👤 <?php echo e($page === 'admin' ? $_SESSION['username'] : $_SESSION['nis']); ?></div></div></header>
<div class="content">
<?php if ($message): ?><div class="success"><?php echo e($message); ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert"><?php echo e($error); ?></div><?php endif; ?>

<?php if ($page === 'admin'): ?>
<?php
$admin = new AdminController();
$data = $admin->dashboard();
$aspirasiModel = new AspirasiController();
?>
<?php if ($action === 'dashboard'): ?>
<div class="cards">
    <div class="card"><span>Total Pengaduan</span><strong><?php echo $data['stats']['total']; ?></strong></div>
    <div class="card"><span>Menunggu</span><strong><?php echo $data['stats']['menunggu']; ?></strong></div>
    <div class="card"><span>Proses</span><strong><?php echo $data['stats']['proses']; ?></strong></div>
    <div class="card"><span>Selesai</span><strong><?php echo $data['stats']['selesai']; ?></strong></div>
</div>
<div class="panel"><div class="panel-title">Pengaduan Terbaru</div><?php include __DIR__.'/view/admin/table.php'; ?></div>
<?php elseif ($action === 'aspirasi'): ?>
<div class="panel"><div class="panel-title">Semua Pengaduan</div><?php $rows = $aspirasiModel->all(); include __DIR__.'/view/admin/table.php'; ?></div>
<?php elseif ($action === 'detail'):
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0; $detail = $aspirasiModel->find($id);
?>
<div class="panel"><div class="panel-title">Detail Pengaduan #<?php echo $id; ?></div>
<?php if (!$detail): ?><p>Data tidak ditemukan.</p><?php else: ?>
<div class="detail-grid"><div><b>NIS</b><span><?php echo e($detail['nis']); ?></span></div><div><b>Kelas</b><span><?php echo e($detail['kelas']); ?></span></div><div><b>Kategori</b><span><?php echo e($detail['ket_kategori']); ?></span></div><div><b>Lokasi</b><span><?php echo e($detail['lokasi']); ?></span></div><div class="full"><b>Keterangan</b><span><?php echo e($detail['ket']); ?></span></div><div><b>Status</b><span class="badge"><?php echo e($detail['status']); ?></span></div><div><b>Feedback</b><span><?php echo $detail['feedback'] === null ? '-' : e($detail['feedback']).'/5'; ?></span></div></div>
<form method="post" class="inline-form"><input type="hidden" name="id" value="<?php echo $id; ?>"><select name="status"><option <?php echo $detail['status']==='Menunggu'?'selected':''; ?>>Menunggu</option><option <?php echo $detail['status']==='Proses'?'selected':''; ?>>Proses</option><option <?php echo $detail['status']==='Selesai'?'selected':''; ?>>Selesai</option></select><button name="ubah_status">Update Status</button></form>
<form method="post" class="inline-form"><input type="hidden" name="id" value="<?php echo $id; ?>"><select name="feedback"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select><button name="ubah_feedback">Simpan Feedback</button></form>
<?php endif; ?></div>
<?php elseif ($action === 'kategori'): ?>
<div class="panel"><div class="panel-title">Data Kategori</div><table><thead><tr><th>ID</th><th>Kategori</th></tr></thead><tbody><?php foreach($kategori as $k): ?><tr><td><?php echo e($k['id_kategori']); ?></td><td><?php echo e($k['ket_kategori']); ?></td></tr><?php endforeach; ?></tbody></table></div>
<?php endif; ?>

<?php else: ?>
<?php $siswaData = (new AspirasiController())->mine($_SESSION['nis']); ?>
<?php if ($action === 'dashboard'): ?>
<div class="welcome"><h3>Halo, NIS <?php echo e($_SESSION['nis']); ?> 👋</h3><p>Kelas <?php echo e($_SESSION['kelas']); ?>. Sampaikan kerusakan atau fasilitas sekolah yang perlu diperbaiki.</p></div>
<div class="cards"><div class="card"><span>Pengaduan Saya</span><strong><?php echo count($siswaData); ?></strong></div><div class="card"><span>Menunggu</span><strong><?php echo count(array_filter($siswaData, function($r){return $r['status']==='Menunggu';})); ?></strong></div><div class="card"><span>Proses</span><strong><?php echo count(array_filter($siswaData, function($r){return $r['status']==='Proses';})); ?></strong></div><div class="card"><span>Selesai</span><strong><?php echo count(array_filter($siswaData, function($r){return $r['status']==='Selesai';})); ?></strong></div></div>
<?php elseif ($action === 'tambah'): ?>
<div class="panel"><div class="panel-title">Buat Pengaduan</div><form method="post"><label>Kategori</label><select name="id_kategori" required><option value="">-- Pilih kategori --</option><?php foreach($kategori as $k): ?><option value="<?php echo e($k['id_kategori']); ?>"><?php echo e($k['ket_kategori']); ?></option><?php endforeach; ?></select><label>Lokasi</label><input name="lokasi" required placeholder="Contoh: Lab Komputer"><label>Keterangan</label><textarea name="ket" rows="5" required placeholder="Jelaskan masalah fasilitas"></textarea><button name="simpan_pengaduan">Kirim Pengaduan</button></form></div>
<?php elseif ($action === 'pengaduan'): ?>
<div class="panel"><div class="panel-title">Pengaduan Saya</div><?php $rows = $siswaData; include __DIR__.'/view/admin/table.php'; ?></div>
<?php elseif ($action === 'detail'):
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0; $detail = (new AspirasiController())->find($id);
?>
<div class="panel"><div class="panel-title">Detail Pengaduan</div><?php if($detail && (int)$detail['nis'] === (int)$_SESSION['nis']): ?><div class="detail-grid"><div><b>Kategori</b><span><?php echo e($detail['ket_kategori']); ?></span></div><div><b>Lokasi</b><span><?php echo e($detail['lokasi']); ?></span></div><div class="full"><b>Keterangan</b><span><?php echo e($detail['ket']); ?></span></div><div><b>Status</b><span class="badge"><?php echo e($detail['status']); ?></span></div></div><?php else: ?><p>Data tidak ditemukan.</p><?php endif; ?></div>
<?php endif; ?>
<?php endif; ?>
</div></main></div>
<script src="asset/js/script.js?v=20261002"></script>
</body></html>
