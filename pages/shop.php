<?php
declare(strict_types=1);

/** @var PDO $conn */
$conn = require __DIR__ . '/../config/db.php';

$limit = 8;
$currentPage = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
$categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

$baseWhere = "status = 'available' AND image_url IS NOT NULL AND image_url != ''";
$whereSql = '';
$countParams = [];
$listParams = [];

if ($categoryId > 0) {
    $whereSql = ' WHERE ' . $baseWhere . ' AND category_id = :category_id';
    $countParams[':category_id'] = $categoryId;
    $listParams[':category_id'] = $categoryId;
} else {
    $whereSql = ' WHERE ' . $baseWhere;
}

$bikes = [];
$totalRecords = 0;
$totalPages = 1;

try {
    $countStmt = $conn->prepare('SELECT COUNT(*) FROM bikes' . $whereSql);
    foreach ($countParams as $name => $val) {
        $countStmt->bindValue($name, $val, PDO::PARAM_INT);
    }
    $countStmt->execute();
    $totalRecords = (int)$countStmt->fetchColumn();
    $totalPages = max(1, (int)ceil($totalRecords / $limit));

    if ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    $offset = ($currentPage - 1) * $limit;

    $listSql = 'SELECT * FROM bikes' . $whereSql . ' ORDER BY created_at DESC LIMIT :limit OFFSET :offset';
    $listStmt = $conn->prepare($listSql);

    foreach ($listParams as $name => $val) {
        $listStmt->bindValue($name, $val, PDO::PARAM_INT);
    }

    $listStmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $listStmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $listStmt->execute();
    $bikes = $listStmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
} catch (PDOException $e) {
    $bikes = [];
    $totalRecords = 0;
    $totalPages = 1;
    $currentPage = 1;
}

// Ảnh mặc định khi lỗi tải (404 / link hỏng)
$defaultBikeImage = BASE_URL . 'public/assets/images/default-bike.jpg';

function shopPageUrl(int $pageNum, int $catId): string
{
    $query = [
        'page' => 'shop',
        'p' => (string)$pageNum,
    ];
    if ($catId > 0) {
        $query['category_id'] = (string)$catId;
    }

    return BASE_URL . '?' . http_build_query($query);
}

$categoryTitle = 'Tất cả xe';
if ($categoryId === 1) {
    $categoryTitle = 'Xe đạp đua';
} elseif ($categoryId === 2) {
    $categoryTitle = 'Xe đạp địa hình';
} elseif ($categoryId === 3) {
    $categoryTitle = 'Xe đường phố';
}
?>

<section class="py-5" style="background: rgba(33,33,33,0.03);">
  <div class="container">
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-end justify-content-between gap-2 mb-4">
      <div>
        <h1 class="section-title h3 mb-1">Cửa hàng xe đạp</h1>
        <div class="section-subtitle">Danh mục: <?= htmlspecialchars($categoryTitle, ENT_QUOTES, 'UTF-8') ?> — <?= (int)$totalRecords ?> tin</div>
      </div>
      <a class="btn btn-ghost" href="<?= BASE_URL ?>?page=home">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Về trang chủ
      </a>
    </div>

    <?php if (!empty($bikes)): ?>
      <div class="row g-4">
        <?php foreach ($bikes as $row): ?>
          <?php
          $imageUrl = trim((string)($row['image_url'] ?? ''));
          if ($imageUrl === '') {
              $img_src = $defaultBikeImage;
          } elseif (str_contains(strtolower($imageUrl), 'http')) {
              $img_src = $imageUrl;
          } else {
              $img_src = BASE_URL . 'public/uploads/products/' . $imageUrl;
          }
          $title = (string)($row['title'] ?? '');
          $brand = (string)($row['brand'] ?? '');
          $location = (string)($row['location'] ?? '');
          $condition = (string)($row['condition_status'] ?? '');
          $price = isset($row['price']) ? (float)$row['price'] : 0;
          ?>
          <div class="col-12 col-sm-6 col-lg-3">
            <article class="bike-card h-100 d-flex flex-column">
              <div class="bike-card__media">
                <img
                  class="card-img-top"
                  src="<?= htmlspecialchars($img_src, ENT_QUOTES, 'UTF-8') ?>"
                  alt="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
                  style="height: 200px; object-fit: cover;"
                  onerror="this.onerror=null;this.src='public/assets/images/default-bike.jpg';"
                >
              </div>
              <div class="bike-card__body d-flex flex-column flex-grow-1">
                <h2 class="bike-card__title h6">
                  <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
                </h2>
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

      <?php if ($totalPages > 1): ?>
        <nav aria-label="Phân trang danh sách xe" class="mt-5">
          <ul class="pagination justify-content-center flex-wrap mb-0">
            <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
              <a
                class="page-link rounded-pill me-1"
                href="<?= $currentPage <= 1 ? '#' : htmlspecialchars(shopPageUrl($currentPage - 1, $categoryId), ENT_QUOTES, 'UTF-8') ?>"
                <?= $currentPage <= 1 ? 'tabindex="-1" aria-disabled="true"' : '' ?>
              >
                Trang trước
              </a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                <a class="page-link" href="<?= htmlspecialchars(shopPageUrl($i, $categoryId), ENT_QUOTES, 'UTF-8') ?>">
                  <?= $i ?>
                </a>
              </li>
            <?php endfor; ?>
            <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
              <a
                class="page-link rounded-pill ms-1"
                href="<?= $currentPage >= $totalPages ? '#' : htmlspecialchars(shopPageUrl($currentPage + 1, $categoryId), ENT_QUOTES, 'UTF-8') ?>"
                <?= $currentPage >= $totalPages ? 'tabindex="-1" aria-disabled="true"' : '' ?>
              >
                Trang sau
              </a>
            </li>
          </ul>
        </nav>
      <?php endif; ?>
    <?php else: ?>
      <div class="surface p-4">
        <p class="text-muted mb-3">Chưa có tin nào trong mục này.</p>
        <a class="btn btn-primary" href="<?= BASE_URL ?>?page=shop">Xem tất cả xe</a>
      </div>
    <?php endif; ?>
  </div>
</section>
