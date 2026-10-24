<?php
require_once __DIR__ . '/Database.php';
class Admin {
    private $db;
    public function __construct() { $this->db = (new Database())->connect(); }
    public function login($username, $password) {
        $stmt = $this->db->prepare('SELECT username FROM admin WHERE username = ? AND password = ? LIMIT 1');
        $stmt->execute(array($username, $password));
        return $stmt->fetch();
    }
}
