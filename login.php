<?php
session_start();
if (!empty($_SESSION['login'])) {
    header('Location: index.php'); exit;
}
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Pengaduan Sarpras</title>
<link rel="stylesheet" href="asset/css/login.css">
</head>
<body>
<div class="login-card">
    <div class="brand">🏫</div>
    <h1>Pengaduan Sarpras</h1>
    <p class="subtitle">Sistem Pengaduan Sarana & Prasarana Sekolah</p>
    <?php if ($error): ?><div class="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form action="controller/LoginController.php" method="post">
        <label>Login sebagai</label>
        <select name="role" id="role" onchange="togglePassword()" required>
            <option value="siswa">Siswa</option>
            <option value="admin">Admin</option>
        </select>
        <label>NIS / Username</label>
        <input type="text" name="username" placeholder="Masukkan NIS atau username" required>
        <div id="passwordBox" style="display:none">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password">
        </div>
        <button type="submit">Masuk</button>
    </form>
    <small>Siswa login menggunakan NIS. Admin menggunakan username & password.</small>
</div>
<script>
function togglePassword(){ document.getElementById('passwordBox').style.display = document.getElementById('role').value === 'admin' ? 'block' : 'none'; }
</script>
</body></html>
