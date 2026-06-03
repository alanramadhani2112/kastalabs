# KastaLabs WordPress Theme

Custom theme untuk kastalabs.com — portfolio + blog dengan stack Tailwind CSS v4 + GSAP.

> Spesifikasi lengkap di `/docs/PRD.md` dan `/docs/TECH-DOC.md` (root project).
> Plan eksekusi M1 di `/docs/EXEC-PLAN-M1.md`.

## Struktur

```
kastalabs/
  style.css           # WP theme header (metadata only)
  functions.php       # bootstrap, require /inc
  index.php           # fallback template
  header.php / footer.php
  front-page.php      # home
  archive.php / archive-work.php / single.php / single-work.php
  home.php            # blog index
  page.php / 404.php / search.php
  inc/                # PHP modules
  src/                # Vite source (CSS + JS)
  dist/               # build output (gitignored)
  template-parts/     # partial template
  blocks/             # custom Gutenberg blocks (placeholder M1)
  languages/          # i18n
```

## Setup

Butuh Node 20+. Dari `wp-content/themes/kastalabs/`:

```bash
npm install
npm run build       # production bundle ke dist/
npm run dev         # vite dev server di http://localhost:5173
```

Saat dev mode, tambahkan ke `wp-config.php` untuk pakai bundle live dari Vite:

```php
define( 'KASTA_VITE_DEV', true );
```

Cabut flag itu setelah `npm run build` untuk pakai bundle production di `dist/`.

## Activate

WP Admin → Appearance → Themes → KastaLabs → Activate.

Lalu Settings → Permalinks → Save (flush rewrite rules untuk CPT `work`).

## Brand tokens

Tokens didefinisikan di `src/css/app.css` via `@theme {}`. Sumber: `/docs/brand-preview.html` dan `/docs/PRD.md` §6.2.

- Primary palette 15-step (`primary-50` … `primary-950` + half-step 75/150/850/925)
- Anchor: `#007BFF` di `primary-500`
- Font: Plus Jakarta Sans (loaded via Google Fonts CDN sementara, akan self-host di M2+)

## Catatan M1

Theme ini scaffold M1 — semua template visual masih placeholder. M2 implementasi visual lengkap + custom Gutenberg blocks setelah Figma export final masuk.