<?php
declare(strict_types=1);
require_once __DIR__ . '/src/helpers.php';

$id = isset($_GET['id']) ? (string)$_GET['id'] : '';
$ans = isset($_GET['a']) ? strtolower((string)$_GET['a']) : '';

$store = load_store();
$proposal = get_proposal($store, $id);

if (!$proposal || ($ans !== 'yes' && $ans !== 'no')) {
    header('Location: result.php?status=invalid');
    exit;
}

if ($ans === 'yes') {
    $proposal['yes_count'] = (int)($proposal['yes_count'] ?? 0) + 1;
    $proposal['yes_at'] = $proposal['yes_at'] ?? gmdate('c');
} else {
    $proposal['no_count'] = (int)($proposal['no_count'] ?? 0) + 1;
}

$store[$id] = $proposal;
try { save_store($store); } catch (Throwable $e) {
    // Don’t leak details; still show result page.
}

header('Location: result.php?id=' . urlencode($id) . '&a=' . urlencode($ans));
exit;
