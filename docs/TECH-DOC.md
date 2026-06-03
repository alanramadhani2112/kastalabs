# Tech Doc — KastaLabs WordPress Theme

**Companion to**: [`PRD.md`](./PRD.md)
**Stack**: WordPress 6.x + PHP 8.2+ + Tailwind CSS v4 + GSAP 3.x + Vite
**Version**: 0.1 — Draft
**Date**: 2026-05-30

---

## 1. Lingkungan Target

### 1.1 Server / Runtime
| Komponen | Versi minimum | Rekomendasi |
| --- | --- | --- |
| PHP | 8.1 | 8.2 atau 8.3 |
| WordPress | 6.4 | 6.5+ |
| MySQL | 8.0 / MariaDB 10.6 | MariaDB 10.11 |
| Web server | Nginx atau Apache + mod_rewrite | Nginx + PHP-FPM |
| Node.js (build only) | 20 LTS | 22 LTS |
| HTTPS | wajib | Let's Encrypt / Cloudflare |

### 1.2 Lokal Dev
- Laragon (Windows) terdeteksi di `C:\laragon\www\kastalabs`. WordPress core sudah ter-install (`wp-config.php` ada, DB `kastalabs` di MySQL local).
- Theme dikembangkan di `wp-content/themes/kastalabs/`.
- Build assets keluar ke `wp-content/themes/kastalabs/dist/`.

### 1.3 Browser Target
- Chrome / Edge: 2 versi terakhir
- Safari: 16+
- Firefox: 2 versi terakhir
- iOS Safari: 16+
- Android Chrome: 2 versi terakhir
- Graceful degradation untuk older browsers (animasi off, layout tetap utuh).

---

## 2. Arsitektur Tinggi

```
┌────────────────────────────────────────────────────────────────┐
│                       Browser (client)                         │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  HTML (SSR by WP/PHP)                                    │  │
│  │  + Tailwind utility CSS (compiled)                       │  │
│  │  + JS bundle (GSAP, components, page transitions)        │  │
│  └──────────────────────────────────────────────────────────┘  │
└────────────────────────────────────────────────────────────────┘
              │ HTTP                         ▲
              ▼                              │
┌────────────────────────────────────────────────────────────────┐
│                      WordPress (server)                        │
│  ┌──────────────────┐  ┌──────────────────────────────────┐    │
│  │  Theme           │  │  Plugins                         │    │
│  │  - templates     │  │  - SEO (Rank Math)               │    │
│  │  - functions.php │  │  - Form (Fluent / CF7)           │    │
│  │  - blocks        │  │  - Cache (WP Rocket / W3TC)      │    │
│  │  - dist/ assets  │  │  - Security (Wordfence/iThemes)  │    │
│  └──────────────────┘  │  - Backup (UpdraftPlus)          │    │
│                        └──────────────────────────────────┘    │
│                                                                │
│  REST API + GraphQL (opsional via WPGraphQL — not needed MVP)  │
└────────────────────────────────────────────────────────────────┘
              │
              ▼
       MySQL / MariaDB
```

Pendekatan: **classic SSR WordPress theme** (bukan headless). Alasan: SEO instan, hosting murah, tim non-tech bisa edit konten via WP admin.

---

## 3. Struktur Folder Theme

