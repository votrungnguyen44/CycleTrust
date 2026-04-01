<?php
declare(strict_types=1);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ' . BASE_URL . '?page=404');
    exit;
}

/** @var PDO $conn */
$conn = require __DIR__ . '/../config/db.php';

/**
 * Chuẩn hóa URL ảnh: rỗng -> mặc định; http(s) -> giữ nguyên; còn lại -> file trong public/uploads/bikes/
 */
function resolveBikeImageUrl(string $raw): string
{
    $raw = trim($raw);
    if ($raw === '') {
        return BASE_URL . 'public/assets/images/default-bike.jpg';
    }
    if (str_starts_with(strtolower($raw), 'http')) {
        return $raw;
    }

    return BASE_URL . 'public/uploads/bikes/' . htmlspecialchars($raw, ENT_QUOTES, 'UTF-8');
}

try {
    $stmt = $conn->prepare(
        'SELECT b.*, u.username AS seller_username, c.name AS category_name
         FROM bikes b
         INNER JOIN users u ON b.user_id = u.id
         LEFT JOIN categories c ON b.category_id = c.id
         WHERE b.id = :id
         LIMIT 1'
    );
    $stmt->execute([':id' => $id]);
    $bike = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Location: ' . BASE_URL . '?page=404');
    exit;
}

if ($bike === false) {
    header('Location: ' . BASE_URL . '?page=404');
    exit;
}

$galleryImages = [];
try {
    $imgStmt = $conn->prepare(
        'SELECT image_url FROM bike_images WHERE bike_id = :bid ORDER BY id ASC'
    );
    $imgStmt->execute([':bid' => $id]);
    $rows = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $imgRow) {
        $path = isset($imgRow['image_url']) ? (string)$imgRow['image_url'] : '';
        if ($path !== '') {
            $galleryImages[] = resolveBikeImageUrl($path);
        }
    }
} catch (PDOException $e) {
    $galleryImages = [];
}

$coverRaw = trim((string)($bike['image_url'] ?? ''));
if ($galleryImages === []) {
    $galleryImages[] = resolveBikeImageUrl($coverRaw);
}

$imgSrc = $galleryImages[0];

$title = (string)($bike['title'] ?? '');
$brand = (string)($bike['brand'] ?? '');
$condition = (string)($bike['condition_status'] ?? '');
$location = (string)($bike['location'] ?? '');
$description = (string)($bike['description'] ?? '');
$username = (string)($bike['seller_username'] ?? 'N/A');
$price = isset($bike['price']) ? (float)$bike['price'] : 0.0;
$categoryName = trim((string)($bike['category_name'] ?? ''));
$brand = trim($brand);
$modelLine = $categoryName !== '' ? $categoryName : ($title !== '' ? $title : '—');

$createdAt = (string)($bike['created_at'] ?? '');
$postedLabel = $createdAt !== '' ? date('d/m/Y H:i', strtotime($createdAt)) : '—';

$conditionLower = $condition !== '' ? mb_strtolower($condition, 'UTF-8') : '';
$isNewish = $conditionLower !== '' && (str_contains($conditionLower, 'mới') || str_contains($conditionLower, 'new'));
if ($condition === '') {
    $conditionBadgeClass = 'bg-secondary';
    $conditionBadgeText = 'Đang cập nhật';
} elseif ($isNewish) {
    $conditionBadgeClass = 'bg-success';
    $conditionBadgeText = 'Mới';
} else {
    $conditionBadgeClass = 'bg-secondary';
    $conditionBadgeText = 'Đã qua sử dụng';
}
?>

