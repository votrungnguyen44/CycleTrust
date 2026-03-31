<?php
declare(strict_types=1);

session_start();

require_once '../../config/config.php';
$conn = require_once '../../config/db.php';

function redirectEditWithError(int $id, string $message): void
{
    $_SESSION['error'] = $message;
    header('Location: ' . BASE_URL . '?page=edit-bike&id=' . $id);
    exit;
}

if (!isset($_SESSION['user_id']) || (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST')) {
    exit;
}

$userId = (int)$_SESSION['user_id'];

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title = trim((string)($_POST['title'] ?? ''));
$priceRaw = trim((string)($_POST['price'] ?? ''));
$brand = trim((string)($_POST['brand'] ?? ''));
$categoryIdRaw = trim((string)($_POST['category_id'] ?? ''));
$conditionStatus = trim((string)($_POST['condition_status'] ?? ''));
$location = trim((string)($_POST['location'] ?? ''));
$description = trim((string)($_POST['description'] ?? ''));
$status = trim((string)($_POST['status'] ?? 'Đang bán'));
$oldImage = trim((string)($_POST['old_image'] ?? ''));

if ($id <= 0) {
    $_SESSION['error'] = 'ID tin đăng không hợp lệ.';
    header('Location: ' . BASE_URL . '?page=my-postings');
    exit;
}

if ($title === '') {
    redirectEditWithError($id, 'Vui lòng nhập tên xe.');
}

$price = ($priceRaw !== '' && is_numeric($priceRaw)) ? (int)$priceRaw : 0;
$categoryId = ctype_digit($categoryIdRaw) ? (int)$categoryIdRaw : 0;
if ($categoryId <= 0) {
    $categoryId = 1;
}

try {
    // Verify bike ownership (prevent tampering with ID from client-side)
    $ownerStmt = $conn->prepare('SELECT id FROM bikes WHERE id = :id AND user_id = :user_id LIMIT 1');
    $ownerStmt->execute([
        ':id' => $id,
        ':user_id' => $userId,
    ]);
    $owner = $ownerStmt->fetch();

    if (!$owner) {
        $_SESSION['error'] = 'Bạn không có quyền chỉnh sửa tin này.';
        header('Location: ' . BASE_URL . '?page=my-postings');
        exit;
    }

    $finalImage = $oldImage;

    // Handle new image upload
    if (isset($_FILES['image']) && is_array($_FILES['image']) && (int)($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
        $newOriginalName = (string)($_FILES['image']['name'] ?? '');
        $newTmpName = (string)($_FILES['image']['tmp_name'] ?? '');

        $ext = strtolower(pathinfo($newOriginalName, PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowedExt, true)) {
            redirectEditWithError($id, 'Định dạng ảnh không hợp lệ. Chỉ chấp nhận JPG, JPEG, PNG, WEBP.');
        }

        $uploadDir = __DIR__ . '/../../public/uploads/bikes/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
                redirectEditWithError($id, 'Không thể tạo thư mục upload ảnh.');
            }
        }

        $newFileName = uniqid('', true) . '_' . basename($newOriginalName);
        $newTargetPath = $uploadDir . $newFileName;

        if (!move_uploaded_file($newTmpName, $newTargetPath)) {
            redirectEditWithError($id, 'Không thể lưu ảnh mới lên server.');
        }

        // Cleanup old image after successful upload of new image
        if ($oldImage !== '') {
            $oldPath = $uploadDir . basename($oldImage);
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
        }

        $finalImage = $newFileName;
    }

    $updateStmt = $conn->prepare(
        'UPDATE bikes
         SET title = ?, price = ?, brand = ?, category_id = ?, condition_status = ?, location = ?, description = ?, status = ?, image_url = ?
         WHERE id = ? AND user_id = ?'
    );

    $updateStmt->execute([
        $title,
        $price,
        $brand,
        $categoryId,
        $conditionStatus,
        $location,
        $description,
        $status,
        $finalImage,
        $id,
        $userId,
    ]);

    $_SESSION['success'] = 'Cập nhật tin thành công!';
    header('Location: ' . BASE_URL . '?page=my-postings');
    exit;
} catch (PDOException $e) {
    redirectEditWithError($id, 'Lỗi cập nhật dữ liệu: ' . $e->getMessage());
}