```
wp-content/themes/kastalabs/
├── style.css                     # WP theme header (wajib)
├── functions.php                 # Bootstrap (load semua di /inc)
├── index.php                     # Fallback template
├── header.php
├── footer.php
├── sidebar.php                   # Tidak dipakai (no sidebar default), kosongkan / hilangkan
├── 404.php
├── search.php
├── front-page.php                # Home
├── archive.php                   # Generic archive fallback
├── archive-work.php              # Portfolio index
├── single-work.php               # Case study detail
├── home.php                      # Blog index
├── single.php                    # Blog post
├── page.php                      # Generic page fallback
├── page-about.php                # About
├── page-contact.php              # Contact
├── taxonomy-work_category.php    # Filtered work archive
├── inc/
│   ├── setup.php                 # add_theme_support, nav menus, image sizes
│   ├── enqueue.php               # wp_enqueue_scripts/styles
│   ├── post-types.php            # CPT 'work'
│   ├── taxonomies.php            # work_category, work_tag
│   ├── blocks.php                # register custom blocks
│   ├── meta.php                  # register_post_meta untuk custom fields
│   ├── seo.php                   # JSON-LD, OG meta override (jika tidak full pakai Rank Math)
│   ├── reading-time.php
│   ├── menu-walker.php
│   ├── template-tags.php         # helper functions (kasta_get_*)
│   └── customizer.php            # opsional, bila pakai Customizer
├── template-parts/
│   ├── hero/
│   │   ├── hero-home.php
│   │   ├── hero-work.php
│   │   └── hero-blog.php
│   ├── sections/
│   │   ├── services.php
│   │   ├── featured-work.php
│   │   ├── testimonials.php
│   │   ├── latest-blog.php
│   │   └── cta-banner.php
│   ├── cards/
│   │   ├── card-work.php
│   │   ├── card-post.php
│   │   └── card-team.php
│   └── meta/
│       └── seo-jsonld.php
├── blocks/                       # Gutenberg block sources (block.json + edit/view)
│   ├── section-heading/
│   ├── stat-row/
│   ├── image-pair/
│   └── case-study-body/          # flexible content untuk single-work
├── src/                          # Source assets (build input)
│   ├── css/
│   │   ├── app.css               # Tailwind entry
│   │   └── editor.css            # Block editor styling
│   ├── js/
│   │   ├── app.js                # entrypoint
│   │   ├── lib/
│   │   │   ├── gsap-init.js      # registerPlugin, defaults
│   │   │   ├── reduced-motion.js
│   │   │   └── lenis.js          # smooth scroll (opsional)
│   │   ├── components/
│   │   │   ├── magnetic-button.js
│   │   │   ├── marquee.js
│   │   │   ├── reveal.js
│   │   │   ├── parallax.js
│   │   │   ├── sticky-story.js
│   │   │   └── filter-grid.js
│   │   └── pages/
│   │       ├── home.js
│   │       ├── work-archive.js
│   │       ├── work-single.js
│   │       └── blog.js
│   └── img/                      # static images, icons, lottie
├── dist/                         # build output (gitignore)
├── languages/                    # i18n .pot/.po/.mo
├── package.json
├── vite.config.js
├── tailwind.config.js            # (Tailwind v4 mostly css-config, file ini opsional)
├── postcss.config.js
├── .editorconfig
├── .gitignore
├── README.md                     # developer handover
└── screenshot.png                # 1200x900 — preview di WP admin
```

---

## 4. Build Pipeline

### 4.1 Tooling
- **Vite** — bundler utama. Cepat, ESM-native, HMR.
- **Tailwind CSS v4** — config via CSS (`@theme` block), tanpa `tailwind.config.js` wajib.
- **PostCSS** — autoprefixer + nesting.
- **@wordpress/scripts** — hanya untuk build custom block (block.json + JSX/edit). Sisanya Vite.

### 4.2 NPM Scripts
```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "blocks:dev": "wp-scripts start",
    "blocks:build": "wp-scripts build",
    "lint:js": "eslint src/js",
    "lint:css": "stylelint src/css/**/*.css",
    "format": "prettier --write \"src/**/*.{js,css}\""
  }
}
```

### 4.3 Vite Config (sketsa)
```js
// vite.config.js
import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  base: '/wp-content/themes/kastalabs/dist/',
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    manifest: true,                 // dipakai PHP enqueue untuk versioned assets
    rollupOptions: {
      input: {
        app: resolve(__dirname, 'src/js/app.js'),
        editor: resolve(__dirname, 'src/css/editor.css'),
      },
    },
  },
  server: {
    origin: 'http://localhost:5173',
    cors: true,
  },
});
```

### 4.4 PHP Enqueue (manifest-aware)
- Saat dev (`WP_DEBUG=true` + file `dist/.dev` ada): inject `http://localhost:5173/@vite/client` dan `src/js/app.js` dari Vite dev server.
- Saat prod: baca `dist/manifest.json`, enqueue file ber-hash.
- Helper: `inc/enqueue.php` punya `kasta_vite_asset($entry)` yang return URL final.

