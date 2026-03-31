<?php declare(strict_types=1); ?>

<section class="py-5" style="background: rgba(33,33,33,0.06); min-height: calc(100vh - 76px);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-6 col-xl-5">
        <div class="surface p-4 p-md-5" style="box-shadow: var(--shadow-md);">
          <div class="text-center mb-4">
            <div class="ct-logo" style="font-size: 1.6rem;">CycleTrust</div>
            <div class="text-muted mt-1">Đăng nhập để tiếp tục</div>
          </div>

          <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success" role="alert">
              <?= htmlspecialchars((string)$_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
            </div>
            <?php unset($_SESSION['success']); ?>
          <?php endif; ?>

          <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
              <?= htmlspecialchars((string)$_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
            </div>
            <?php unset($_SESSION['error']); ?>
          <?php endif; ?>

          <form method="POST" action="<?= BASE_URL ?>modules/auth/login_action.php" class="vstack gap-3">
            <div>
              <label for="identifier" class="form-label fw-600">Email (hoặc Username)</label>
              <input id="identifier" name="email" type="text" class="form-control" placeholder="vd: you@email.com hoặc cycletrust99" autocomplete="username" required>
            </div>

            <div>
              <label for="password" class="form-label fw-600">Mật khẩu</label>
              <input id="password" name="password" type="password" class="form-control" placeholder="Nhập mật khẩu" autocomplete="current-password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
              <i class="fa-solid fa-right-to-bracket"></i>
              Đăng nhập
            </button>

            <div class="text-center text-muted">
              Chưa có tài khoản?
              <a class="text-primary fw-600" href="<?= BASE_URL ?>?page=register">Đăng ký</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

