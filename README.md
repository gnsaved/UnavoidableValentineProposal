# No-Escape Valentine (PHP + JSON)

A tiny, **GitHub-ready** PHP project that generates shareable Valentine links.

- Create a link by entering a name
- Shares a page like: `p.php?id=...`
- “No” button dodges your cursor/taps 😈
- Stores proposals + click counts in `storage/with.json`

> Friendly reminder: keep it playful — don’t use it to pressure anyone.

## Project structure

```
noescape-valentine-php/
  assets/
    app.css
    app.js
    ChooseYesorNo(NoRunninAway)Screenshot.png
    ChooseYesorNoScreenshot.png
    EnterLoverNameToGenerateLinkScreenshot.png
    ResultScreenshot.png
  src/
    helpers.php
  storage/
    with.json
    .htaccess
  index.php
  create.php
  p.php
  respond.php
  result.php
```

## Setup (local)

### Option A: PHP built-in server

```bash
cd noescape-valentine-php
php -S localhost:8000
```
Open: `http://localhost:8000`

### Option B: Shared hosting (cPanel)

1. Upload the folder contents to your domain (or a subfolder).
2. Ensure `storage/` is **writable** by PHP.
   - If it’s not, set permissions (often `755` for folder, `644` for file; some hosts need `775`).
3. If your host uses Apache, the included `storage/.htaccess` blocks public access to the JSON file.

## Notes

- This uses simple JSON storage (no database). On very high traffic, you’d likely switch to SQLite/MySQL.
- If you deploy behind Nginx, block `/storage/` via server config (since `.htaccess` won’t apply).

## License

MIT — do whatever you like.