### 4.5 Tailwind v4 Setup
- Tidak butuh `tailwind.config.js` mandatory. Konfigurasi via CSS:
```css
/* src/css/app.css */
@import "tailwindcss";

@theme {
  /* === Brand Primary — 15-step extended scale (LOCKED 2026-05-30) === */
  /* Source: brand color shades kit, anchor #007BFF at step 5 */
  --color-primary-50:   #CCE5FF;   /* step 0   */
  --color-primary-75:   #B8DAFF;   /* step 0.5 */
  --color-primary-100:  #A3D0FF;   /* step 1   */
  --color-primary-150:  #8FC5FF;   /* step 1.5 */
  --color-primary-200:  #7ABBFF;   /* step 2   */
  --color-primary-300:  #52A5FF;   /* step 3   */
  --color-primary-400:  #2990FF;   /* step 4   */
  --color-primary-500:  #007BFF;   /* step 5 — anchor */
  --color-primary-600:  #0067D6;   /* step 6   */
  --color-primary-700:  #005AAD;   /* step 7   */
  --color-primary-800:  #004085;   /* step 8   */
  --color-primary-850:  #003670;   /* step 8.5 */
  --color-primary-900:  #002D5C;   /* step 9   */
  --color-primary-925:  #002347;   /* step 9.5 */
  --color-primary-950:  #001933;   /* step 10  */

  /* Semantic alias (yang dipakai sehari-hari di markup) */
  --color-primary:       var(--color-primary-500);
  --color-primary-hover: var(--color-primary-600);
  --color-primary-press: var(--color-primary-700);

  /* Surfaces (sementara — final saat brand file lengkap masuk) */
  --color-bg:      #0A0A0B;
  --color-fg:      #F4F4F0;
  --color-surface: #141416;
  --color-muted:   #7A7A75;

  /* Typography (LOCKED 2026-05-30) */
  --font-display: "Plus Jakarta Sans", system-ui, sans-serif;
  --font-body:    "Plus Jakarta Sans", system-ui, sans-serif;
  --font-mono:    "JetBrains Mono", ui-monospace, monospace;
}

@layer base {
  html { color-scheme: dark; }
  body { @apply bg-bg text-fg font-body antialiased; }
  ::selection { @apply bg-primary text-fg; }
  :focus-visible { @apply outline-2 outline-offset-2 outline-primary; }
}
```

#### Plus Jakarta Sans — Self-host

Self-host font supaya tidak dependent ke Google Fonts (privacy + performance + GDPR friendly).

