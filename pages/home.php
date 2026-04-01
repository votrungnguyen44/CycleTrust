<?php
declare(strict_types=1);

/** @var PDO $conn */
$conn = require __DIR__ . '/../config/db.php';

// Xe nổi bật: 8 tin mới nhất, chỉ xe đang bán và có ảnh đại diện hợp lệ
$featuredBikes = [];
try {
    $stmt = $conn->query(
        "SELECT * FROM bikes WHERE status = 'available' AND image_url IS NOT NULL AND image_url != '' ORDER BY created_at DESC LIMIT 8"
    );
    $featuredBikes = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
} catch (PDOException $e) {
    $featuredBikes = [];
}

$defaultBikeImage = BASE_URL . 'public/assets/images/default-bike.jpg';
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
      <a class="btn btn-outline" href="<?= BASE_URL ?>?page=post-bike">
        <i class="fa-solid fa-pen-to-square"></i>
        Đăng tin ngay
      </a>
    </div>
  </div>
</section>

<style>
  /* Khám phá theo danh mục — tạm thời inline để test, có thể chuyển sang style.css */
  .ct-shop-cat-card {
    height: 380px;
    position: relative;
    display: block;
    transition: box-shadow 0.35s ease;
  }

  .ct-shop-cat-card:hover {
    box-shadow: 0 16px 40px rgba(33, 33, 33, 0.16) !important;
  }

  .ct-shop-cat-card__media {
    position: absolute;
    inset: 0;
    overflow: hidden;
  }

  .ct-shop-cat-card__media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }

  .ct-shop-cat-card:hover .ct-shop-cat-card__media img {
    transform: scale(1.1);
  }

  .ct-shop-cat-card__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(33, 33, 33, 0.92) 0%, rgba(33, 33, 33, 0.35) 45%, transparent 100%);
    pointer-events: none;
  }

  .ct-shop-cat-card__body {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 1.35rem 1.5rem;
    z-index: 2;
  }

  .ct-shop-cat-card__title {
    font-size: 1.45rem;
    font-weight: 800;
    letter-spacing: 0.02em;
    margin: 0 0 0.35rem;
    color: #fff;
    transition: color 0.35s ease;
  }

  .ct-shop-cat-card__cta {
    font-size: 0.9rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.88);
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    transition: color 0.35s ease;
  }

  .ct-shop-cat-card:hover .ct-shop-cat-card__title {
    color: #ff5722;
  }

  .ct-shop-cat-card:hover .ct-shop-cat-card__cta,
  .ct-shop-cat-card:hover .ct-shop-cat-card__cta i {
    color: #ff5722;
  }

  @media (max-width: 767.98px) {
    .ct-shop-cat-card {
      height: 320px;
    }
  }
</style>

