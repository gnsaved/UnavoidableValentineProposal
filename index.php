<?php
declare(strict_types=1);
require_once __DIR__ . '/src/helpers.php';

$createdId = isset($_GET['created']) ? (string)$_GET['created'] : '';
$store = load_store();
$proposal = $createdId ? get_proposal($store, $createdId) : null;
$link = ($proposal && $createdId) ? (base_url() . '/p.php?id=' . urlencode($createdId)) : '';

$err = isset($_GET['err']) ? (string)$_GET['err'] : '';
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Create a Valentine Link</title>
  <link rel="stylesheet" href="assets/app.css"/>
</head>
<body>
  <main class="card">
    <div class="brand" aria-hidden="true">
      <!-- simple cat + heart svg -->
      <svg viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M38 26c8 6 12 9 18 8 10-2 18-2 26 0 6 1 10-2 18-8 3 12 7 19 7 28 0 30-19 54-64 54S7 84 7 54c0-9 4-16 7-28Z" fill="#F0B27A"/>
        <circle cx="48" cy="62" r="6" fill="#111"/>
        <circle cx="80" cy="62" r="6" fill="#111"/>
        <path d="M64 68c-5 0-9 6-9 9 0 7 6 10 9 10s9-3 9-10c0-3-4-9-9-9Z" fill="#FF88A8"/>
        <path d="M98 20c6-8 15-8 20 0 6 9 0 21-20 32-20-11-26-23-20-32 5-8 14-8 20 0Z" fill="#FF3B7F"/>
      </svg>
    </div>

    <h1>Create your “No-Escape” Valentine</h1>
    <p class="sub">Type the name, generate a shareable link, and send it.</p>

    <?php if ($err): ?>
      <div class="alert"><?= e($err) ?></div>
    <?php endif; ?>

    <form class="form" method="post" action="create.php" autocomplete="off">
      <div>
        <label for="to_name">Their name</label>
        <input id="to_name" name="to_name" placeholder="e.g. Nirali" required maxlength="48"/>
        <div class="small">This name will show as: “NAME, will you be my valentine?”</div>
      </div>

      <button class="btn btn-yes" type="submit">Generate link</button>
    </form>

    <?php if ($link): ?>
      <div class="linkBox">
        <code data-copy-target><?= e($link) ?></code>
        <button class="btn btn-copy" type="button" data-copy>Copy</button>
      </div>
      <div class="small" style="margin-top:8px;">Share that link with them 😈</div>
    <?php endif; ?>

    <div class="footer">Built with PHP + JSON storage (no database).</div>
  </main>

  <script src="assets/app.js"></script>
</body>
</html>