1. Download file `.woff2` dari [google-webfonts-helper](https://gwfh.mranftl.com/fonts/plus-jakarta-sans) untuk weights yang dipakai (rekomendasi: **400, 500, 600, 700, 800**).
2. Taruh di `src/fonts/plus-jakarta-sans/`.
3. Declare di `src/css/app.css` di atas `@import "tailwindcss";`:

```css
@font-face {
  font-family: "Plus Jakarta Sans";
  src: url("/wp-content/themes/kastalabs/dist/fonts/plus-jakarta-sans-400.woff2") format("woff2");
  font-weight: 400;
  font-style: normal;
  font-display: swap;
}
@font-face {
  font-family: "Plus Jakarta Sans";
  src: url("/wp-content/themes/kastalabs/dist/fonts/plus-jakarta-sans-600.woff2") format("woff2");
  font-weight: 600;
  font-style: normal;
  font-display: swap;
}
/* repeat untuk 500, 700, 800 */
```

4. Preload font weight LCP (yang dipakai hero) di `header.php`:

```php
<link rel="preload" as="font" type="font/woff2"
      href="<?php echo esc_url(get_template_directory_uri()); ?>/dist/fonts/plus-jakarta-sans-700.woff2"
      crossorigin>
```
```

---

## 5. WordPress Theme Implementation

### 5.1 `style.css` (header WP wajib)
```css
/*
Theme Name:   KastaLabs
Theme URI:    https://kastalabs.com
Author:       KastaLabs
Author URI:   https://kastalabs.com
Description:  Custom theme for KastaLabs — portfolio + blog. Tailwind + GSAP.
Version:      0.1.0
License:      Proprietary
Text Domain:  kastalabs
Requires at least: 6.4
Requires PHP: 8.1
*/
```
Bundle CSS sesungguhnya keluar dari Vite. File `style.css` ini hanya untuk metadata WP.

### 5.2 `functions.php` (tipis)
```php
<?php
defined('ABSPATH') || exit;

const KASTA_VERSION = '0.1.0';
const KASTA_THEME_PATH = __DIR__;
const KASTA_THEME_URI  = '';                  // diisi di setup.php via get_template_directory_uri()

require __DIR__ . '/inc/setup.php';
require __DIR__ . '/inc/enqueue.php';
require __DIR__ . '/inc/post-types.php';
require __DIR__ . '/inc/taxonomies.php';
require __DIR__ . '/inc/meta.php';
require __DIR__ . '/inc/blocks.php';
require __DIR__ . '/inc/seo.php';
require __DIR__ . '/inc/reading-time.php';
require __DIR__ . '/inc/template-tags.php';
```

### 5.3 Theme support
```php
// inc/setup.php
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_editor_style('dist/editor.css');
    add_theme_support('align-wide');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Primary', 'kastalabs'),
        'footer'  => __('Footer', 'kastalabs'),
        'social'  => __('Social', 'kastalabs'),
    ]);

    add_image_size('kasta-cover', 1920, 1080, true);
    add_image_size('kasta-card',  960, 720, true);
    add_image_size('kasta-thumb', 480, 360, true);
});
```

### 5.4 Custom Post Type `work`
```php
// inc/post-types.php
add_action('init', function () {
    register_post_type('work', [
        'label'         => __('Work', 'kastalabs'),
        'public'        => true,
        'show_in_rest'  => true,                 // wajib supaya block editor jalan
        'has_archive'   => 'work',
        'rewrite'       => ['slug' => 'work', 'with_front' => false],
        'menu_icon'     => 'dashicons-portfolio',
        'supports'      => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields'],
        'template'      => [
            ['kastalabs/section-heading'],
            ['core/paragraph'],
        ],
    ]);
});
```

### 5.5 Taxonomies
```php
// inc/taxonomies.php
add_action('init', function () {
    register_taxonomy('work_category', ['work'], [
        'label'        => __('Categories', 'kastalabs'),
        'public'       => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => ['slug' => 'work/category'],
    ]);
    register_taxonomy('work_tag', ['work'], [
        'label'        => __('Tags', 'kastalabs'),
        'public'       => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite'      => ['slug' => 'work/tag'],
    ]);
});
```

### 5.6 Custom Meta (register_post_meta)
```php
// inc/meta.php — semua expose ke REST untuk block editor
$fields = [
    'client_name'  => 'string',
    'project_year' => 'integer',
    'project_url'  => 'string',
    'role'         => 'string',
    'scope'        => 'string',
    'is_featured'  => 'boolean',
    'cover_video'  => 'string',
];
foreach ($fields as $key => $type) {
    register_post_meta('work', $key, [
        'type'         => $type,
        'single'       => true,
        'show_in_rest' => true,
        'auth_callback'=> fn() => current_user_can('edit_posts'),
    ]);
}
```

### 5.7 Asset Enqueue
```php
// inc/enqueue.php
add_action('wp_enqueue_scripts', function () {
    $manifest = KASTA_THEME_PATH . '/dist/manifest.json';
    if (!file_exists($manifest)) return;

    $entries = json_decode(file_get_contents($manifest), true);
    $app = $entries['src/js/app.js'] ?? null;
    if (!$app) return;

    $base = get_template_directory_uri() . '/dist/';

    // CSS
    foreach (($app['css'] ?? []) as $css) {
        wp_enqueue_style('kasta-' . md5($css), $base . $css, [], KASTA_VERSION);
    }
    // JS (module)
    wp_enqueue_script_module('kasta-app', $base . $app['file'], [], KASTA_VERSION);
});

