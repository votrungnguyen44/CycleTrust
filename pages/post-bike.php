<?php
declare(strict_types=1);

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '?page=login');
    exit;
}
?>

<section class="py-5" style="background: rgba(33,33,33,0.03);">
  <div class="container">
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-end justify-content-between gap-2 mb-4">
      <div>
        <h1 class="section-title h3 mb-1">Đăng tin xe đạp</h1>
        <div class="section-subtitle">Điền thông tin rõ ràng để người mua dễ đánh giá</div>
      </div>
      <a class="btn btn-ghost" href="<?= BASE_URL ?>?page=home">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Về trang chủ
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

          <form method="POST" action="<?= BASE_URL ?>modules/bike/save_bike.php" enctype="multipart/form-data" class="vstack gap-4">
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label for="bike_name" class="form-label fw-600">Tên xe đạp <span class="text-danger">*</span></label>
                <input id="bike_name" name="title" type="text" class="form-control" placeholder="vd: Giant TCR Advanced 2020" required>
              </div>

              <div class="col-12 col-md-6">
                <label for="brand" class="form-label fw-600">Hãng xe</label>
                <input id="brand" name="brand" type="text" class="form-control" placeholder="vd: Giant / Trek / Specialized">
              </div>

              <div class="col-12 col-md-6">
                <label for="category" class="form-label fw-600">Danh mục</label>
                <select id="category" name="category_id" class="form-select">
                  <option value="1">Road Bike</option>
                  <option value="2">Mountain Bike</option>
                  <option value="3">City Bike</option>
                </select>
              </div>

              <div class="col-12 col-md-6">
                <label for="condition" class="form-label fw-600">Tình trạng</label>
                <select id="condition" name="condition_status" class="form-select">
                  <option value="Mới">Mới</option>
                  <option value="Đã sử dụng" selected>Đã sử dụng</option>
                </select>
              </div>

              <div class="col-12 col-md-6">
                <label for="price" class="form-label fw-600">Giá bán (VNĐ)</label>
                <input id="price" name="price" type="number" class="form-control" placeholder="vd: 15000000" min="0" step="1000">
              </div>

              <div class="col-12 col-md-6">
                <label for="location" class="form-label fw-600">Khu vực xem xe</label>
                <input id="location" name="location" type="text" class="form-control" placeholder="vd: TP.HCM / Hà Nội">
              </div>

              <div class="col-12">
                <label for="image" class="form-label fw-600">Hình ảnh xe <span class="text-danger">*</span></label>
                <input id="image" name="image" type="file" class="form-control" accept="image/*" required>
                <div class="form-text">Chọn ảnh rõ, đủ sáng để tăng độ tin cậy.</div>
              </div>

              <div class="col-12">
                <label for="description" class="form-label fw-600">Mô tả chi tiết</label>
                <textarea id="description" name="description" class="form-control" rows="5" placeholder="Mô tả size khung, groupset, độ mòn, phụ tùng đã thay, lỗi (nếu có)..."></textarea>
              </div>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-bolt"></i>
                Đăng tin ngay
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

