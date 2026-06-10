# KastaLabs WordPress Theme

Custom theme untuk kastalabs.com — company profile + portfolio + blog.
Stack: Tailwind CSS v4 + GSAP 3.x + Vite.

> Spesifikasi lengkap di `/docs/PRD.md`, `/docs/TECH-DOC.md`, `/docs/FRONTEND-PLANNING.md`.
> Worklog di `/docs/WORKLOG.md`.

## Status

- M1 Foundation ✅
- M2 Templates ✅ (all pages scaffolded)
- M3 Motion ✅ (GSAP code-split, hero reveal, page transitions, parallax)
- M4 Perf + A11y ✅ (font preload, View Transitions, favicon set)
- M5 Content Seed ✅ (4 portfolio + 3 insights + 4 services with realistic copy)
- M5 QA — **next**: run `npm run build`, PHP lint, route smoke test, Lighthouse audit

## Struktur

```
kastalabs/
  style.css              # WP theme header (metadata only)
  functions.php          # bootstrap, require /inc
  header.php / footer.php
  front-page.php         # home — 12 sections
  index.php              # fallback
  archive.php / home.php # blog
  page.php / 404.php / search.php
  page-about.php / page-services.php / page-contact.php
  archive-portfolio.php / archive-work.php (legacy)
  single-portfolio.php / single-work.php (legacy)
  archive-insight.php / single-insight.php
  single-service.php
  inc/                   # PHP modules (setup, enqueue, seo, media, icon, template-tags)
  src/
    css/app.css          # 1600+ line design system
    css/editor.css       # Gutenberg editor styles
    js/app.js            # Code-split entrypoint
    js/animations.js     # GSAP: reveal, magnetic, parallax, counter, tilt, FAQ, stagger
    js/components/       # text-split, marquee, mega-menu, mobile-menu, page-transition, etc.
    js/pages/            # home.js, portfolio-single.js, work-archive.js, blog-single.js
    fonts/               # Plus Jakarta Sans .woff2 (5 weights)
  template-parts/
    hero/                # home.php, page-hero.php
    sections/            # 12 sections (marquee, services, statement, work-grid, etc.)
    cards/               # work-card, insight-card, service-card, process-card, testimonial-card, team-card
    ui/                  # badge, button, card, heading, form-field, faq-item, etc.
    layout/              # header, footer
    navigation/          # mega-menu, mobile-menu, menu-footer, menu-social, skip-link
    forms/               # contact-form, newsletter-form, search-form
    post/                # post-meta, post-author, post-share, post-tags, post-thumbnail
    meta/                # seo-jsonld, social-meta
  assets/
    icons/heroicons/     # SVG icon library
    favicon.svg / favicon.png
  dist/                  # Build output (gitignored)
  languages/             # i18n
```

## Setup

Butuh Node 20+. Dari `wp-content/themes/kastalabs/`:

```bash
npm install
npm run build       # production bundle ke dist/
npm run dev         # vite dev server di http://localhost:5173
```

Saat dev mode, tambahkan ke `wp-config.php`:

```php
define( 'KASTA_VITE_DEV', true );
```

## Activate

WP Admin → Appearance → Themes → Kastalabs → Activate.
Lalu Settings → Permalinks → Save (flush rewrite rules).

## Brand Tokens

- Primary: `#0B5CFF` (zoom-blue), 15-step extended scale anchored at `#007BFF`
- Surface: `#FFFFFF` (bg), `#E7F0FF` (surface), `#000C1A` (fg), `#495A69` (muted)
- Navy: `#000B3F`
- Font: Plus Jakarta Sans (self-hosted, weights 400-800)

## Routes

| Route | Template | Status |
|-------|----------|--------|
| `/` | front-page.php | ✅ |
| `/about/` | page-about.php | ✅ |
| `/services/` | page-services.php | ✅ |
| `/services/{slug}/` | single-service.php | ✅ |
| `/portfolio/` | archive-portfolio.php | ✅ |
| `/portfolio/{slug}/` | single-portfolio.php | ✅ |
| `/insights/` | archive-insight.php | ✅ |
| `/insights/{slug}/` | single-insight.php | ✅ |
| `/contact/` | page-contact.php | ✅ |
| `/blog/` | home.php | ✅ |
| `/work/` | archive-work.php | ⚠️ Legacy, akan redirect ke /portfolio/ |
| `/work/{slug}/` | single-work.php | ⚠️ Legacy |
| `/search/` | search.php | ✅ |
| `/404` | 404.php | ✅ |
