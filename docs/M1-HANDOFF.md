# M1 Handoff — Foundation Complete

**Date**: 2026-05-30
**Milestone**: M1 Foundation
**Status**: ✅ Complete
**Next**: M2 Templates (real design implementation)

---

## TL;DR

Theme `kastalabs` aktif di `http://kastalabs.test/`. Build pipeline jalan, semua route render template yang benar. Foundation siap untuk M2.

## Verifikasi Akhir

| Route | Template | Status |
| --- | --- | --- |
| `/` | front-page.php (home) | HTTP 200 ✓ |
| `/work/` | archive-work.php | HTTP 200 ✓ |
| `/work/{slug}/` | single-work.php | HTTP 200 ✓ |
| `/blog/` | home.php (blog index) | HTTP 200 ✓ |
| `/{slug}/` (post) | single.php | HTTP 200 ✓ |
| `/notexist-404/` | 404.php | HTTP 404 ✓ |

Build: `npm run build` exit 0. CSS bundle 13.5KB, JS bundle 116KB (45.9KB gzip). PHP 20 file lulus syntax check di PHP 8.3.

## Yang Sudah Berfungsi

- ✅ Theme detected & activated di `Appearance > Themes`.
- ✅ Custom Post Type `work` dengan taxonomy `work_category` dan `work_tag`.
- ✅ Custom meta `client_name`, `project_year`, `project_url`, `role`, `scope`, `is_featured`, `cover_video` (REST-exposed).
- ✅ Pretty permalinks (`/%postname%/`) + `.htaccess` rewrite rules.
- ✅ Vite manifest-aware enqueue (CSS bundle + JS module).
- ✅ Brand tokens 15-step palette + Plus Jakarta Sans tertanam di CSS bundle.
- ✅ Image sizes: `kasta-cover` 1920x1080, `kasta-card` 960x720, `kasta-thumb` 480x360.
- ✅ Nav menu locations: primary, footer, social.
- ✅ Skip-link, focus-visible ring, prefers-reduced-motion respect.
- ✅ JSON-LD `CreativeWork` di single-work template.
- ✅ Template-tag helpers: `kasta_eyebrow()`, `kasta_site_logo()`, `kasta_reading_time()`.
- ✅ GSAP core + ScrollTrigger ter-bundle, default `[data-reveal]` handler aktif.

## Konfigurasi WP yang Sudah Di-Set

- `permalink_structure` → `/%postname%/`
- `show_on_front` → `page`
- `page_on_front` → page "Home" (ID 9)
- `page_for_posts` → page "Blog" (ID 8)
- `blogname` → "KastaLabs"
- `blogdescription` → "Kreatif yang berdampak."

## Konten Dummy untuk Smoke Test

| Post | ID | Slug | Tipe |
| --- | --- | --- | --- |
| Dummy Brand Identity Project | 7 | `dummy-brand-identity` | work |
| Catatan pertama: theme aktif | 10 | `catatan-pertama` | post |
| Hello world! | 1 | `hello-world` | post (default WP) |
| Home | 9 | `home` | page |
| Blog | 8 | `blog` | page |

> Konten dummy boleh dihapus di M2 saat content asli mulai masuk.

## Cara Menjalankan Dev

```bash
cd C:\laragon\www\kastalabs\wp-content\themes\kastalabs

npm install              # sekali saja
npm run build            # production bundle
npm run dev              # vite dev server (HMR), butuh KASTA_VITE_DEV=true di wp-config.php
```

## Yang Belum di M1 (akan di M2+)

| Item | Milestone |
| --- | --- |
| Real visual design (mengikuti Figma export) | M2 |
| Custom Gutenberg blocks untuk case study body | M2 |
| Self-host Plus Jakarta Sans (woff2) | M2 |
| Animasi hero SplitText, marquee, magnetic button, sticky story | M3 |
| Page transitions (View Transitions API) | M3 |
| SEO plugin install + structured data lengkap | M4 |
| A11y audit + Lighthouse pass | M4 |
| Real konten case study + blog | M5 |

## Open Questions yang Masih Memblokir

Sebelum mulai M2, butuh konfirmasi:

1. **Figma export** — drop frame Home/Work/Blog/About/Contact ke `docs/figma/` sebagai PNG.
2. **SEO plugin** — Rank Math (rekomendasi) atau Yoast?
3. **Form plugin** — Fluent Forms (rekomendasi), CF7, atau Gravity?
4. **Hosting/domain produksi** — kastalabs.com sudah live? Mana stagingnya?
5. **Daftar layanan KastaLabs** untuk Services section di home.
6. **Analytics** — GA4, Plausible, atau none?
7. **Logo file** (.svg light + dark variant).

## Catatan Teknis

- WP version di environment ini: **7.0** (menarik — WP belum 7.0 stable; mungkin instalasi WP via Laragon mengembalikan version string 7.0). Cek `Settings > Updates` di admin untuk pastikan core update.
- Build pipeline pakai Tailwind v4.3.0 (config-via-CSS, tidak butuh `tailwind.config.js`).
- GSAP v3.13.0 di-bundle full (bukan dari CDN). SplitText dan plugin lain tinggal `import` saat dibutuhkan.
- `inc/enqueue.php` baca `dist/.vite/manifest.json` (Vite 5 path) dengan fallback ke `dist/manifest.json` (Vite ≤4).
- Saat `KASTA_VITE_DEV=true` di wp-config.php, bundle dari `localhost:5173` (Vite dev server). Default false.

## File Tree Final

```
docs/
  PRD.md                       # Product requirements
  TECH-DOC.md                  # Technical specifications
  EXEC-PLAN-M1.md              # M1 execution plan (ini file panduan eksekusi)
  M1-HANDOFF.md                # ← file ini
  brand-preview.html           # Brand token visual preview
  figma/
    color-shades-007BFF.png    # Source palette
    color-shades-007BFF.pdf
    README.md                  # Panduan drop Figma export

wp-content/themes/kastalabs/
  style.css                    # WP theme metadata
  functions.php                # Bootstrap (require /inc)
  header.php / footer.php      # Layout shell
  front-page.php               # Home
  archive.php / archive-work.php
  home.php                     # Blog index
  single.php / single-work.php
  page.php / 404.php / search.php / index.php
  package.json + vite.config.js + postcss.config.js
  README.md
  inc/
    setup.php                  # add_theme_support, nav menus, image sizes
    enqueue.php                # Vite manifest-aware enqueue
    post-types.php             # CPT 'work'
    taxonomies.php             # work_category, work_tag
    meta.php                   # custom meta untuk work
    seo.php                    # JSON-LD CreativeWork
    template-tags.php          # helper functions
  src/
    css/app.css                # Tailwind entry + design tokens
    css/editor.css             # Gutenberg editor styles
    js/app.js                  # Entrypoint
    js/lib/gsap-init.js        # GSAP register + defaults
    js/lib/reduced-motion.js   # Helper
    js/components/reveal.js    # [data-reveal] universal handler
  dist/                        # Build output (gitignored)
    .vite/manifest.json
    assets/app-{hash}.js
    assets/app-{hash}.css
    assets/editor-{hash}.css
```

## Sign-off

M1 foundation **shipped**. Theme aktif, build pipeline jalan, semua wiring core verified end-to-end via Laragon Apache. Siap menerima Figma design + konten asli untuk M2.