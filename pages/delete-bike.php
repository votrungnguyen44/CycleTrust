<?php
declare(strict_types=1);

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '?page=login');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    $_SESSION['error'] = 'Tin đăng không hợp lệ.';
    header('Location: ' . BASE_URL . '?page=my-postings');
    exit;
}

/** @var PDO $conn */
$conn = require __DIR__ . '/../config/db.php';

$ownerStmt = $conn->prepare('SELECT user_id, image_url FROM bikes WHERE id = :id LIMIT 1');
$ownerStmt->execute([':id' => $id]);
$bike = $ownerStmt->fetch();

if (!$bike || (int)$bike['user_id'] !== (int)$_SESSION['user_id']) {
    $_SESSION['error'] = 'Bạn không có quyền xóa tin này hoặc tin không tồn tại.';
    header('Location: ' . BASE_URL . '?page=my-postings');
    exit;
}

$imageUrl = (string)($bike['image_url'] ?? '');
if ($imageUrl !== '') {
    $imagePath = __DIR__ . '/../public/uploads/bikes/' . basename($imageUrl);
    if (is_file($imagePath)) {
        @unlink($imagePath);
    }
}

$deleteStmt = $conn->prepare('DELETE FROM bikes WHERE id = :id');
$deleteStmt->execute([':id' => $id]);

$_SESSION['success'] = 'Đã xóa tin thành công!';
header('Location: ' . BASE_URL . '?page=my-postings');
exit;

