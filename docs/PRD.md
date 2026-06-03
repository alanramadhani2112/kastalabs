# PRD — KastaLabs WordPress Theme

**Project**: Custom WordPress theme for kastalabs.com
**Visual reference**: [Salient Signal demo](https://themenectar.com/salient/signal/)
**Stack**: WordPress (custom theme) + Tailwind CSS + GSAP (ScrollTrigger, SplitText, Flip, Observer)
**Version**: 0.1 — Draft
**Date**: 2026-05-30
**Owner**: KastaLabs

---

## 1. Latar Belakang

KastaLabs membutuhkan website resmi yang berfungsi sebagai etalase digital untuk:
1. Memamerkan **portofolio** karya/proyek dengan kualitas presentasi setara studio kreatif premium.
2. Menerbitkan **blog** sebagai medium thought leadership dan SEO funnel.
3. Membangun kredibilitas merek lewat desain bertaraf agency.

Referensi utama (Salient Signal) adalah demo agency marketing dengan estetika editorial-cinematic, tipografi besar, scroll-driven storytelling, dan portfolio gallery yang interaktif. Kami **tidak** membeli atau mereplika Salient — kami membangun theme custom yang **terinspirasi** oleh kualitas presentasi Signal, dengan stack modern (Tailwind + GSAP) dan disesuaikan untuk identitas KastaLabs.

## 2. Tujuan & Hasil yang Diharapkan

### 2.1 Tujuan Bisnis
- **Konversi lead**: pengunjung mengirim inquiry via form kontak atau CTA "Start a Project".
- **Authority signaling**: setiap halaman terasa premium sehingga prospek percaya pada kapabilitas KastaLabs.
- **Discoverability**: ranking organik di Google untuk keyword industri target dalam 6 bulan pertama.

### 2.2 KPI
| Metrik | Target awal (3 bulan) |
| --- | --- |
| Lighthouse Performance (mobile) | ≥ 85 |
| Lighthouse SEO | ≥ 95 |
| Lighthouse Accessibility | ≥ 95 |
| Core Web Vitals (LCP / INP / CLS) | ≤ 2.5s / ≤ 200ms / ≤ 0.1 |
| Bounce rate landing page | ≤ 55% |
| Avg. session duration | ≥ 1m 30s |
| Indexed pages (Google Search Console) | 100% canonical pages |

### 2.3 Non-tujuan
- **Bukan** e-commerce / WooCommerce.
- **Bukan** multi-bahasa di MVP (i18n disiapkan, konten Bahasa Indonesia dulu).
- **Bukan** multi-author membership berbayar.
- **Bukan** klone fitur-fitur Salient yang tidak relevan (mega menu builder, demo importer, dll.).

---

## 3. Target Pengguna

### 3.1 Persona
- **P1 — Calon klien (decision maker)**: founder startup, marketing manager, brand owner. Mencari studio/agency untuk proyek branding, web, atau campaign. Datang dari referral atau Google.
- **P2 — Kandidat / kolaborator**: desainer/developer yang menilai kualitas KastaLabs sebelum melamar atau berkolaborasi.
- **P3 — Komunitas industri / SEO traffic**: pembaca blog yang mencari insight tech/design.

### 3.2 User Journey utama
1. **Landing → portfolio**: P1 masuk via homepage, scroll featured work, klik 1-2 case study, lalu CTA contact.
2. **Search → blog → portfolio**: P3 datang dari Google ke artikel blog, navigasi ke portfolio, lalu konversi.
3. **Direct → about → contact**: P1 dengan referral, validasi cepat tim/credentials, langsung ke contact.

---

## 4. Information Architecture

### 4.1 Sitemap

```
/                          Home
/work                      Portfolio index (filterable)
/work/{slug}               Case study detail
/blog                      Blog index
/blog/category/{slug}      Category archive
/blog/tag/{slug}           Tag archive
/blog/{slug}               Blog post
/about                     Tentang KastaLabs (cerita, tim, capabilities)
/services                  Daftar layanan (opsional, bisa section di Home)
/contact                   Form inquiry + info
/sitemap.xml               (Yoast/Rank Math)
/robots.txt                (statis)
/feed                      RSS (default WP)
```

### 4.2 Halaman & Komponen Utama

#### Home (`front-page.php`)
1. **Hero** — headline besar 2-3 baris, sub-copy, CTA primer ("Start a Project") + CTA sekunder ("See our work"). Background dapat berupa video loop, gambar, atau gradient + Lottie/SVG accent. Animasi entrance via GSAP SplitText (per-char/per-word reveal).
2. **Brand strip / clients** — logo grid grayscale, hover reveal, marquee opsional.
3. **Services overview** — 6 service card (Branding, Web Design, Motion, Content, Marketing, Strategy — final list TBD oleh user). Layout grid responsif. Hover micro-interaction.
4. **Featured Work** — filterable gallery 4-6 case study terbaik. Filter chip (All / kategori). Cards dengan reveal-on-scroll, image parallax/scrub.
5. **About teaser** — copy singkat + CTA ke `/about`.
6. **Testimonials** — slider/grid quote + nama + role + company. Min 3 entries.
7. **Latest blog** — 3 post terbaru dengan thumbnail.
8. **CTA banner** — "Let's build something" + tombol contact.
9. **Footer** — nav, sosmed, alamat, newsletter (opsional), legal links.

#### Portfolio Index (`archive-work.php`)
- Hero kecil + intro copy.
- Filter chip (kategori) + opsi sort (latest / featured).
- Grid masonry/asymmetric (variabel tinggi). Card animasi reveal stagger.
- Pagination atau infinite scroll (kept simple: numbered pagination MVP).

#### Case Study Detail (`single-work.php`)
- Cover hero — judul, klien, kategori, tahun, hero image/video full-bleed.
- Meta block — role, scope, durasi, link live (jika ada).
- Body — flexible content (heading, rich text, image single, image pair, image full, video embed, quote, gallery). Implementasi via Gutenberg block atau ACF Flexible Content.
- Next/prev project navigation.
- CTA contact bawah.

#### Blog Index (`home.php` atau `archive.php`)
- Hero kecil + tagline.
- Featured post (1 besar) + grid post (3-kolom desktop, 1-kolom mobile).
- Filter kategori, search bar.
- Pagination.

#### Blog Post (`single.php`)
- Hero — judul, kategori, author, tanggal, reading time, share buttons.
- Body — typography reading-optimized (max-w prose), drop cap opsional, blockquote, code highlighting (Prism/Shiki), image dengan caption.
- Author bio kecil di akhir.
- Related posts (3 terbaru kategori sama).
- Comment (default WP, opsional dimatikan).

#### About (`page-about.php`)
- Hero copy.
- Story timeline (vertical/horizontal scroll).
- Team grid (foto + nama + role).
- Capabilities/values list.
- CTA contact.

#### Contact (`page-contact.php`)
- Form (Name, Email, Company, Budget range, Project type, Message). Pakai Contact Form 7 atau Fluent Forms.
- Info samping — email, alamat, sosmed.
- Embedded map (opsional, lazy-load).

---

## 5. Content Model

### 5.1 Custom Post Types

#### `work` (Portfolio)
- Title, slug, excerpt
- Featured image (cover)
- Custom fields:
  - `client_name` (text)
  - `project_year` (number)
  - `project_url` (url)
  - `role` (text/multi)
  - `scope` (text/multi)
  - `is_featured` (boolean)
  - `cover_video` (mp4 url, opsional)
  - `body_blocks` (Gutenberg block content / ACF flexible)
- Taxonomies:
  - `work_category` (Branding, Web, Motion, Campaign, dll.)
  - `work_tag` (free-form)

#### `post` (Blog — built-in WP)
- Default WP fields + custom:
  - `reading_time_minutes` (auto-calc)
  - `is_featured` (boolean)
  - `cover_caption` (text)
- Taxonomies: `category`, `post_tag` (default).

### 5.2 Reusable Blocks / Components
- Hero Section
- Section Heading (eyebrow + title + sub)
- Image Pair / Image Full / Image Gallery
- Video Embed (YouTube/Vimeo/MP4)
- Quote Block
- Stat Row
- CTA Banner
- Testimonial Card

### 5.3 Theme Options (via ACF Options Page atau Customizer)
- Logo (light/dark variant)
- Primary CTA URL ("Start a Project")
- Sosmed links
- Footer copy
- Default OG image
- Newsletter form embed (opsional)
- Color tokens override (opsional)

---

## 6. Design Direction

### 6.1 Mood & Aesthetic
Inspirasi langsung dari Salient Signal:
- **Editorial-cinematic**: tipografi besar, headline berkarakter, banyak whitespace.
- **Dark-first dengan opsi light**: palette dasar dark (deep neutral), aksen warna brand. Light mode untuk reading-heavy (blog).
- **Motion sebagai narasi**: scroll mengungkap konten, bukan sekadar dekorasi.
- **Asymmetric grids**: 60/40, full-bleed media, off-grid headlines.

### 6.2 Brand Tokens (LOCKED 2026-05-30)

#### Primary Palette — 15-step Extended Scale

User memberikan palette extended (step 0 → 10 dengan half-step di 0.5, 1.5, 8.5, 9.5). Anchor `#007BFF` ada di **step 5**. Scale ini menggantikan palette 50–950 lebih awal.

| Step | Hex | Tailwind alias | Use case |
| --- | --- | --- | --- |
| 0 | `#CCE5FF` | `primary-50`  | Card / chip background di light context |
| 0.5 | `#B8DAFF` | `primary-75`  | Hover background untuk chip |
| 1 | `#A3D0FF` | `primary-100` | Subtle border / divider |
| 1.5 | `#8FC5FF` | `primary-150` | Inline highlight pada body |
| 2 | `#7ABBFF` | `primary-200` | Disabled/secondary icon |
| 3 | `#52A5FF` | `primary-300` | Tertiary surface accent |
| 4 | `#2990FF` | `primary-400` | Hover di link |
| **5** | **`#007BFF`** | **`primary` / `primary-500`** | **Brand color** — buttons, links, focus ring |
| 6 | `#0067D6` | `primary-600` | Hover state untuk primary button (light bg) |
| 7 | `#005AAD` | `primary-700` | Pressed state, deep accent |
| 8 | `#004085` | `primary-800` | Header bg di light mode, deep section bg |
| 8.5 | `#003670` | `primary-850` | Transition layer |
| 9 | `#002D5C` | `primary-900` | Dark section bg |
| 9.5 | `#002347` | `primary-925` | Transition layer |
| 10 | `#001933` | `primary-950` | Near-black brand, dark-mode bg alternatif |

> Aturan penggunaan: **utama ambil dari step utuh** (0, 1, 2, ..., 10). Half-step (0.5, 1.5, 8.5, 9.5) untuk transisi gradient atau state intermediate. Hindari menggunakan ini sebagai background utama agar visual rhythm tidak terlalu padat.

#### Surface & Text Tokens

| Token | Hex | Konteks |
| --- | --- | --- |
| `--color-bg` | `#0A0A0B` (near-black) | Sementara — konfirmasi setelah brand file lengkap masuk |
| `--color-surface` | `#141416` | Sementara |
| `--color-fg` | `#F4F4F0` | Sementara |
| `--color-muted` | `#7A7A75` | Sementara |

> Tokens surface/text masih sementara karena belum ada brand file lengkap (logo, neutral palette resmi). Primary palette sudah final.

#### Tipografi (LOCKED)

| Role | Font |
| --- | --- |
| Display + Body | **Plus Jakarta Sans** (Google Fonts) |
| Mono | JetBrains Mono / IBM Plex Mono (untuk code blocks di blog) |

Plus Jakarta Sans adalah font open-source (SIL OFL 1.1) dengan 8 weights (200–800) + italics. Cocok untuk display besar maupun body, dan punya identitas Indonesia. Self-host atau pakai Google Fonts dengan `font-display: swap`.

> **Catatan kontras**: `#007BFF` (primary 500) di atas `#0A0A0B` (bg) → contrast 5.4:1 (AA UI/large text ✅). `#FFFFFF` di atas `#007BFF` → contrast 4.0:1 (AA large ✅, AA normal ⚠️). Untuk button text hindari pure white kecil — pakai `#F4F4F0` atau weight 600+.

### 6.3 Tipografi
- Fluid typography (`clamp()`) — Tailwind plugin atau native CSS.
- Skala display besar untuk headline hero (clamp dari ~48px mobile ke ~120px desktop).
- Reading-optimized untuk blog (max-w `65ch`, leading `1.7`).

### 6.4 Layout & Spacing
- 12-col grid desktop, 4-col mobile.
- Container max-width responsive (1280–1440px).
- Spacing scale konsisten (Tailwind default).
- Section vertical padding besar (`py-24` to `py-40`).

### 6.5 Komponen Khas (terinspirasi Signal & demo GSAP)
- **Magnetic button** (CTA primer) — pakai pola dari [GSAP demo "Magnetic Button"](https://demos.gsap.com/).
- **Cursor trail / custom cursor** untuk desktop (opsional, respect prefers-reduced-motion).
- **Scrubbed bento gallery** untuk featured work (terinspirasi demo GSAP).
- **Velocity skew** pada hero text saat scroll cepat.
- **Marquee strip** untuk client logos.
- **Sticky scroll story** di case study (60/40 layout: media kiri pinned, copy kanan scrolling).

---

## 7. Interaction & Motion

### 7.1 Prinsip
- Animasi mendukung narasi, bukan distraksi.
- Konsisten — gunakan timing curve dan durasi yang seragam.
- Performant — animasikan `transform` dan `opacity` saja.
- Aksesibel — `prefers-reduced-motion: reduce` mematikan semua scroll-driven dan parallax.

### 7.2 Daftar Animasi Inti

| ID | Lokasi | Efek | Plugin GSAP |
| --- | --- | --- | --- |
| A-01 | Hero headline | SplitText reveal per-char/per-word stagger | SplitText |
| A-02 | Hero sub-copy | Fade + y translate sequence | Core |
| A-03 | Section reveal | y 40px + opacity 0→1 saat masuk viewport | ScrollTrigger |
| A-04 | Marquee logos | Infinite horizontal scroll | Core (timeline yoyo:false repeat:-1) |
| A-05 | Featured work cards | Stagger fade-up + image scale-in | ScrollTrigger |
| A-06 | Case study cover | Image parallax + headline scrub | ScrollTrigger scrub |
| A-07 | Sticky story section | Pin + horizontal/vertical scrub | ScrollTrigger pin |
| A-08 | CTA button | Magnetic hover (pointermove + gsap.to) | Core |
| A-09 | Page transition | Fade overlay (View Transitions API + GSAP fallback) | Core |
| A-10 | Image trail / custom cursor | Optional, desktop only | Observer |
| A-11 | Stat counter | Number tween on scroll | Core |
| A-12 | Text scroll color highlight | SplitText chars color scrub | SplitText + ScrollTrigger |

> **Catatan**: SplitText dan plugin GSAP lain semua FREE setelah Webflow akuisisi GSAP. Tidak perlu Club membership.

### 7.3 Timing Tokens
- Fast: 250ms — micro-interaction (button, link)
- Base: 600ms — section reveal
- Slow: 1000–1200ms — hero entrance
- Easing: `power3.out` (entrance), `power2.inOut` (transition), `expo.out` (dramatic)

---

## 8. SEO Requirements

### 8.1 Foundational
- Semantic HTML5 (`<header>`, `<main>`, `<article>`, `<nav>`, `<footer>`).
- Single `<h1>` per page, hierarchy `<h2>` → `<h3>` rapi.
- `lang="id"` (atau bahasa final) di `<html>`.
- Meta description per page (overridable via Yoast/Rank Math).
- Canonical URL di setiap page.
- Open Graph + Twitter Card meta lengkap.
- Favicon set lengkap (32, 192, 512, apple-touch).

### 8.2 Structured Data (JSON-LD)
- `Organization` (homepage)
- `WebSite` + `SearchAction` (homepage)
- `BreadcrumbList` (semua page non-home)
- `Article` (blog post)
- `CreativeWork` (case study) atau `Project` schema custom
- `Person` (author bio)

### 8.3 Sitemaps & Indexation
- XML sitemap dinamis lewat plugin SEO (Yoast / Rank Math / SEOPress) — split per post type.
- `robots.txt` tegas (disallow `/wp-admin/` kecuali admin-ajax).
- `noindex` di archive author / tag tipis (opsional, tergantung strategy).

### 8.4 Performance untuk SEO
- LCP element ditandai (preload hero image / preconnect font).
- CLS = 0 (reserve ratio untuk image/video).
- Inline critical CSS, defer non-critical.
- Image: WebP/AVIF, `loading="lazy"`, `decoding="async"`, `fetchpriority="high"` untuk hero.
- Font: `font-display: swap`, self-host atau preconnect Google Fonts.

### 8.5 Content SEO
- URL slug pendek, lowercase, hyphenated.
- Internal linking: blog → case study terkait, case study → service page.
- Reading time + meta info di blog → engagement signal.
- 404 custom page dengan link balik ke konten populer.
- Redirect 301 untuk URL yang berubah (catat di plugin redirect).

### 8.6 AI / Answer Engine Optimization
- FAQ schema di halaman service / about (jika ada Q&A).
- Konten blog ditulis dengan jawaban langsung di paragraf pembuka (paragraph-as-answer pattern).
- TOC otomatis di artikel panjang.

---

## 9. Accessibility (WCAG 2.2 AA target)

- Color contrast ≥ 4.5:1 (text) / 3:1 (UI).
- Focus state visible di semua interactive element.
- Skip-to-content link di top.
- Keyboard navigable seluruh menu, modal, slider, form.
- ARIA hanya bila perlu (semantik HTML diutamakan).
- Form: label eksplisit, error message terkait via `aria-describedby`.
- Animasi & autoplay video respect `prefers-reduced-motion`.
- Alt text wajib untuk media non-dekoratif.

---

## 10. Compliance & Security
- HTTPS (Let's Encrypt) di production.
- WP core + plugins auto-update minor.
- Disable XML-RPC, edit file dari dashboard, comment spam (Akismet).
- Login: 2FA (plugin), captcha di form.
- Backup harian (Updraft / host backup).
- Privacy policy + cookie consent banner (jika ada analytics).
- GDPR-friendly form (consent checkbox, retention policy).

---

## 11. Open Questions (perlu konfirmasi user)

> **Status update — 2026-05-30**: jawaban user untuk Q1 round sudah masuk dan ter-lock di bawah. Sisa pertanyaan masih open atau perlu klarifikasi ulang.

### 11.1 Decisions Locked

| # | Pertanyaan | Keputusan |
| --- | --- | --- |
| Q2 | Brand identity | **Sebagian terkunci**: primary palette (50–950) dan font (Plus Jakarta Sans) sudah final. Logo + neutral palette + tipografi display/secondary masih menunggu brand file lengkap. |
| Q4 | Bahasa launch | **Bahasa Indonesia saja**. Struktur i18n tetap disiapkan untuk multilingual fase berikutnya. |
| Scope | Roadmap | **Full scope** sesuai §12 (~7 minggu). Home + Work + Blog + About + Contact + animasi + SEO penuh. |
| Q9 | Editor case study | **Custom Gutenberg blocks** untuk maintainability + portability. ACF Flexible tidak dipakai. |
| Color anchor | Primary brand color | `#007BFF` (Tier 500) + 11-step shades (50→950). |
| Typography | Font family | Plus Jakarta Sans (self-host, weights 400/500/600/700/800). |

### 11.2 Need Clarification

- **Q7 — SEO plugin**: user mencentang Rank Math + Yoast bersamaan. Hanya satu yang dipilih. Default sementara: **Rank Math** (free tier kuat, schema lengkap). Konfirmasi user.
- **Q6 — Form plugin**: user mencentang Fluent Forms + CF7 + Gravity bersamaan. Hanya satu. Default sementara: **Fluent Forms**. Konfirmasi user.

### 11.3 Still Open (perlu jawaban sebelum/saat M1)

1. **Domain & hosting**: kastalabs.com sudah live? Hosting di mana? Ada production environment yang sudah jalan?
2. **Konten awal**: berapa case study siap publish saat launch? Berapa blog post pembuka?
3. **Layanan KastaLabs**: daftar pasti service yang ditawarkan (untuk Services section + structured data)?
4. **Analytics**: GA4, Plausible, Umami, atau none?
5. **Build tooling untuk theme**: Vite atau @wordpress/scripts (default WP toolchain)? **Default**: Vite (sudah didokumentasikan di Tech Doc).
6. **GSAP delivery**: bundle via npm (ESM) atau CDN? **Default**: npm bundle.
7. **Page transitions**: View Transitions API native, Barba.js, atau full-reload klasik? **Default**: View Transitions API + GSAP fallback.

---

## 12. Roadmap & Milestones

| Milestone | Deliverable | Estimasi |
| --- | --- | --- |
| M0 — Discovery | PRD ✅, Tech Doc ✅, brand finalisasi, content audit | 1 minggu |
| M1 — Foundation | Theme scaffold, build pipeline, design tokens, base components | 1 minggu |
| M2 — Templates | Home, Work index, Case study, Blog index, Single, About, Contact | 2 minggu |
| M3 — Motion & polish | Implementasi animasi GSAP per section, page transitions | 1 minggu |
| M4 — SEO + a11y + perf pass | Schema, meta, Lighthouse pass, axe-core pass | 1 minggu |
| M5 — Content load + QA | Import 4-6 case study, 3-5 blog post, cross-browser & device QA | 1 minggu |
| M6 — Launch | DNS, SSL, sitemap submission, monitoring | 2 hari |

Total estimasi: ~7 minggu (dengan asumsi konten dari sisi user siap di M5).

---

## 13. Risiko & Mitigasi

| Risiko | Dampak | Mitigasi |
| --- | --- | --- |
| Heavy animation = poor perf | LCP/INP rusak, Lighthouse turun | Lazy-load GSAP per route, gunakan `prefers-reduced-motion`, code-split |
| Konten case study belum siap | Launch tertunda | Mulai content collection di M0 paralel dengan dev |
| Plugin bloat (Yoast + form + cache + etc.) | Site lambat | Audit plugin, hindari builder berat (pakai theme custom + Gutenberg) |
| GSAP non-aligned dengan WP block editor preview | Editor terlihat broken | Animasi hanya jalan di frontend (`!is_admin()`) |
| Brand belum final saat M2 | Rework template | Token-based desain — ganti token tidak ganti markup |

---

## 14. Definition of Done

Theme dianggap **launch-ready** jika:
- ✅ Semua template di Section 4 berfungsi.
- ✅ Lighthouse Mobile Performance ≥ 85, SEO ≥ 95, A11y ≥ 95.
- ✅ axe-core lulus tanpa error level "serious"+.
- ✅ Cross-browser pass: Chrome, Safari, Firefox, Edge (2 versi terakhir).
- ✅ Cross-device pass: iOS Safari, Android Chrome.
- ✅ Form contact mengirim email + tersimpan di DB / external service.
- ✅ Sitemap di-submit ke GSC, semua canonical page indexable.
- ✅ Backup + monitoring nyala.
- ✅ Dokumentasi handover (README di theme + admin guide singkat).

---

## 15. Referensi
- Salient Signal demo: https://themenectar.com/salient/signal/
- Salient v18 announcement: https://themenectar.com/salient/introducing-salient-version-18/
- GSAP docs v3: https://gsap.com/docs/v3
- GSAP demos: https://demos.gsap.com/
- GSAP AI skills: https://github.com/greensock/gsap-skills
- Tailwind CSS: https://tailwindcss.com/
- WordPress Theme Handbook: https://developer.wordpress.org/themes/