// Inline preconnect/font hints
add_action('wp_head', function () {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>';
}, 1);
```

### 5.8 SEO + JSON-LD
- Plugin SEO (Rank Math direkomendasi) menangani title, meta description, OG, sitemap, breadcrumb.
- Theme menambahkan **JSON-LD tambahan** yang plugin tidak generate (mis. `CreativeWork` untuk CPT `work`):
```php
// inc/seo.php
add_action('wp_head', function () {
    if (is_singular('work')) {
        $post = get_queried_object();
        $data = [
            '@context'   => 'https://schema.org',
            '@type'      => 'CreativeWork',
            'name'       => get_the_title($post),
            'url'        => get_permalink($post),
            'image'      => get_the_post_thumbnail_url($post, 'kasta-cover'),
            'creator'    => [
                '@type' => 'Organization',
                'name'  => get_bloginfo('name'),
                'url'   => home_url('/'),
            ],
            'dateCreated'=> get_the_date('c', $post),
        ];
        $client = get_post_meta($post->ID, 'client_name', true);
        if ($client) {
            $data['producer'] = ['@type' => 'Organization', 'name' => $client];
        }
        echo "\n<script type=\"application/ld+json\">" . wp_json_encode($data) . "</script>\n";
    }
}, 30);
```

---

## 6. Frontend Architecture

### 6.1 JS Entrypoint
```js
// src/js/app.js
import { initGsap } from './lib/gsap-init.js';
import { isReducedMotion } from './lib/reduced-motion.js';

// Components (always-on, idempotent)
import { initReveal } from './components/reveal.js';
import { initMagnetic } from './components/magnetic-button.js';
import { initMarquee } from './components/marquee.js';

// Page-specific (lazy)
const PAGE_LOADERS = {
  'home':         () => import('./pages/home.js'),
  'work-archive': () => import('./pages/work-archive.js'),
  'work-single':  () => import('./pages/work-single.js'),
  'blog':         () => import('./pages/blog.js'),
};

function bootstrap() {
  initGsap();
  initReveal();
  initMagnetic();
  initMarquee();

  if (isReducedMotion()) {
    document.documentElement.dataset.motion = 'reduced';
    return;
  }

  const page = document.body.dataset.page;
  const loader = PAGE_LOADERS[page];
  if (loader) loader().then(mod => mod.default?.());
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', bootstrap);
} else {
  bootstrap();
}
```

### 6.2 GSAP Setup
```js
// src/js/lib/gsap-init.js
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { SplitText } from 'gsap/SplitText';

export function initGsap() {
  gsap.registerPlugin(ScrollTrigger, SplitText);
  gsap.defaults({ ease: 'power3.out', duration: 0.6 });
  ScrollTrigger.config({ ignoreMobileResize: true });

  // Refresh on font load (mencegah jitter di hero SplitText)
  if (document.fonts) {
    document.fonts.ready.then(() => ScrollTrigger.refresh());
  }
}
```

### 6.3 Reveal-on-scroll (universal section reveal)
```js
// src/js/components/reveal.js
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

export function initReveal() {
  gsap.utils.toArray('[data-reveal]').forEach((el) => {
    gsap.from(el, {
      y: 40,
      autoAlpha: 0,
      duration: 0.9,
      scrollTrigger: { trigger: el, start: 'top 85%', once: true },
    });
  });
}
```

### 6.4 Hero SplitText
```js
// src/js/pages/home.js
import { gsap } from 'gsap';
import { SplitText } from 'gsap/SplitText';

export default function initHome() {
  const heading = document.querySelector('[data-hero-heading]');
  if (!heading) return;

  const split = new SplitText(heading, { type: 'lines,words', linesClass: 'overflow-hidden' });
  gsap.from(split.words, {
    yPercent: 110,
    duration: 1.1,
    ease: 'expo.out',
    stagger: 0.04,
  });
}
```

### 6.5 Magnetic Button
```js
// src/js/components/magnetic-button.js
import { gsap } from 'gsap';

const STRENGTH = 0.35;

