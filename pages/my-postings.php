<?php
declare(strict_types=1);

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '?page=login');
    exit;
}

/** @var PDO $conn */
$conn = require __DIR__ . '/../config/db.php';

$userId = (int)$_SESSION['user_id'];

$stmt = $conn->prepare('SELECT * FROM bikes WHERE user_id = :user_id ORDER BY created_at DESC');
$stmt->execute([':user_id' => $userId]);
$bikes = $stmt->fetchAll() ?: [];

$defaultBikeOnError = BASE_URL . 'public/assets/images/default-bike.jpg';

function bikeStatusLabel(array $bike): array
{
    // Returns [label, badgeClass]
    if (isset($bike['status']) && is_string($bike['status'])) {
        $raw = trim($bike['status']);
        if ($raw !== '') {
            $isSold = in_array(mb_strtolower($raw), ['sold', 'đã bán', 'da ban'], true);
            return [$isSold ? 'Đã bán' : 'Đang bán', $isSold ? 'badge bg-secondary' : 'badge bg-success'];
        }
    }

    if (array_key_exists('is_sold', $bike)) {
        $isSold = (int)$bike['is_sold'] === 1;
        return [$isSold ? 'Đã bán' : 'Đang bán', $isSold ? 'badge bg-secondary' : 'badge bg-success'];
    }

    return ['Đang bán', 'badge bg-success'];
}
?>

<section class="py-5" style="background: rgba(33,33,33,0.03);">
  <div class="container">
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-end justify-content-between gap-2 mb-4">
      <div>
        <h1 class="section-title h3 mb-1">Tin đăng của tôi</h1>
        <div class="section-subtitle">Quản lý các tin bạn đã đăng trên CycleTrust</div>
      </div>
      <a class="btn btn-primary" href="<?= BASE_URL ?>?page=post-bike">
        <i class="fa-solid fa-pen-to-square"></i>
        Đăng tin ngay
      </a>
    </div>

    <?php if (empty($bikes)): ?>
      <div class="surface p-4 p-md-5" style="box-shadow: var(--shadow-sm);">
        <h2 class="h5 mb-2">Bạn chưa có tin đăng nào</h2>
        <p class="text-muted mb-3">Hãy đăng tin đầu tiên để bắt đầu bán xe đạp của bạn.</p>
        <a class="btn btn-primary" href="<?= BASE_URL ?>?page=post-bike">
          <i class="fa-solid fa-bolt"></i>
          Đăng tin ngay
        </a>
      </div>
    <?php else: ?>
      <div class="surface p-3 p-md-4" style="box-shadow: var(--shadow-sm);">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr class="text-muted">
                <th style="width: 86px;">Ảnh</th>
                <th>Tên xe</th>
                <th class="d-none d-md-table-cell">Ngày đăng</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th class="text-end" style="width: 180px;">Hành động</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($bikes as $row): ?>
                <?php
                $title = (string)($row['title'] ?? '');
                $imageRaw = trim((string)($row['image_url'] ?? ''));
                if ($imageRaw === '') {
                    $imageFile = $defaultBikeOnError;
                } elseif (str_starts_with(strtolower($imageRaw), 'http')) {
                    $imageFile = $imageRaw;
                } else {
                    $imageFile = BASE_URL . 'public/uploads/products/' . $imageRaw;
                }
                $price = isset($row['price']) ? (float)$row['price'] : 0;

                $createdAt = (string)($row['created_at'] ?? '');
                $createdLabel = $createdAt !== '' ? date('d/m/Y', strtotime($createdAt)) : '-';

                [$statusLabel, $statusClass] = bikeStatusLabel(is_array($row) ? $row : []);
                $id = isset($row['id']) ? (int)$row['id'] : 0;
                ?>
                <tr>
                  <td>
                    <img
                      src="<?= htmlspecialchars($imageFile, ENT_QUOTES, 'UTF-8') ?>"
                      alt="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
                      class="rounded"
                      style="width: 60px; height: 60px; object-fit: cover;"
                      onerror="this.onerror=null;this.src='public/assets/images/default-bike.jpg';"
                    >
                  </td>
                  <td>
                    <div class="fw-700"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></div>
                    <div class="text-muted small">ID: #<?= $id ?></div>
                  </td>
                  <td class="d-none d-md-table-cell text-muted"><?= htmlspecialchars($createdLabel, ENT_QUOTES, 'UTF-8') ?></td>
                  <td><strong class="text-primary"><?= number_format($price, 0, ',', '.') ?>đ</strong></td>
                  <td><span class="<?= htmlspecialchars($statusClass, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($statusLabel, ENT_QUOTES, 'UTF-8') ?></span></td>
                  <td class="text-end">
                    <div class="d-inline-flex gap-2">
                      <a class="btn btn-outline btn-sm" href="<?= BASE_URL ?>?page=edit-bike&id=<?= $id ?>">
                        <i class="fa-solid fa-pen"></i> Sửa
                      </a>
                      <a class="btn btn-ghost btn-sm" href="<?= BASE_URL ?>?page=delete-bike&id=<?= $id ?>">
                        <i class="fa-solid fa-trash"></i> Xóa
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

