<?php
declare(strict_types=1);
require_once __DIR__ . '/src/helpers.php';

$id = isset($_GET['id']) ? (string)$_GET['id'] : '';
$store = load_store();
$proposal = get_proposal($store, $id);

if (!$proposal) {
    http_response_code(404);
    $title = 'Link not found';
} else {
    $title = $proposal['to'] . ' — Valentine?';
}

?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title><?= e($title) ?></title>
  <link rel="stylesheet" href="assets/app.css"/>

  <!-- simple share preview -->
  <meta property="og:title" content="<?= e($proposal ? ($proposal['to'] . ' — will you be my valentine?') : 'Valentine link') ?>" />
  <meta property="og:description" content="A playful Valentine page 😈" />
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

    <?php if (!$proposal): ?>
      <h1>Oops… this link doesn’t exist</h1>
      <p class="sub">Ask the sender to generate a new one.</p>
      <div class="row" style="margin-top:10px;">
        <a class="btn btn-yes" href="index.php" style="text-decoration:none;display:inline-flex;align-items:center;">Create your own</a>
      </div>
    <?php else: ?>
      <h1><?= e($proposal['to']) ?>, will you be my valentine?</h1>
      <p class="sub">Choose wisely 👀</p>

      <div id="stage" class="stage" aria-label="Valentine buttons">
        <div class="row">
          <a class="btn btn-yes" href="respond.php?id=<?= e(urlencode($id)) ?>&a=yes" id="btnYes" style="text-decoration:none;">Yes</a>
          <a class="btn btn-no" href="respond.php?id=<?= e(urlencode($id)) ?>&a=no" id="btnNo" style="text-decoration:none;">No</a>
        </div>
      </div>

      <div id="note" class="note">“No” seems a bit shy 😈</div>
    <?php endif; ?>

    <div class="footer">If you’re on a small screen, try tapping “No” 😏</div>
  </main>

  <script src="assets/app.js"></script>
</body>
</html>