export function initMagnetic() {
  const els = document.querySelectorAll('[data-magnetic]');
  els.forEach((el) => {
    const onMove = (e) => {
      const r = el.getBoundingClientRect();
      const x = (e.clientX - (r.left + r.width / 2)) * STRENGTH;
      const y = (e.clientY - (r.top + r.height / 2)) * STRENGTH;
      gsap.to(el, { x, y, duration: 0.4, ease: 'power3.out' });
    };
    const onLeave = () => gsap.to(el, { x: 0, y: 0, duration: 0.6, ease: 'elastic.out(1,0.4)' });
    el.addEventListener('pointermove', onMove);
    el.addEventListener('pointerleave', onLeave);
  });
}
```

### 6.6 Page Transitions (View Transitions API)
```js
// src/js/lib/transitions.js
if ('startViewTransition' in document) {
  document.addEventListener('click', (e) => {
    const a = e.target.closest('a[href]');
    if (!a) return;
    const url = new URL(a.href, location.href);
    if (url.origin !== location.origin) return;
    if (a.target === '_blank' || a.hasAttribute('download')) return;
    e.preventDefault();
    document.startViewTransition(async () => {
      const html = await fetch(url).then((r) => r.text());
      // swap <main> isi (atau full body)
      const doc = new DOMParser().parseFromString(html, 'text/html');
      document.querySelector('main').replaceWith(doc.querySelector('main'));
      document.title = doc.title;
      // re-init dynamic components
      window.dispatchEvent(new CustomEvent('kasta:navigated'));
    });
  });
}
```
> **Catatan**: bila View Transitions API tidak didukung, fallback default (full reload). Bila stakeholder ingin SPA penuh + control lebih, ganti ke Barba.js.

### 6.7 Reduced Motion Helper
```js
// src/js/lib/reduced-motion.js
export const isReducedMotion = () =>
  window.matchMedia('(prefers-reduced-motion: reduce)').matches;
