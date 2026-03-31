<?php
declare(strict_types=1);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ' . BASE_URL . '?page=404');
    exit;
}

/** @var PDO $conn */
$conn = require __DIR__ . '/../config/db.php';

$stmt = $conn->prepare(
    'SELECT b.*, u.username
     FROM bikes b
     INNER JOIN users u ON b.user_id = u.id
     WHERE b.id = :id
     LIMIT 1'
);
$stmt->execute([':id' => $id]);
$bike = $stmt->fetch();

if (!$bike) {
    header('Location: ' . BASE_URL . '?page=404');
    exit;
}

$title = (string)($bike['title'] ?? '');
$brand = (string)($bike['brand'] ?? '');
$condition = (string)($bike['condition_status'] ?? '');
$location = (string)($bike['location'] ?? '');
$description = (string)($bike['description'] ?? '');
$username = (string)($bike['username'] ?? 'N/A');
$price = isset($bike['price']) ? (float)$bike['price'] : 0;

$imageRaw = trim((string)($bike['image_url'] ?? ''));
if ($imageRaw === '') {
    $imgSrc = BASE_URL . 'public/assets/img/default-bike.jpg';
} elseif (str_starts_with(strtolower($imageRaw), 'http')) {
    $imgSrc = $imageRaw;
} else {
    $imgSrc = BASE_URL . 'public/uploads/bikes/' . htmlspecialchars($imageRaw, ENT_QUOTES, 'UTF-8');
}

$galleryImages = [
    $imgSrc,
    BASE_URL . 'public/assets/img/default-bike.jpg',
    BASE_URL . 'public/assets/img/default-bike.jpg',
];
?>

<section class="py-4 py-lg-5">
  <div class="container">
    <nav aria-label="breadcrumb" class="mb-3 mb-lg-4">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-muted">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?page=home" class="text-muted">Chi tiết xe</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></li>
      </ol>
    </nav>

    <div class="row g-4 g-lg-5">
      <div class="col-12 col-lg-7">
        <div class="surface p-0 overflow-hidden" style="box-shadow: var(--shadow-md); border-radius: 16px;">
          <img
            id="bikeMainImage"
            src="<?= $imgSrc ?>"
            alt="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
            onerror="this.onerror=null;this.src='<?= BASE_URL ?>public/assets/img/default-bike.jpg';"
            style="width: 100%; object-fit: cover; max-height: 560px;"
          >
        </div>

        <div class="d-flex gap-2 mt-3">
          <?php foreach ($galleryImages as $index => $thumb): ?>
            <button
              type="button"
              class="p-0 border-0 bg-transparent"
              aria-label="Xem ảnh <?= $index + 1 ?>"
              onclick="setBikeMainImage('<?= htmlspecialchars($thumb, ENT_QUOTES, 'UTF-8') ?>', this)"
            >
              <img
                src="<?= htmlspecialchars($thumb, ENT_QUOTES, 'UTF-8') ?>"
                alt="Thumbnail <?= $index + 1 ?>"
                onerror="this.onerror=null;this.src='<?= BASE_URL ?>public/assets/img/default-bike.jpg';"
                style="width: 92px; height: 68px; object-fit: cover; border-radius: 10px; border: 2px solid <?= $index === 0 ? '#ff5722' : 'rgba(33,33,33,0.16)' ?>;"
              >
            </button>
          <?php endforeach; ?>
        </div>

        <div class="surface p-4 p-md-5 mt-4" style="box-shadow: var(--shadow-sm); border-radius: 14px;">
          <h2 class="h4 mb-3 fw-700">Mô tả chi tiết</h2>
          <div class="text-muted" style="line-height: 1.75;">
            <?= nl2br(htmlspecialchars($description !== '' ? $description : 'Người bán chưa bổ sung mô tả.', ENT_QUOTES, 'UTF-8')) ?>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-5">
        <div class="surface p-4 p-md-5 sticky-top" style="top: 92px; box-shadow: var(--shadow-md); border-radius: 14px;">
          <h2 class="fw-700 mb-2"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h2>
          <div class="mb-4" style="font-size: clamp(1.8rem, 2.7vw, 2.3rem); font-weight: 900; color: #ff3d00; line-height: 1.15;">
            <?= number_format($price, 0, ',', '.') ?>đ
          </div>

          <div class="list-group list-group-flush mb-4 border rounded-3 overflow-hidden">
            <div class="list-group-item d-flex align-items-center justify-content-between py-3">
              <span class="text-muted"><i class="fa-solid fa-tag me-2 text-primary"></i>Hãng xe</span>
              <strong><?= htmlspecialchars($brand !== '' ? $brand : 'Đang cập nhật', ENT_QUOTES, 'UTF-8') ?></strong>
            </div>
            <div class="list-group-item d-flex align-items-center justify-content-between py-3">
              <span class="text-muted"><i class="fa-solid fa-screwdriver-wrench me-2 text-primary"></i>Tình trạng</span>
              <strong><?= htmlspecialchars($condition !== '' ? $condition : 'Đang cập nhật', ENT_QUOTES, 'UTF-8') ?></strong>
            </div>
            <div class="list-group-item d-flex align-items-center justify-content-between py-3">
              <span class="text-muted"><i class="fa-solid fa-location-dot me-2 text-primary"></i>Khu vực</span>
              <strong><?= htmlspecialchars($location !== '' ? $location : 'Đang cập nhật', ENT_QUOTES, 'UTF-8') ?></strong>
            </div>
          </div>

          <div class="surface p-3 p-md-4 mb-4" style="background: rgba(255,87,34,0.06); border: 1px solid rgba(255,87,34,0.25); border-radius: 12px;">
            <div class="d-flex align-items-center gap-3">
              <span class="d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 50%; background: rgba(255,87,34,0.14); color: #ff5722;">
                <i class="fa-solid fa-user fs-5"></i>
              </span>
              <div>
                <div class="text-muted small">Tin đăng bởi</div>
                <div class="fw-700"><?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?></div>
              </div>
            </div>
          </div>

          <button type="button" class="btn btn-primary w-100 py-3">
            <i class="fa-solid fa-phone-volume me-2"></i>
            Liên hệ người bán
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function setBikeMainImage(src, el) {
    const main = document.getElementById('bikeMainImage');
    if (!main) return;
    main.src = src;

    const thumbs = el.parentElement ? el.parentElement.querySelectorAll('img') : [];
    thumbs.forEach((img) => {
      img.style.borderColor = 'rgba(33,33,33,0.16)';
    });
    const current = el.querySelector('img');
    if (current) current.style.borderColor = '#ff5722';
  }
</script>

