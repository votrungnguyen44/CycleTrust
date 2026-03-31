<?php
declare(strict_types=1);

/** @var PDO $conn */
$conn = require __DIR__ . '/../config/db.php';

$stmt = $conn->query('SELECT * FROM bikes ORDER BY created_at DESC LIMIT 8');
$bikes = $stmt ? $stmt->fetchAll() : [];

$fallbackImage = BASE_URL . 'public/assets/img/default-bike.jpg';
?>

<section class="hero">
  <div class="container hero__content">
    <div class="hero__badge">
      <i class="fa-solid fa-shield-halved"></i>
      Minh bạch thông số - Giao dịch an tâm
    </div>
    <h1 class="hero__title display-5">
      Mua bán xe đạp cũ uy tín - Kết nối đam mê
    </h1>
    <p class="hero__lead fs-5 mb-0">
      Tìm đúng chiếc xe phù hợp theo size khung, groupset, tình trạng và lịch sử thay thế phụ tùng.
    </p>

    <div class="hero__actions">
      <a class="btn btn-primary" href="<?= BASE_URL ?>?page=home">
        <i class="fa-solid fa-bicycle"></i>
        Khám phá xe
      </a>
      <a class="btn btn-outline" href="<?= BASE_URL ?>?page=post">
        <i class="fa-solid fa-pen-to-square"></i>
        Đăng tin ngay
      </a>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-end justify-content-between gap-2 mb-4">
      <div>
        <h2 class="section-title h3 mb-1">Xe nổi bật</h2>
        <div class="section-subtitle">Những tin đăng mới nhất từ cộng đồng CycleTrust</div>
      </div>
      <a class="btn btn-ghost" href="<?= BASE_URL ?>?page=home">
        Xem tất cả
        <i class="fa-solid fa-arrow-right ms-1"></i>
      </a>
    </div>

    <?php if (!empty($bikes)): ?>
      <div class="row g-4">
        <?php foreach ($bikes as $bike): ?>
          <?php
          $imageUrl = trim((string)($bike['image_url'] ?? ''));
          if ($imageUrl === '') {
              $img_src = $fallbackImage;
          } elseif (str_starts_with(strtolower($imageUrl), 'http')) {
              $img_src = $imageUrl;
          } else {
              $img_src = BASE_URL . 'public/uploads/bikes/' . htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8');
          }
          $title = (string)($bike['title'] ?? '');
          $brand = (string)($bike['brand'] ?? '');
          $location = (string)($bike['location'] ?? '');
          $condition = (string)($bike['condition_status'] ?? '');
          $price = isset($bike['price']) ? (float)$bike['price'] : 0;
          ?>
          <div class="col-12 col-sm-6 col-lg-3">
            <article class="bike-card h-100 d-flex flex-column">
              <div class="bike-card__media">
                <img
                  src="<?= $img_src ?>"
                  alt="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
                  onerror="this.onerror=null;this.src='<?= htmlspecialchars($fallbackImage, ENT_QUOTES, 'UTF-8') ?>';"
                >
              </div>
              <div class="bike-card__body d-flex flex-column flex-grow-1">
                <h3 class="bike-card__title">
                  <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <?php if ($brand !== ''): ?>
                  <div class="text-muted mb-1 small">
                    <i class="fa-solid fa-tag me-1"></i><?= htmlspecialchars($brand, ENT_QUOTES, 'UTF-8') ?>
                  </div>
                <?php endif; ?>
                <div class="bike-card__price mb-2">
                  <strong><?= number_format($price, 0, ',', '.') ?>đ</strong>
                  <?php if ($condition !== ''): ?>
                    <span class="badge badge-primary">
                      <?= htmlspecialchars($condition, ENT_QUOTES, 'UTF-8') ?>
                    </span>
                  <?php endif; ?>
                </div>
                <div class="mt-auto">
                  <?php if ($location !== ''): ?>
                    <div class="bike-card__location mb-2">
                      <i class="fa-solid fa-location-dot text-primary"></i>
                      <?= htmlspecialchars($location, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                  <?php endif; ?>
                  <a class="btn btn-outline w-100" href="<?= BASE_URL ?>?page=bike-detail&id=<?= (int)$bike['id'] ?>">
                    Xem chi tiết
                    <i class="fa-solid fa-arrow-right ms-1"></i>
                  </a>
                </div>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="surface p-4">
        <div class="text-muted">Chưa có tin đăng nào. Hãy là người đầu tiên đăng tin xe đạp của bạn.</div>
      </div>
    <?php endif; ?>
  </div>
</section>

