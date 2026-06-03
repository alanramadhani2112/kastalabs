# Execution Plan — M1 Foundation

**Goal**: Scaffold WordPress theme `kastalabs` yang aktif, build berhasil, semua wiring core jalan. Tidak ada visual final — semua template berisi placeholder yang membaca dari design tokens.

**Definition of Done M1**:
- Theme terdeteksi di `Appearance > Themes` dengan nama "KastaLabs", screenshot, deskripsi.
- `npm install && npm run build` exit code 0.
- Theme bisa di-activate tanpa fatal error.
- `wp_head` mengeluarkan `<link>` ke CSS bundle (dari `dist/manifest.json`).
- `wp_footer` mengeluarkan `<script type="module">` ke JS bundle.
- CPT `work` muncul di sidebar admin, taxonomy `work_category` & `work_tag` ada.
- Permalink rewrite jalan untuk `/work/{slug}` (perlu flush via Permalink → Save sekali).
- Tailwind utilities + design tokens (15-step palette + Plus Jakarta Sans) accessible di markup.
- GSAP core + ScrollTrigger ter-bundle di `dist/`.
- Halaman home dummy (`front-page.php`) menampilkan hero placeholder dengan token brand terbaca.

---

## M1.1 — Theme directory + identity files

**Path**: `wp-content/themes/kastalabs/`

Files:
- `style.css` — header WP wajib (Theme Name, Version, dst.)
- `functions.php` — bootstrap, require `/inc/*.php`
- `index.php` — fallback minimal
- `screenshot.png` — placeholder 1200x900 (bisa pakai brand color block)
- `.gitignore` (root project sudah, theme tidak butuh sendiri)

**Verifikasi**: WP admin → Appearance → Themes menampilkan "KastaLabs". Klik Activate. Halaman frontend tidak fatal error (boleh blank).

---

## M1.2 — Build pipeline

**Path**: `wp-content/themes/kastalabs/`

Files:
- `package.json` — deps: `vite`, `tailwindcss@4`, `@tailwindcss/vite`, `gsap`, `eslint`, `prettier`
- `vite.config.js` — manifest output, base path, entry `src/js/app.js` + `src/css/app.css`
- `.gitignore` — `node_modules/`, `dist/`, `.vite/`
- `src/css/app.css` — `@import "tailwindcss"` + `@theme` block dengan 15-step palette + font + surface tokens
- `src/js/app.js` — boot file (DOM ready handler kosong dulu)

**Verifikasi**:
- `npm install` exit 0
- `npm run build` menghasilkan `dist/manifest.json` + `dist/assets/*.{js,css}`

---

## M1.3 — PHP modules (`inc/`)

**Files**:
- `inc/setup.php` — `add_theme_support`, nav menus, image sizes
- `inc/enqueue.php` — manifest-aware enqueue helper, font preconnect
- `inc/post-types.php` — register CPT `work`
- `inc/taxonomies.php` — `work_category`, `work_tag`
- `inc/meta.php` — register_post_meta untuk `client_name`, `project_year`, `project_url`, `role`, `scope`, `is_featured`, `cover_video`
- `inc/seo.php` — JSON-LD `CreativeWork` placeholder
- `inc/template-tags.php` — helper `kasta_asset()`, `kasta_eyebrow()`, dll.

**Verifikasi**: Activate theme → admin sidebar punya menu "Work" → bisa buat post baru tipe `work` dengan kategori.

---

## M1.4 — Frontend src

**Files**:
- `src/css/app.css` (sudah dimulai di M1.2) — full token + base layer
- `src/js/lib/gsap-init.js` — registerPlugin, defaults
- `src/js/lib/reduced-motion.js` — helper isReducedMotion()
- `src/js/components/reveal.js` — basic [data-reveal] handler
- `src/js/app.js` — bootstrap, panggil reveal.js

**Verifikasi**: `npm run build` masih exit 0 dengan semua file ter-import.

---

## M1.5 — Base templates

**Files**:
- `header.php` — `<!doctype>`, `<head>` dengan wp_head, body open, skip-link, simple nav
- `footer.php` — wp_footer, body close
- `index.php` — fallback (sudah di M1.1, tapi update jadi loop placeholder)
- `front-page.php` — hero placeholder (`<h1>` + paragraph + CTA dummy)
- `404.php` — minimal
- `search.php` — minimal
- `page.php` — generic page fallback

**Verifikasi**: Buka homepage di Laragon — tidak fatal, hero terlihat dengan font Plus Jakarta Sans + warna primary #007BFF accent. View source: ada `<link>` ke CSS bundle.

---

## M1.6 — End-to-end verification

1. `cd wp-content/themes/kastalabs && npm install`
2. `npm run build` (cek manifest dihasilkan)
3. WP admin → Appearance → Themes → Activate
4. Settings → Permalinks → Save (flush rewrite)
5. Buat 1 post tipe `work` dengan kategori dummy
6. Buka frontend `/` — homepage placeholder render
7. Buka `/work/{slug}` — fallback template render
8. View source — verify CSS bundle URL + JS bundle URL ada
9. Resize ke mobile — token responsif

**Tidak termasuk M1**:
- Real design implementation (M2 templates)
- Animasi penuh (M3)
- Custom Gutenberg blocks (M2 part of `case-study-body`)
- SEO plugin install (post-deploy / M4)

---

## Rollback Plan

Bila satu step gagal:
- File yang dibuat di step itu di-`git status` (atau Remove-Item langsung jika belum di-track)
- Theme yang sudah di-activate tinggal switch back ke twentytwentyfour
- DB tidak di-touch sama sekali — semua perubahan ada di filesystem theme

---

## Risk Register

| Risiko | Mitigasi |
| --- | --- |
| Tailwind v4 belum stable di npm | Pin version, fallback ke v3 jika perlu (catat di README) |
| Node version di Laragon mismatch | Cek `node -v` dulu, minimum 20 LTS |
| Vite manifest path tidak match WP | Test `kasta_asset()` di local, log path saat dev |
| WP cache plugin (kalau nanti install) override enqueue | Skip cache plugin di M1, install di M5 |
| GSAP plugin import path salah di v3.13+ | Pakai versi yang stable (3.13.0+), lihat docs/v3 |