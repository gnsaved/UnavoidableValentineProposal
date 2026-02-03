<?php
declare(strict_types=1);

/**
 * Helpers for the No-Escape Valentine mini app.
 * Plain PHP, no dependencies.
 */

function storage_file_path(): string {
    return __DIR__ . '/../storage/with.json';
}

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function clean_name(string $s, int $maxLen = 48): string {
    $s = trim($s);
    // collapse whitespace
    $s = preg_replace('/\s+/u', ' ', $s) ?? $s;
    if (mb_strlen($s) > $maxLen) {
        $s = mb_substr($s, 0, $maxLen);
    }
    return $s;
}

function load_store(): array {
    $path = storage_file_path();
    if (!file_exists($path)) {
        @file_put_contents($path, "{}\n", LOCK_EX);
    }

    $raw = @file_get_contents($path);
    if ($raw === false) return [];

    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function save_store(array $data): void {
    $path = storage_file_path();
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        throw new RuntimeException('Failed to encode JSON');
    }

    // Atomic-ish write: write to temp then rename
    $tmp = $path . '.tmp';
    if (@file_put_contents($tmp, $json . "\n", LOCK_EX) === false) {
        throw new RuntimeException('Failed to write storage file');
    }
    @rename($tmp, $path);
}

function generate_id(int $bytes = 8): string {
    // 8 bytes => 16 hex chars
    return bin2hex(random_bytes($bytes));
}

function base_url(): string {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $scheme = $https ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    // base path (folder where this script lives)
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    $dir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
    if ($dir === '') $dir = '/';

    return $scheme . '://' . $host . ($dir === '/' ? '' : $dir);
}

function get_proposal(array $store, string $id): ?array {
    if ($id === '' || !preg_match('/^[a-f0-9]{10,64}$/', $id)) return null;
    return $store[$id] ?? null;
}
