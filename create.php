<?php
declare(strict_types=1);
require_once __DIR__ . '/src/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$to = isset($_POST['to_name']) ? clean_name((string)$_POST['to_name']) : '';
if ($to === '') {
    header('Location: index.php?err=' . urlencode('Please enter a name.'));
    exit;
}

$store = load_store();

// Ensure unique id
for ($i = 0; $i < 5; $i++) {
    $id = generate_id(8);
    if (!isset($store[$id])) break;
}
if (isset($store[$id])) {
    header('Location: index.php?err=' . urlencode('Could not generate a unique link. Try again.'));
    exit;
}

$store[$id] = [
    'to' => $to,
    'created_at' => gmdate('c'),
    'yes_count' => 0,
    'no_count' => 0,
    'yes_at' => null,
];

try {
    save_store($store);
} catch (Throwable $e) {
    header('Location: index.php?err=' . urlencode('Storage error: ' . $e->getMessage()));
    exit;
}

header('Location: index.php?created=' . urlencode($id));
exit;
