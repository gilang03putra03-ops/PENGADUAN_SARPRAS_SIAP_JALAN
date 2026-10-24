<?php
session_start();
require_once __DIR__ . '/../model/Admin.php';
require_once __DIR__ . '/../model/Siswa.php';

class LoginController {
    public function login() {
        $role = isset($_POST['role']) ? $_POST['role'] : '';
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if ($role === 'admin') {
            $user = (new Admin())->login($username, $password);
            if ($user) {
                $_SESSION['login'] = true;
                $_SESSION['role'] = 'admin';
                $_SESSION['username'] = $user['username'];
                header('Location: ../index.php?page=admin'); exit;
            }
        } elseif ($role === 'siswa') {
            $siswa = (new Siswa())->find($username);
            if ($siswa) {
                $_SESSION['login'] = true;
                $_SESSION['role'] = 'siswa';
                $_SESSION['nis'] = $siswa['nis'];
                $_SESSION['kelas'] = $siswa['kelas'];
                header('Location: ../index.php?page=siswa'); exit;
            }
        }
        $_SESSION['error'] = 'Login gagal. Periksa data login Anda.';
        header('Location: ../login.php'); exit;
    }

    public static function logout() {
        session_start();
        $_SESSION = array();
        session_destroy();
        header('Location: login.php'); exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    (new LoginController())->login();
}
