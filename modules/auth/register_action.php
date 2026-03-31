<?php
declare(strict_types=1);

session_start();

require_once '../../config/config.php';
$conn = require_once '../../config/db.php';

function redirectWithError(string $message): void
{
    $_SESSION['error'] = $message;
    header('Location: ' . BASE_URL . '?page=register');
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    redirectWithError('Yêu cầu không hợp lệ.');
}

$username = trim((string)($_POST['username'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$phone = trim((string)($_POST['phone'] ?? ''));
$password = (string)($_POST['password'] ?? '');
$confirmPassword = (string)($_POST['confirm_password'] ?? '');

if ($username === '' || $email === '' || $phone === '' || $password === '' || $confirmPassword === '') {
    redirectWithError('Vui lòng nhập đầy đủ thông tin.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirectWithError('Email không hợp lệ.');
}

if ($password !== $confirmPassword) {
    redirectWithError('Mật khẩu không khớp.');
}

try {
    $stmt = $conn->prepare('SELECT id FROM users WHERE email = :email OR username = :username LIMIT 1');
    $stmt->execute([
        ':email' => $email,
        ':username' => $username,
    ]);
    $exists = $stmt->fetch();

    if ($exists) {
        redirectWithError('Username hoặc Email đã tồn tại.');
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    if ($passwordHash === false) {
        redirectWithError('Không thể xử lý mật khẩu.');
    }

    $insert = $conn->prepare('INSERT INTO users (username, email, phone, password) VALUES (:username, :email, :phone, :password)');
    $insert->execute([
        ':username' => $username,
        ':email' => $email,
        ':phone' => $phone,
        ':password' => $passwordHash,
    ]);

    $_SESSION['success'] = 'Đăng ký thành công';
    header('Location: ' . BASE_URL . '?page=login');
    exit;
} catch (PDOException $e) {
    redirectWithError('Có lỗi xảy ra. Vui lòng thử lại.');
}