<section class="py-5 ct-shop-by-category" style="background: rgba(33,33,33,0.03);">
  <div class="container">
    <div class="text-center mb-4 mb-md-5">
      <h2 class="section-title h3 mb-2">Khám phá theo danh mục</h2>
      <p class="section-subtitle mb-0 mx-auto" style="max-width: 520px;">
        Chọn phân khúc phù hợp — từ đường phố tới đỉnh đèo, CycleTrust đồng hành cùng bạn.
      </p>
    </div>

    <div class="row g-4">
      <div class="col-12 col-md-4">
        <a
          class="card border-0 rounded-4 overflow-hidden shadow-sm text-white text-decoration-none ct-shop-cat-card"
          href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>?page=shop&category_id=2"
        >
          <div class="ct-shop-cat-card__media">
            <img
              src="https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&amp;fit=crop&amp;w=1400&amp;q=85"
              alt="Xe đạp địa hình"
              loading="lazy"
            >
            <div class="ct-shop-cat-card__overlay" aria-hidden="true"></div>
          </div>
          <div class="ct-shop-cat-card__body">
            <h3 class="ct-shop-cat-card__title">Xe đạp địa hình</h3>
            <span class="ct-shop-cat-card__cta">
              Khám phá ngay
              <i class="fa-solid fa-arrow-right-long"></i>
            </span>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-4">
        <a
          class="card border-0 rounded-4 overflow-hidden shadow-sm text-white text-decoration-none ct-shop-cat-card"
          href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>?page=shop&category_id=1"
        >
          <div class="ct-shop-cat-card__media">
            <img
              src="https://images.unsplash.com/photo-1520975916090-3105956dac38?auto=format&amp;fit=crop&amp;w=1400&amp;q=85"
              alt="Xe đạp đua"
              loading="lazy"
            >
            <div class="ct-shop-cat-card__overlay" aria-hidden="true"></div>
          </div>
          <div class="ct-shop-cat-card__body">
            <h3 class="ct-shop-cat-card__title">Xe đạp đua</h3>
            <span class="ct-shop-cat-card__cta">
              Khám phá ngay
              <i class="fa-solid fa-arrow-right-long"></i>
            </span>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-4">
        <a
          class="card border-0 rounded-4 overflow-hidden shadow-sm text-white text-decoration-none ct-shop-cat-card"
          href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>?page=shop&category_id=3"
        >
          <div class="ct-shop-cat-card__media">
            <img
              src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&amp;fit=crop&amp;w=1400&amp;q=85"
              alt="Xe đường phố"
              loading="lazy"
            >
            <div class="ct-shop-cat-card__overlay" aria-hidden="true"></div>
          </div>
          <div class="ct-shop-cat-card__body">
            <h3 class="ct-shop-cat-card__title">Xe đường phố</h3>
            <span class="ct-shop-cat-card__cta">
              Khám phá ngay
              <i class="fa-solid fa-arrow-right-long"></i>
            </span>
          </div>
        </a>
      </div>
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
      <a class="btn btn-ghost" href="<?= BASE_URL ?>?page=shop">
        Xem tất cả
        <i class="fa-solid fa-arrow-right ms-1"></i>
      </a>
    </div>

    <?php if (!empty($featuredBikes)): ?>
      <div class="row g-4">
        <?php foreach ($featuredBikes as $row): ?>
          <?php
          $imageUrl = trim((string)($row['image_url'] ?? ''));
          if ($imageUrl === '') {
              $img_src = $defaultBikeImage;
          } elseif (str_starts_with(strtolower($imageUrl), 'http')) {
              $img_src = $imageUrl;
          } else {
              $img_src = BASE_URL . 'public/uploads/bikes/' . $imageUrl;
          }
          ?>
          <div class="col-12 col-sm-6 col-lg-3">
            <article class="bike-card h-100 d-flex flex-column">
              <div class="bike-card__media">
                <img
                  src="<?= htmlspecialchars($img_src, ENT_QUOTES, 'UTF-8') ?>"
                  alt="<?= htmlspecialchars((string)($row['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                  onerror="this.onerror=null;this.src='public/assets/images/default-bike.jpg';"
                >
              </div>
              <div class="bike-card__body d-flex flex-column flex-grow-1">
                <h3 class="bike-card__title">
                  <?= htmlspecialchars((string)($row['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <?php if (trim((string)($row['brand'] ?? '')) !== ''): ?>
                  <div class="text-muted mb-1 small">
                    <i class="fa-solid fa-tag me-1"></i><?= htmlspecialchars((string)($row['brand'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                  </div>
                <?php endif; ?>
                <div class="bike-card__price mb-2">
                  <strong><?= htmlspecialchars(formatCurrency($row['price'] ?? 0), ENT_QUOTES, 'UTF-8') ?></strong>
                  <?php if (trim((string)($row['condition_status'] ?? '')) !== ''): ?>
                    <span class="badge badge-primary">
                      <?= htmlspecialchars((string)($row['condition_status'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </span>
                  <?php endif; ?>
                </div>
                <div class="mt-auto">
                  <?php if (trim((string)($row['location'] ?? '')) !== ''): ?>
                    <div class="bike-card__location mb-2">
                      <i class="fa-solid fa-location-dot text-primary"></i>
                      <?= htmlspecialchars((string)($row['location'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </div>
                  <?php endif; ?>
                  <a class="btn btn-outline w-100" href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>index.php?page=bike-detail&id=<?= (int)($row['id'] ?? 0) ?>">
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