```
Setiap inisialisasi animasi non-essential (parallax, marquee infinite, magnetic) dilewati saat reduced motion aktif. Section reveal tetap aktif tetapi diset `instant` (no transform).

---

## 7. Komponen Reusable (Mapping ke PRD)

| ID | Selector | Implementasi |
| --- | --- | --- |
| Hero Home | `[data-hero-heading]` di `front-page.php` | `pages/home.js` SplitText + parallax bg |
| Marquee logos | `[data-marquee]` | `components/marquee.js` infinite tween |
| Featured work grid | `[data-work-grid]` + `[data-filter]` | `components/filter-grid.js` tanpa lib (vanilla) |
| Sticky story | `[data-sticky-story]` | `components/sticky-story.js` ScrollTrigger pin + scrub |
| Stat counter | `[data-counter]` | tween numeric |
| Cursor trail (opsional) | `[data-cursor]` di `<body>` | `components/cursor.js` Observer plugin |
| Image parallax | `[data-parallax]` | ScrollTrigger scrub `y: ±15%` |

---

## 8. Plugin WordPress (rekomendasi)

| Kategori | Pilihan utama | Alternatif |
| --- | --- | --- |
| SEO | **Rank Math** | Yoast SEO, SEOPress |
| Form | **Fluent Forms** | Contact Form 7, Gravity Forms |
| Cache | **WP Rocket** (berbayar) | LiteSpeed Cache (jika host LiteSpeed), W3 Total Cache |
| Image optimize | **ShortPixel** atau host CDN auto-WebP | EWWW Image Optimizer |
| Security | **Wordfence** atau **iThemes Security** | Solid Security |
| Backup | **UpdraftPlus** | All-in-One WP Migration |
| Redirects | **Redirection** | Rank Math built-in |
| Cookie banner | **Complianz** | CookieYes |
| Analytics | GA4 lewat **Site Kit by Google** | Plausible plugin |
| Anti-spam | **Akismet** + honeypot di Fluent | Cloudflare Turnstile |

> Hindari page builder berat (Elementor/Divi/Beaver). Theme custom + Gutenberg sudah cukup.

---

## 9. SEO Implementation Checklist (mapped to PRD §8)

- [ ] Title tag via `add_theme_support('title-tag')` + Rank Math template.
- [ ] Meta description Rank Math default + override per post.
- [ ] Canonical URL otomatis Rank Math.
- [ ] OG / Twitter card otomatis Rank Math; default OG image set di Rank Math + theme options.
- [ ] JSON-LD `Organization`, `WebSite`, `BreadcrumbList`, `Article`, `Person` — Rank Math.
- [ ] JSON-LD `CreativeWork` untuk CPT `work` — di `inc/seo.php` (kode di §5.8).
- [ ] XML sitemap split (post, page, work, category, work_category) — Rank Math.
- [ ] `robots.txt`:
  ```
  User-agent: *
  Disallow: /wp-admin/
  Allow: /wp-admin/admin-ajax.php
  Sitemap: https://kastalabs.com/sitemap_index.xml
  ```
- [ ] Hero image `fetchpriority="high"` + `<link rel="preload">` (lewat helper di header.php saat front-page).
- [ ] Lazy-load default WP untuk gambar non-hero.
- [ ] Self-host fonts → `font-display: swap`.
- [ ] Inline critical CSS untuk above-the-fold (Vite plugin `vite-plugin-critical` atau handcraft).
- [ ] Pre-render reading time + breadcrumb agar tampil server-side.

---

## 10. Performance Budget

| Metric (mobile, slow 4G) | Budget |
| --- | --- |
| LCP | ≤ 2.5s |
| INP | ≤ 200ms |
| CLS | ≤ 0.1 |
| Total JS (gzip) initial | ≤ 80KB |
| Total CSS (gzip) initial | ≤ 30KB |
| Hero image (WebP) | ≤ 180KB |
| Total page weight (home) | ≤ 800KB |
| Time to Interactive | ≤ 3.5s |

### 10.1 Strategi
- GSAP core ~ 22KB gzip. ScrollTrigger ~ 10KB. SplitText ~ 8KB. Hanya load di halaman yang butuh.
- Code-split `pages/*` lewat dynamic import (lihat §6.1).
- `loading="lazy"` + `decoding="async"` untuk semua image non-LCP.
- Video hero pakai `preload="metadata"`, poster image, dan `playsinline muted autoplay` (mobile-friendly).
- Lighthouse CI di GitHub Actions (opsional, post-MVP).

---

## 11. Accessibility Implementation

- Semantic landmark: `<header role="banner">`, `<main>`, `<nav role="navigation">`, `<footer role="contentinfo">`.
- Skip link di `header.php`:
  ```html
  <a class="sr-only focus:not-sr-only ..." href="#main">Skip to content</a>
  ```
- Focus ring custom Tailwind v4:
  ```css
  @layer base {
    :focus-visible { @apply outline-2 outline-offset-2 outline-accent; }
  }
  ```
- Modal & dialog pakai `<dialog>` native + `inert` saat closed.
- Carousel/slider: keyboard arrow + `aria-roledescription="carousel"`.
- Tes axe-core via `@axe-core/cli` di local + manual screen reader (NVDA / VoiceOver).

---

## 12. Internationalization

- Semua string PHP `__('...', 'kastalabs')` / `_e()`.
- Generate `.pot` via `wp i18n make-pot . languages/kastalabs.pot`.
- MVP: ID-only. Struktur sudah siap untuk MultilingualPress / Polylang nanti.

---

## 13. Local Development

### 13.1 Setup
```bash
# clone (atau langsung di Laragon www)
cd C:\laragon\www\kastalabs\wp-content\themes\kastalabs

npm install
npm run dev          # vite dev server di http://localhost:5173
```

### 13.2 wp-config tambahan untuk dev
```php
// wp-config.php (tambahkan)
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);
define('KASTA_VITE_DEV', true);     // di-pick up oleh inc/enqueue.php
```

### 13.3 Activate theme
- WP Admin → Appearance → Themes → Activate "KastaLabs".
- Permalink → Settings → Permalinks → "Post name" → Save (rebuild rewrite rules untuk CPT).

---

## 14. CI / CD (post-MVP, optional)

- GitHub Actions:
  - `lint`: eslint + stylelint + phpcs (WordPress-Extra).
  - `build`: `npm ci && npm run build` → upload artifact.
  - `deploy`: rsync ke server, atau push ke staging via WP Pusher / Git Updater.
- Staging environment terpisah dari production.

---

## 15. Testing Strategy

| Layer | Tool |
| --- | --- |
| Lint JS | ESLint (airbnb-base + custom) |
| Lint CSS | Stylelint (standard + tailwind plugin) |
| Lint PHP | PHPCS (WordPress-Extra ruleset) |
| Visual regression | (opsional) Playwright + percy / loki |
| A11y | axe-core CLI + manual NVDA/VoiceOver |
| Lighthouse | manual + Lighthouse CI |
| Cross-device | BrowserStack atau real device + Chrome DevTools throttling |

Tidak perlu unit test PHP berat untuk MVP — theme presentational. Bila nanti ada logic kompleks (custom REST endpoint), tambahkan PHPUnit/wp-phpunit.

---

## 16. Deployment

### 16.1 Pre-launch checklist
- [ ] Semua plugin update.
- [ ] WP_DEBUG = false di production.
- [ ] Permalink "Post name".
- [ ] SSL aktif, redirect 301 HTTP→HTTPS.
- [ ] HSTS header (via host atau plugin).
- [ ] Rank Math: site verification, sitemap submit ke GSC + Bing Webmaster.
- [ ] GA4 / Plausible terpasang dan event test.
- [ ] Backup harian aktif.
- [ ] Form contact test live (kirim & terima).
- [ ] 404 page custom test.
- [ ] Sitemap.xml akses publik.
- [ ] `robots.txt` benar.
- [ ] Open Graph debugger (Facebook + Twitter card validator).
- [ ] Lighthouse pass.
- [ ] axe-core pass.

### 16.2 Hosting Recommendation
- **Cloudways** / **Kinsta** / **RunCloud** untuk managed WP.
- VPS minimal: 2 vCPU, 4GB RAM, 50GB SSD, NVMe lebih baik.
- Cloudflare di depan (CDN + WAF + DDoS).

---

## 17. Mapping ke PRD

| PRD Section | Tech Doc Section |
| --- | --- |
| §4 IA & Templates | §3 Folder, §5 Theme Implementation |
| §5 Content Model | §5.4–5.6 CPT/Tax/Meta |
| §6 Design Direction | §4.5 Tailwind tokens |
| §7 Motion | §6 Frontend, §6.2–6.6 GSAP |
| §8 SEO | §5.8 SEO code, §9 Checklist |
| §9 A11y | §11 |
| §10 Compliance | §16 Deployment, §8 Plugins |
| §12 Roadmap | §13 Dev setup, §14 CI/CD, §16 Deploy |

---

## 18. Open Engineering Questions

1. **Smooth scroll**: pakai [Lenis](https://lenis.darkroom.engineering/) untuk smooth scroll global, atau biarkan native? Lenis memberi feel premium tapi menambah JS dan kadang konflik dengan ScrollTrigger pin. Saya rekomendasi **tanpa Lenis di MVP**, evaluasi setelah konten masuk.
2. **Image CDN**: pakai built-in WP + ShortPixel, atau Cloudflare Images / Bunny.net? Tergantung budget dan trafik.
3. **Block editor vs ACF Flex**: case study body — saya rekomendasi **custom Gutenberg block** untuk maintainability long-term. ACF Flex lebih cepat dibangun tapi lock-in ke ACF.
4. **Search**: native WP search cukup, atau pasang Algolia / Relevanssi? MVP: native + Relevanssi free.
5. **Comment di blog**: aktif (default WP + Akismet), aktif via Disqus, atau matikan? Saya rekomendasi **matikan** untuk launch — fokus konten dulu.
6. **Newsletter**: butuh? Provider (Mailchimp / ConvertKit / Buttondown)?

---

## 19. Glosarium
- **CPT**: Custom Post Type
- **GSC**: Google Search Console
- **LCP / INP / CLS**: Core Web Vitals
- **JSON-LD**: Linked Data format untuk schema.org
- **WCAG 2.2 AA**: standar aksesibilitas web target

---

## 20. Referensi Teknis
- WP Theme Handbook: https://developer.wordpress.org/themes/
- Tailwind CSS v4: https://tailwindcss.com/docs/v4-beta
- GSAP docs: https://gsap.com/docs/v3/
- GSAP demos: https://demos.gsap.com/
- GSAP AI skills repo: https://github.com/greensock/gsap-skills
- Vite: https://vitejs.dev/
- Rank Math docs: https://rankmath.com/kb/
- View Transitions API: https://developer.mozilla.org/en-US/docs/Web/API/View_Transitions_API