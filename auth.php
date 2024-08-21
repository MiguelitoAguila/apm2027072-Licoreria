<?php
session_start();

function login($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $stmt->execute(['email' => $email, 'password' => $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

function register($email, $password, $role) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (:email, :password, :role)");
    return $stmt->execute(['email' => $email, 'password' => $password, 'role' => $role]);
}

function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function isClient() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'client';
}
?>
