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

$stmt = $conn->prepare('SELECT * FROM bikes WHERE id = :id AND user_id = :user_id LIMIT 1');
$stmt->execute([
    ':id' => $id,
    ':user_id' => (int)$_SESSION['user_id'],
]);
$bike = $stmt->fetch();

if (!$bike) {
    $_SESSION['error'] = 'Bạn không có quyền sửa tin này hoặc tin không tồn tại.';
    header('Location: ' . BASE_URL . '?page=my-postings');
    exit;
}

$title = (string)($bike['title'] ?? '');
$brand = (string)($bike['brand'] ?? '');
$categoryId = (string)($bike['category_id'] ?? '1');
$conditionStatus = (string)($bike['condition_status'] ?? 'Đã sử dụng');
$status = (string)($bike['status'] ?? 'Đang bán');
$price = isset($bike['price']) ? (string)(int)$bike['price'] : '';
$location = (string)($bike['location'] ?? '');
$description = (string)($bike['description'] ?? '');
$oldImage = (string)($bike['image_url'] ?? '');
$imagePreview = $oldImage !== ''
    ? BASE_URL . 'public/uploads/bikes/' . rawurlencode($oldImage)
    : BASE_URL . 'public/assets/img/bike-placeholder.jpg';
?>

<section class="py-5" style="background: rgba(33,33,33,0.03);">
  <div class="container">
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-end justify-content-between gap-2 mb-4">
      <div>
        <h1 class="section-title h3 mb-1">Chỉnh sửa tin đăng</h1>
        <div class="section-subtitle">Cập nhật thông tin xe đạp của bạn</div>
      </div>
      <a class="btn btn-ghost" href="<?= BASE_URL ?>?page=my-postings">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Quay lại tin của tôi
      </a>
    </div>

    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="surface p-4 p-md-5" style="box-shadow: var(--shadow-md);">
          <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
              <?= htmlspecialchars((string)$_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
            </div>
            <?php unset($_SESSION['error']); ?>
          <?php endif; ?>

          <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success" role="alert">
              <?= htmlspecialchars((string)$_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
            </div>
            <?php unset($_SESSION['success']); ?>
          <?php endif; ?>

          <form method="POST" action="<?= BASE_URL ?>modules/bike/update_bike.php" enctype="multipart/form-data" class="vstack gap-4">
            <input type="hidden" name="id" value="<?= (int)$id ?>">
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($oldImage, ENT_QUOTES, 'UTF-8') ?>">

            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label for="bike_name" class="form-label fw-600">Tên xe đạp <span class="text-danger">*</span></label>
                <input
                  id="bike_name"
                  name="title"
                  type="text"
                  class="form-control"
                  placeholder="vd: Giant TCR Advanced 2020"
                  value="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
                  required
                >
              </div>

              <div class="col-12 col-md-6">
                <label for="brand" class="form-label fw-600">Hãng xe</label>
                <input
                  id="brand"
                  name="brand"
                  type="text"
                  class="form-control"
                  placeholder="vd: Giant / Trek / Specialized"
                  value="<?= htmlspecialchars($brand, ENT_QUOTES, 'UTF-8') ?>"
                >
              </div>

              <div class="col-12 col-md-6">
                <label for="category" class="form-label fw-600">Danh mục</label>
                <select id="category" name="category_id" class="form-select">
                  <option value="1" <?= $categoryId === '1' ? 'selected' : '' ?>>Road Bike</option>
                  <option value="2" <?= $categoryId === '2' ? 'selected' : '' ?>>Mountain Bike</option>
                  <option value="3" <?= $categoryId === '3' ? 'selected' : '' ?>>City Bike</option>
                </select>
              </div>

              <div class="col-12 col-md-6">
                <label for="condition" class="form-label fw-600">Tình trạng</label>
                <select id="condition" name="condition_status" class="form-select">
                  <option value="Mới" <?= $conditionStatus === 'Mới' ? 'selected' : '' ?>>Mới</option>
                  <option value="Đã sử dụng" <?= $conditionStatus === 'Đã sử dụng' ? 'selected' : '' ?>>Đã sử dụng</option>
                </select>
              </div>

              <div class="col-12 col-md-6">
                <label for="status" class="form-label fw-600">Trạng thái tin đăng</label>
                <select id="status" name="status" class="form-select">
                  <option value="Đang bán" <?= $status === 'Đang bán' ? 'selected' : '' ?>>Đang bán</option>
                  <option value="Đã bán" <?= $status === 'Đã bán' ? 'selected' : '' ?>>Đã bán</option>
                </select>
              </div>

              <div class="col-12 col-md-6">
                <label for="price" class="form-label fw-600">Giá bán (VNĐ)</label>
                <input
                  id="price"
                  name="price"
                  type="number"
                  class="form-control"
                  placeholder="vd: 15000000"
                  min="0"
                  step="1000"
                  value="<?= htmlspecialchars($price, ENT_QUOTES, 'UTF-8') ?>"
                >
              </div>

              <div class="col-12 col-md-6">
                <label for="location" class="form-label fw-600">Khu vực xem xe</label>
                <input
                  id="location"
                  name="location"
                  type="text"
                  class="form-control"
                  placeholder="vd: TP.HCM / Hà Nội"
                  value="<?= htmlspecialchars($location, ENT_QUOTES, 'UTF-8') ?>"
                >
              </div>

              <div class="col-12">
                <label class="form-label fw-600 d-block">Ảnh hiện tại</label>
                <img
                  src="<?= htmlspecialchars($imagePreview, ENT_QUOTES, 'UTF-8') ?>"
                  alt="Ảnh xe hiện tại"
                  style="width: 140px; height: 100px; object-fit: cover; border-radius: 10px; border: 1px solid rgba(33,33,33,0.14);"
                >
              </div>

              <div class="col-12">
                <label for="image" class="form-label fw-600">Đổi hình ảnh xe (không bắt buộc)</label>
                <input id="image" name="image" type="file" class="form-control" accept="image/*">
                <div class="form-text">Để trống nếu bạn muốn giữ ảnh cũ.</div>
              </div>

              <div class="col-12">
                <label for="description" class="form-label fw-600">Mô tả chi tiết</label>
                <textarea id="description" name="description" class="form-control" rows="5" placeholder="Mô tả size khung, groupset, độ mòn, phụ tùng đã thay, lỗi (nếu có)..."><?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?></textarea>
              </div>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i>
                Lưu thay đổi
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

