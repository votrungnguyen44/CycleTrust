<?php declare(strict_types=1); ?>

</main>

<footer class="ct-footer mt-5">
  <div class="container py-4 d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2">
    <div class="ct-footer__brand">
      <span class="ct-logo">CycleTrust</span>
      <div class="ct-footer__meta">Đồ án UTH - CycleTrust</div>
    </div>
    <div class="ct-footer__links text-muted">
      <span><i class="fa-regular fa-circle-check me-1"></i>Minh bạch kỹ thuật</span>
      <span class="mx-2 d-none d-md-inline">•</span>
      <span><i class="fa-solid fa-shield-halved me-1"></i>Giao dịch an toàn</span>
    </div>
  </div>
</footer>

<!-- Bootstrap bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if (!empty($_SESSION['success'])) {
    $title = (string)$_SESSION['success'];
    unset($_SESSION['success']);
    ?>
    <script>
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        icon: 'success',
        title: <?= json_encode($title, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>
      });
    </script>
    <?php
}

if (!empty($_SESSION['error'])) {
    $title = (string)$_SESSION['error'];
    unset($_SESSION['error']);
    ?>
    <script>
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        icon: 'error',
        title: <?= json_encode($title, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>
      });
    </script>
    <?php
}
?>
</body>
</html>