<style>
  .ct-detail-radius {
    border-radius: 15px;
  }
  .ct-detail-main-img {
    width: 100%;
    aspect-ratio: 4 / 3;
    object-fit: cover;
    background: #f3f4f6;
  }
  .ct-detail-thumb {
    width: 88px;
    height: 66px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid rgba(33, 33, 33, 0.14);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }
  .ct-detail-thumb.is-active {
    border-color: #ff5722;
    box-shadow: 0 0 0 2px rgba(255, 87, 34, 0.25);
  }
  .ct-detail-desc {
    font-size: 1.05rem;
    line-height: 1.85;
    color: #374151;
  }
  .ct-btn-contact {
    background: #212121;
    color: #fff;
    border: none;
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
  }
  .ct-btn-contact:hover {
    background: #000;
    color: #fff;
  }
  .ct-btn-fav {
    border-radius: 12px;
    border: 1px solid rgba(33, 33, 33, 0.2);
    color: #212121;
  }
  .ct-btn-fav:hover {
    border-color: #ff5722;
    color: #ff5722;
  }
  .ct-price-detail {
    color: #ff5722;
    font-size: clamp(1.85rem, 3vw, 2.35rem);
    font-weight: 800;
    letter-spacing: -0.02em;
  }
</style>

<section class="py-4 py-lg-5">
  <div class="container">
    <nav aria-label="breadcrumb" class="mb-3 mb-lg-4">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
          <a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>" class="text-muted">Trang chủ</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>?page=shop" class="text-muted">Cửa hàng</a>
        </li>
        <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width: 280px;">
          <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
        </li>
      </ol>
    </nav>

    <div class="row g-4 g-lg-5 align-items-start">
      <div class="col-12 col-lg-7">
        <div class="bg-white shadow-sm overflow-hidden ct-detail-radius border">
          <img
            id="bikeMainImage"
            class="ct-detail-main-img"
            src="<?= htmlspecialchars($imgSrc, ENT_QUOTES, 'UTF-8') ?>"
            alt="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
            onerror="this.onerror=null;this.src='public/assets/images/default-bike.jpg';"
          >
        </div>

        <?php if (count($galleryImages) > 1): ?>
          <div class="d-flex gap-2 mt-3 flex-wrap" id="bikeThumbRow" role="group" aria-label="Ảnh gallery">
            <?php foreach ($galleryImages as $index => $thumb): ?>
              <button
                type="button"
                class="p-0 border-0 bg-transparent ct-thumb-trigger"
                data-full-src="<?= htmlspecialchars($thumb, ENT_QUOTES, 'UTF-8') ?>"
                aria-label="Xem ảnh <?= $index + 1 ?>"
                aria-pressed="<?= $index === 0 ? 'true' : 'false' ?>"
              >
                <img
                  class="ct-detail-thumb<?= $index === 0 ? ' is-active' : '' ?>"
                  src="<?= htmlspecialchars($thumb, ENT_QUOTES, 'UTF-8') ?>"
                  alt="Ảnh <?= $index + 1 ?>"
                  onerror="this.onerror=null;this.src='public/assets/images/default-bike.jpg';"
                  loading="lazy"
                >
              </button>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="bg-white shadow-sm p-4 p-md-5 mt-4 ct-detail-radius border">
          <h2 class="h5 fw-bold mb-3">Thông số kỹ thuật</h2>
          <div class="table-responsive">
            <table class="table table-borderless mb-0 align-middle">
              <tbody>
                <tr class="border-bottom">
                  <th scope="row" class="text-muted fw-600 py-3" style="width: 38%;">Thương hiệu</th>
                  <td class="py-3 fw-600"><?= htmlspecialchars($brand !== '' ? $brand : '—', ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr class="border-bottom">
                  <th scope="row" class="text-muted fw-600 py-3">Dòng xe</th>
                  <td class="py-3"><?= htmlspecialchars($modelLine, ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr class="border-bottom">
                  <th scope="row" class="text-muted fw-600 py-3">Tình trạng</th>
                  <td class="py-3"><?= htmlspecialchars($condition !== '' ? $condition : '—', ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr class="border-bottom">
                  <th scope="row" class="text-muted fw-600 py-3">Khu vực</th>
                  <td class="py-3"><?= htmlspecialchars($location !== '' ? $location : '—', ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-muted fw-600 py-3">Ngày đăng</th>
                  <td class="py-3"><?= htmlspecialchars($postedLabel, ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="bg-white shadow-sm p-4 p-md-5 mt-4 ct-detail-radius border">
          <h2 class="h5 fw-bold mb-3">Mô tả chi tiết</h2>
          <div class="ct-detail-desc">
            <?= nl2br(htmlspecialchars($description !== '' ? $description : 'Người bán chưa bổ sung mô tả.', ENT_QUOTES, 'UTF-8')) ?>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-5">
        <div class="bg-white shadow-sm p-4 p-md-5 ct-detail-radius border sticky-lg-top" style="top: 96px;">
          <h1 class="h3 fw-bold mb-3" style="letter-spacing: -0.02em;">
            <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
          </h1>

          <div class="ct-price-detail mb-3">
            <?= htmlspecialchars(formatCurrency($price), ENT_QUOTES, 'UTF-8') ?>
          </div>

          <div class="d-flex flex-wrap align-items-center mb-3">
            <span class="badge <?= htmlspecialchars($conditionBadgeClass, ENT_QUOTES, 'UTF-8') ?> rounded-pill px-3 py-2 me-2">
              <?= htmlspecialchars($conditionBadgeText, ENT_QUOTES, 'UTF-8') ?>
            </span>
            <?php if (!empty($brand)): ?>
              <span class="badge bg-dark rounded-pill px-3 py-2 me-2">
                <?= htmlspecialchars($brand, ENT_QUOTES, 'UTF-8') ?>
              </span>
            <?php endif; ?>
            <?php if (!empty($categoryName)): ?>
              <span class="badge bg-light text-dark rounded-pill px-3 py-2 me-2">
                <?= htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') ?>
              </span>
            <?php endif; ?>
          </div>

          <div class="d-flex align-items-start gap-2 text-muted mb-4">
            <i class="fa-solid fa-location-dot mt-1 text-dark"></i>
            <span><?= htmlspecialchars($location !== '' ? $location : 'Khu vực đang cập nhật', ENT_QUOTES, 'UTF-8') ?></span>
          </div>

          <div class="p-3 mb-4 ct-detail-radius" style="background: rgba(255, 87, 34, 0.06); border: 1px solid rgba(255, 87, 34, 0.2);">
            <div class="d-flex align-items-center gap-3">
              <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: rgba(255, 87, 34, 0.12); color: #ff5722;">
                <i class="fa-solid fa-user fs-5"></i>
              </span>
              <div>
                <div class="text-muted small">Người bán</div>
                <div class="fw-bold"><?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?></div>
              </div>
            </div>
          </div>

          <div class="d-grid gap-2">
            <button type="button" class="btn btn-lg ct-btn-contact py-3">
              <i class="fa-solid fa-phone-volume me-2"></i>
              Liên hệ người bán
            </button>
            <button type="button" class="btn btn-lg ct-btn-fav py-3 bg-white">
              <i class="fa-regular fa-heart me-2"></i>
              Thêm vào yêu thích
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  (function () {
    const main = document.getElementById('bikeMainImage');
    const row = document.getElementById('bikeThumbRow');
    if (!main || !row) return;

    row.querySelectorAll('.ct-thumb-trigger').forEach(function (btn) {
      btn.addEventListener('click', function () {
        const src = btn.getAttribute('data-full-src');
        if (!src) return;
        main.src = src;

        row.querySelectorAll('.ct-thumb').forEach(function (img) {
          img.classList.remove('is-active');
        });
        const thumb = btn.querySelector('.ct-detail-thumb');
        if (thumb) thumb.classList.add('is-active');

        row.querySelectorAll('.ct-thumb-trigger').forEach(function (b) {
          b.setAttribute('aria-pressed', 'false');
        });
        btn.setAttribute('aria-pressed', 'true');
      });
    });
  })();
</script>
