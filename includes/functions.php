<?php
declare(strict_types=1);

function formatCurrency(int|float|string $number): string
{
    if (is_string($number)) {
        $normalized = str_replace([' ', ',', 'đ', '₫'], '', $number);
        $normalized = preg_replace('/[^\d.\-]/', '', $normalized ?? '') ?? '';
        $number = ($normalized === '' || $normalized === '-' || $normalized === '.') ? 0 : (float) $normalized;
    }

    $value = (float) $number;
    $formatted = number_format($value, 0, ',', '.');

    return $formatted . 'đ';
}

