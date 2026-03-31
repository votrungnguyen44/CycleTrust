<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';

$page = $_GET['page'] ?? 'home';
if (!is_string($page)) {
    $page = 'home';
}

$page = trim($page);
if ($page === '') {
    $page = 'home';
}

// Allow only safe page slugs, prevent directory traversal and weird chars.
if (!preg_match('/\A[a-zA-Z0-9_-]+\z/', $page)) {
    $page = '404';
}

$pageFile = __DIR__ . '/pages/' . $page . '.php';
if (!is_file($pageFile)) {
    $pageFile = __DIR__ . '/pages/404.php';
}

require_once __DIR__ . '/includes/header.php';

if (is_file($pageFile)) {
    require $pageFile;
} else {
    http_response_code(404);
    echo '<h1>404</h1><p>Page not found.</p>';
}

require_once __DIR__ . '/includes/footer.php';

