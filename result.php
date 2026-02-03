<?php
declare(strict_types=1);
require_once __DIR__ . '/src/helpers.php';

$status = isset($_GET['status']) ? (string)$_GET['status'] : '';
$id = isset($_GET['id']) ? (string)$_GET['id'] : '';
$a = isset($_GET['a']) ? strtolower((string)$_GET['a']) : '';

$store = load_store();
$proposal = ($id !== '') ? get_proposal($store, $id) : null;

$title = 'Result';
$msg = 'Something went wrong.';

if ($status === 'invalid') {
    $title = 'Invalid link';
    $msg = 'That link/answer doesn’t look right.';
} elseif ($proposal && $a === 'yes') {
    $title = 'Yaaay!';
    $msg = e($proposal['to']) . ' said YES 💖';
} elseif ($proposal && $a === 'no') {
    $title = 'Nice try 😈';
    $msg = '“No” is shy… try again.';
} elseif ($proposal) {
    $title = 'Hey!';
    $msg = 'Thanks for stopping by.';
}

?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title><?= e($title) ?></title>
  <link rel="stylesheet" href="assets/app.css"/>
</head>
<body>
  <main class="card">
    <div class="brand" aria-hidden="true">
      <svg viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M38 26c8 6 12 9 18 8 10-2 18-2 26 0 6 1 10-2 18-8 3 12 7 19 7 28 0 30-19 54-64 54S7 84 7 54c0-9 4-16 7-28Z" fill="#F0B27A"/>
        <circle cx="48" cy="62" r="6" fill="#111"/>
        <circle cx="80" cy="62" r="6" fill="#111"/>
        <path d="M64 68c-5 0-9 6-9 9 0 7 6 10 9 10s9-3 9-10c0-3-4-9-9-9Z" fill="#FF88A8"/>
        <path d="M98 20c6-8 15-8 20 0 6 9 0 21-20 32-20-11-26-23-20-32 5-8 14-8 20 0Z" fill="#FF3B7F"/>
      </svg>
    </div>

    <h1><?= e($title) ?></h1>
    <p class="sub"><?= $msg ?></p>

    <?php if ($proposal): ?>
      <div class="row" style="margin-top:10px;">
        <a class="btn btn-yes" href="p.php?id=<?= e(urlencode($id)) ?>" style="text-decoration:none;">Back</a>
      </div>
    <?php else: ?>
      <div class="row" style="margin-top:10px;">
        <a class="btn btn-yes" href="index.php" style="text-decoration:none;">Create one</a>
      </div>
    <?php endif; ?>

    <div class="footer">Have fun, but don’t use this to pressure anyone 🙂</div>
  </main>
</body>
</html>
