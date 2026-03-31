<?php
declare(strict_types=1);

session_start();

require_once '../../config/config.php';

session_unset();
session_destroy();

header('Location: ' . BASE_URL . '?page=home');
exit;

