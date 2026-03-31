<?php
declare(strict_types=1);

session_start();

require_once '../../config/config.php';
$conn = require_once '../../config/db.php';

function redirectWithError(string $message): void
{
    $_SESSION['error'] = $message;
    header('Location: ' . BASE_URL . '?page=post-bike');
    exit;
}

if (!isset($_SESSION['user_id']) || (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST')) {
    exit;
}

$userId = (int)$_SESSION['user_id'];

$title = trim((string)($_POST['title'] ?? ''));
$brand = trim((string)($_POST['brand'] ?? ''));
$categoryIdRaw = trim((string)($_POST['category_id'] ?? ''));
$conditionStatus = trim((string)($_POST['condition_status'] ?? ''));
$priceRaw = trim((string)($_POST['price'] ?? ''));
$location = trim((string)($_POST['location'] ?? ''));
$description = trim((string)($_POST['description'] ?? ''));

$categoryId = ctype_digit($categoryIdRaw) ? (int)$categoryIdRaw : 0;
// Temporary fallback for debugging if form sends a string (e.g. "Road Bike")
if ($categoryId === 0 && $categoryIdRaw !== '') {
    $categoryId = 1;
}
$price = ($priceRaw !== '' && is_numeric($priceRaw)) ? (int)$priceRaw : 0;

if ($title === '') {
    redirectWithError('Vui lòng nhập tên xe đạp.');
}

if ($categoryId <= 0) {
    redirectWithError('Danh mục không hợp lệ.');
}

if ($conditionStatus !== '' && !in_array($conditionStatus, ['Mới', 'Đã sử dụng'], true)) {
    redirectWithError('Tình trạng không hợp lệ.');
}

// Upload image
if (!isset($_FILES['image']) || !is_array($_FILES['image'])) {
    redirectWithError('Vui lòng chọn hình ảnh xe.');
}

$file = $_FILES['image'];
if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    redirectWithError('Upload ảnh thất bại. Vui lòng thử lại.');
}

$originalName = (string)($file['name'] ?? '');
$tmpName = (string)($file['tmp_name'] ?? '');

$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
$allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
if (!in_array($ext, $allowedExt, true)) {
    redirectWithError('Lỗi ảnh: Chỉ chấp nhận JPG, PNG, WEBP.');
}

// Optional MIME validation for extra safety
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $tmpName !== '' ? (string)$finfo->file($tmpName) : '';
$allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
if ($mime === '' || !in_array($mime, $allowedMime, true)) {
    redirectWithError('File ảnh không hợp lệ.');
}

$safeBaseName = basename($originalName);
$newFileName = uniqid('', true) . '_' . $safeBaseName;

$targetDir = __DIR__ . '/../../public/uploads/bikes/';
if (!is_dir($targetDir)) {
    if (!mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
        redirectWithError('Không thể tạo thư mục lưu ảnh.');
    }
}

$targetPath = $targetDir . $newFileName;
if (!move_uploaded_file($tmpName, $targetPath)) {
    redirectWithError('Lỗi hệ thống: Không thể lưu file vào thư mục public/uploads/bikes/.');
}

try {
    $stmt = $conn->prepare(
        'INSERT INTO bikes (user_id, category_id, title, description, price, brand, condition_status, location, image_url)
         VALUES (:user_id, :category_id, :title, :description, :price, :brand, :condition_status, :location, :image_url)'
    );

    $stmt->execute([
        ':user_id' => $userId,
        ':category_id' => $categoryId,
        ':title' => $title,
        ':description' => $description,
        ':price' => $price,
        ':brand' => $brand,
        ':condition_status' => $conditionStatus,
        ':location' => $location,
        ':image_url' => $newFileName, // store only file name
    ]);

    $_SESSION['success'] = 'Đăng tin thành công!';
    header('Location: ' . BASE_URL . '?page=home');
    exit;
} catch (PDOException $e) {
    // Rollback uploaded file if DB insert fails
    if (is_file($targetPath)) {
        @unlink($targetPath);
    }
    redirectWithError('Lỗi Database: ' . $e->getMessage());
}

