<?php declare(strict_types=1); ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CycleTrust</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer">

  <!-- CycleTrust styles -->
  <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/style.css">
</head>
<body>

<header class="sticky-top">
  <nav class="navbar navbar-expand-lg navbar-dark ct-navbar">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_URL ?>">
        <span class="ct-logo">CycleTrust</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ctNavbar" aria-controls="ctNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="ctNavbar">
        <form class="d-flex mx-lg-auto my-3 my-lg-0 ct-search" role="search" action="<?= BASE_URL ?>" method="get">
          <input type="hidden" name="page" value="home">
          <div class="input-group">
            <span class="input-group-text ct-search__icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input class="form-control ct-search__input" type="search" name="q" placeholder="Tìm xe theo hãng, size, groupset..." aria-label="Search">
          </div>
        </form>

        <ul class="navbar-nav align-items-lg-center gap-lg-2 ms-lg-3">
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>?page=home"><i class="fa-solid fa-bicycle me-1"></i>Mua xe</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>?page=post-bike"><i class="fa-solid fa-pen-to-square me-1"></i>Đăng tin</a>
          </li>
          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>?page=my-postings">
                <i class="fa-regular fa-rectangle-list me-1"></i>Tin của tôi
              </a>
            </li>
            <li class="nav-item mt-2 mt-lg-0">
              <span class="nav-link">
                Xin chào,
                <strong class="text-primary">
                  <?= htmlspecialchars((string)($_SESSION['username'] ?? 'User'), ENT_QUOTES, 'UTF-8') ?>
                </strong>
              </span>
            </li>
            <li class="nav-item mt-2 mt-lg-0">
              <a class="btn btn-outline ct-btn-nav w-100" href="<?= BASE_URL ?>modules/auth/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Đăng xuất
              </a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>?page=register"><i class="fa-regular fa-circle-user me-1"></i>Đăng ký</a>
            </li>
            <li class="nav-item mt-2 mt-lg-0">
              <a class="btn btn-primary ct-btn-nav w-100" href="<?= BASE_URL ?>?page=login">
                <i class="fa-solid fa-right-to-bracket"></i>
                Đăng nhập
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>

<main>

