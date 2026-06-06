# Kastalabs Frontend Planning

Status: Draft v1
Date: 2026-06-06
Latest development update: 2026-06-06

Purpose:
- Lock the frontend direction before more theme implementation.
- Sequence the work from sitemap to copywriting, wireframe, hi-fi, then WordPress frontend.
- Prevent visual experiments from drifting away from the actual landing page strategy.
- Follow `docs/DEVELOPMENT-WORKFLOW.md`: every meaningful frontend change must update documentation in the same work cycle.

Reference direction:
- Visual tone: light, calm, structured, enterprise-clean, with blue CTA emphasis.
- Visual reference: Zoom-like clarity and conversion flow, adapted for Kastalabs as a creative technology studio.
- Brand voice: precise, confident, warm, digital-native, Indonesian-first with selective English industry terms.

## 1. Decision Rules

Do not continue frontend implementation until the page being built has:
- approved sitemap position
- page objective
- final section order
- working copy
- low-fidelity wireframe notes
- hi-fi direction notes

Use `Portfolio` as the final public label.
Keep `/work/` only as a legacy route until redirect/migration is finalized.

Use `Kastalabs` in visible copy unless the brand casing decision changes.

## 2. Final Sitemap

### 2.1 Primary Navigation

```text
Home
About
Services
Portfolio
Insights
Contact
```

### 2.2 Public Routes

```text
/                         Home landing page
/about/                   Company profile
/services/                Services overview
/services/{slug}/         Optional service detail, future-ready
/portfolio/               Portfolio archive
/portfolio/{slug}/        Portfolio case study
/insights/                Insights archive
/insights/{slug}/         Insight article
/contact/                 Contact and inquiry form
```

### 2.3 Legacy Routes

```text
/work/                    Temporary legacy portfolio archive
/work/{slug}/             Temporary legacy portfolio detail
```

Migration rule:
- Keep `/work/` alive while legacy content exists.
- Final implementation should redirect `/work/` to `/portfolio/` after content migration is complete.
- Do not expose both `Work` and `Portfolio` in navigation.
- Current SEO rule: `/portfolio/` is the canonical final archive. `/work/` remains reachable for legacy compatibility and points its archive canonical to `/portfolio/` until redirect approval.

### 2.4 Footer Navigation

Footer groups should support wayfinding without competing with the main nav.

```text
Sitemap
- Home
- About
- Services
- Portfolio
- Insights
- Contact

Services
- Branding Design
- UI/UX Design
- Web Development
- Custom Software

Connect
- Email
- WhatsApp
- Instagram or LinkedIn
```

Footer group labels should not be page-level `h2` headings in the final markup.

## 3. Page Objectives

| Page | Primary Job | Conversion Role |
| --- | --- | --- |
| Home | Explain what Kastalabs does and move visitors toward trust. | Send users to portfolio or contact. |
| About | Show posture, values, and why the studio is credible. | Build confidence before inquiry. |
| Services | Clarify what can be hired and what each service includes. | Help users choose or ask for direction. |
| Service Detail | Explain one service in depth. | Convert users with service-specific CTA. |
| Portfolio Archive | Let users scan proof of work. | Move users into case studies or contact. |
| Portfolio Detail | Show context, thinking, solution, and results. | Prove capability for similar projects. |
| Insights Archive | Show thinking and point of view. | Build authority and return visits. |
| Insight Detail | Deliver useful article content. | Move readers to contact or related insight. |
| Contact | Capture qualified project inquiries. | Create backend Inquiry records. |

## 4. Content Model By Page

### 4.1 Home

Content source:
- Theme options for hero, homepage service intro, portfolio intro, CTA, contact details.
- Service CPT for service cards.
- Portfolio CPT for selected projects.
- Insight CPT optional for future featured insight section.

Required sections:
1. Header
2. Hero
3. Capability marquee or trust strip
4. Services preview
5. Positioning statement
6. Selected portfolio
7. About teaser
8. Process
9. FAQ
10. Final CTA
11. Footer

### 4.2 About

Required sections:
1. Page hero
2. Studio posture
3. Values
4. Differentiators
5. Optional client logos
6. CTA

### 4.3 Services

Required sections:
1. Page hero
2. Service cards
3. Process summary
4. Service comparison or guidance
5. CTA

### 4.4 Portfolio Archive

Required sections:
1. Page hero
2. Category filters
3. Portfolio grid
4. Empty state when no projects exist
5. CTA

### 4.5 Portfolio Detail

Required sections:
1. Case study hero
2. Project metadata
3. Challenge
4. Approach
5. Solution
6. Results
7. Gallery or visual proof
8. Related or next project
9. CTA

### 4.6 Insights Archive

Required sections:
1. Page hero
2. Article grid
3. Category or topic filter, optional
4. Empty state
5. CTA

### 4.7 Insight Detail

Required sections:
1. Article hero
2. Article body
3. Author or studio note
4. Related insights
5. CTA

### 4.8 Contact

Required sections:
1. Page hero
2. Contact promise
3. Inquiry form
4. Direct contact channels
5. FAQ or expectation notes

## 5. Copywriting Draft

This draft is content-first. Final design should adapt to this hierarchy, not the other way around.

### 5.1 Global Navigation

Primary CTA:
- Lihat portfolio

Secondary recurring CTA:
- Ceritakan proyek Anda

Alternative final CTA:
- Mulai percakapan

### 5.2 Home

Hero eyebrow:
- Studio digital strategis

Hero headline:
- Brand yang bergerak lebih tajam, dimulai dari sini.

Hero body:
- Kami membantu bisnis menyusun strategi, identitas visual, dan sistem digital yang bukan hanya terlihat baik, tapi bekerja secara nyata.

Primary CTA:
- Lihat portfolio

Secondary CTA:
- Ceritakan proyek Anda

Hero support chips:
- Brand strategy
- Visual design
- Web systems
- Digital products

Hero metrics:
- 4 Layanan inti
- 50+ Proyek selesai
- 3-6 Minggu peluncuran

Services eyebrow:
- Yang kami kerjakan

Services heading:
- Layanan digital yang terhubung dari strategi sampai eksekusi.

Services body:
- Pilih titik mulai yang paling relevan. Setiap layanan bisa berdiri sendiri atau disusun menjadi satu sistem digital yang utuh.

Service card copy:
- Branding Design: Membangun identitas visual yang memperkuat positioning dan komunikasi brand secara konsisten.
- UI/UX Design: Merancang pengalaman digital yang intuitif, nyaman digunakan, dan sesuai tujuan bisnis.
- Web Development: Mengembangkan website modern yang cepat, scalable, mudah dikelola, dan siap mendukung SEO.
- Custom Software Development: Membangun sistem digital custom yang membantu operasional berjalan lebih efisien dan terstruktur.

Statement eyebrow:
- Yang kami percaya

Statement heading:
- Kami memilih kerja yang dekat, teliti, dan cukup berani untuk meninggalkan kesan.

Statement body:
- Desain yang baik bukan soal mengikuti tren. Ia lahir dari pemahaman masalah, keputusan yang strategis, dan eksekusi yang rapi.

Portfolio eyebrow:
- Portfolio pilihan

Portfolio heading:
- Project yang kami bangun dengan strategi dan niat.

Portfolio body:
- Beberapa contoh bagaimana strategi, visual, dan teknologi disusun menjadi pengalaman digital yang lebih mudah dipercaya.

About eyebrow:
- Siapa kami

About heading:
- Studio kecil yang bekerja seperti tim besar, fokus, disiplin, dan tidak berisik.

About body:
- Dengan tim yang ramping, komunikasi tetap langsung dan detail lebih mudah dijaga. Tidak ada perantara yang membuat proses kabur.

Process eyebrow:
- Bagaimana kami bekerja

Process heading:
- Proses yang terstruktur, bukan formula yang kaku.

Process steps:
- Listen & Learn: Memahami bisnis, audiens, dan masalah sebelum satu pixel pun dibuat.
- Strategize: Menyusun positioning, arsitektur konten, dan keputusan desain yang punya alasan.
- Design & Build: Mendesain dan mengembangkan dengan review berkala agar tidak ada kejutan di akhir.
- Launch & Grow: Merapikan rilis, mengecek detail, lalu menyiapkan iterasi berikutnya.

FAQ heading:
- Hal yang sering ditanyakan.

FAQ:
- Berapa lama pengerjaan satu project? Website company profile biasanya 3-6 minggu. Branding identity 4-8 minggu. Software custom bergantung cakupan.
- Apakah bisa remote? Bisa. Proses bisa berjalan lewat Figma, Notion, chat, meeting terjadwal, dan update progres.
- Apakah bisa revisi? Bisa. Sesi revisi disepakati di awal agar feedback tetap terstruktur.
- Apakah ada dukungan setelah rilis? Ada masa dukungan pasca-rilis untuk bug fixing dan penyesuaian minor.

Closing CTA heading:
- Mulai dengan percakapan.

Closing CTA body:
- Ceritakan proyek Anda. Kami dengarkan konteksnya, lalu bantu petakan langkah yang paling masuk akal.

Closing CTA:
- Mulai percakapan

### 5.3 About

Hero eyebrow:
- About Kastalabs

Hero heading:
- Studio kecil untuk brand yang ingin bergerak lebih tajam.

Hero support:
- Strategy first
- Visual systems
- Built to ship

Posture eyebrow:
- Posisi kami

Posture heading:
- Kami tidak mencoba menjadi semua untuk semua orang.

Posture body:
- Kastalabs dibangun untuk kerja yang fokus. Kami memilih tetap ramping supaya bisa dekat dengan konteks klien, menjaga kualitas, dan bergerak tanpa birokrasi yang tidak perlu.

Values heading:
- Tiga hal yang kami jaga di setiap project.

Values:
- Strategic first: Mulai dari posisi, audiens, dan keputusan sebelum bentuk visual dipilih.
- Craft that holds: Detail tipografi, layout, gerak, dan sistem komponen dijaga agar konsisten.
- Built to ship: Desain dipikirkan sampai implementasi, performa, SEO, dan pengelolaan konten.

CTA:
- Ceritakan proyek Anda

### 5.4 Services

Hero eyebrow:
- Services

Hero heading:
- Layanan digital yang dirancang dengan kejelasan dan tujuan.

Hero body:
- Dari strategi brand sampai software custom, setiap layanan dibangun dengan pendekatan yang teliti, strategis, dan siap dipakai.

Service card inclusions:
- Branding Design: Logo & identity system, brand guidelines, visual language, collateral design.
- UI/UX Design: User flow, wireframe, prototype, design system, interaction design.
- Web Development: Custom WordPress, company profile, landing page, CMS setup, performance basics.
- Custom Software Development: Web apps, internal tools, API integration, automation.

Guidance section heading:
- Tidak yakin layanan mana yang Anda butuhkan?

Guidance body:
- Ceritakan tujuan bisnisnya. Kami bantu arahkan apakah Anda perlu branding, website, product experience, atau sistem custom.

CTA:
- Mulai percakapan

### 5.5 Portfolio Archive

Hero eyebrow:
- Portfolio

Hero heading:
- Project pilihan yang kami bangun dengan strategi dan niat.

Hero body:
- Setiap project punya konteks dan tantangan berbeda. Karena itu pendekatan kami selalu dimulai dari memahami, bukan langsung mendesain.

Empty state:
- Portfolio sedang disiapkan.
- Project pilihan akan muncul di sini setelah konten final dimuat.

CTA:
- Ceritakan proyek Anda

### 5.6 Portfolio Detail

Metadata labels:
- Client
- Scope
- Year
- Role

Section labels:
- Konteks
- Tantangan
- Pendekatan
- Solusi
- Hasil

CTA heading:
- Ingin membangun project dengan pendekatan seperti ini?

CTA:
- Mulai percakapan

### 5.7 Insights

Archive hero eyebrow:
- Insights

Archive hero heading:
- Pemikiran, insight, dan sudut pandang digital.

Archive hero body:
- Eksplorasi tentang desain, teknologi, strategi digital, dan proses kreatif di balik Kastalabs.

Article CTA:
- Baca insight

Empty state:
- Insight sedang disiapkan.
- Artikel pertama akan muncul setelah editorial awal selesai.

### 5.8 Contact

Hero eyebrow:
- Contact

Hero heading:
- Ceritakan proyek yang ingin Anda bangun.

Hero body:
- Mulai dari konteks singkat. Kami akan membaca kebutuhan Anda dan membalas dengan arah awal yang jujur.

Form labels:
- Nama
- Email
- Perusahaan
- Tipe project
- Estimasi budget
- Pesan

Submit CTA:
- Kirim inquiry

Success message:
- Inquiry berhasil dikirim. Kami akan menghubungi Anda secepatnya.

Error message:
- Inquiry belum bisa dikirim. Periksa kembali data Anda atau hubungi kami langsung lewat email.

Expectation notes:
- Kami biasanya membalas dalam 1-2 hari kerja.
- Jika kebutuhan belum jelas, tulis saja tujuan besarnya.

## 6. Wireframe Textual

### 6.1 Home Wireframe

```text
[Header]
Logo left
Primary nav center/right
CTA right

[Hero]
Left: eyebrow, H1, body, primary CTA, secondary CTA, chips, metrics
Right: product/workspace preview visual
Background: soft grid and blue glow

[Marquee]
Capabilities strip

[Services Preview]
Centered heading
Three category chips
Four service cards
CTA to Services

[Statement]
Two-column: belief statement + three proof cards

[Selected Portfolio]
Centered intro
Portfolio grid
CTA to Portfolio

[About Teaser]
Editorial split: text + compact trust/stat panel

[Process]
Four steps in scan-friendly cards or timeline

[FAQ]
Accordion list

[Closing CTA]
Dark navy band, one clear CTA

[Footer]
Brand summary, newsletter optional, sitemap links, service links, contact links
```

### 6.2 About Wireframe

```text
[Page Hero]
Eyebrow, H1, support tags

[Posture]
Large text block, supporting short paragraph

[Values]
Three cards

[Differentiators]
List of direct-working benefits

[Optional Logos]
Client logo grid if real logos exist

[CTA]
Contact CTA
```

### 6.3 Services Wireframe

```text
[Page Hero]
Eyebrow, H1, body, support tags

[Service Grid]
Four cards, each with inclusions and CTA

[Process]
Reusable four-step process

[Guidance]
Short section for unsure visitors

[CTA]
Contact CTA
```

### 6.4 Portfolio Archive Wireframe

```text
[Page Hero]
Eyebrow, H1, body

[Filters]
Category chips

[Grid]
Portfolio cards: image, category, title, summary/meta

[Empty State]
Only shown when no posts exist

[CTA]
Contact CTA
```

### 6.5 Contact Wireframe

```text
[Page Hero]
Eyebrow, H1, body

[Main Contact Area]
Left: form
Right: response expectations, email, WhatsApp, location

[FAQ/Notes]
Short practical notes
```

## 7. Hi-Fi Direction

### 7.1 Overall Visual Direction

Use a clean enterprise landing page language:
- white and soft blue surfaces
- dark navy text
- strong blue CTA
- generous spacing
- precise cards
- subtle borders
- calm motion

Avoid:
- dark-first agency look
- oversized decorative gradients
- hidden content controlled by scroll animations
- too many nested cards
- generic SaaS stock visuals

### 7.2 Header

Direction:
- Sticky white header with subtle border.
- Logo left.
- Nav labels centered or right balanced.
- CTA button prominent.
- Dropdown allowed for Services and Portfolio only if needed.

Implementation note:
- Header should not introduce mega-menu until sitemap and service content justify it.

### 7.3 Hero

Direction:
- First viewport should communicate brand, value, and action within 5 seconds.
- Use a light grid background.
- Keep hero text visible without relying on JS.
- Product/workspace visual should support the story, not dominate it.

Acceptance:
- H1, body, and CTAs visible on desktop and mobile without waiting for animation.
- On mobile, CTAs stack cleanly and visual appears after text/metrics.

### 7.4 Services

Direction:
- Cards should be useful, not decorative.
- Each card needs a title, summary, inclusions, and optional CTA.
- The section should help users understand what to ask for.

### 7.5 Portfolio

Direction:
- Portfolio cards should prioritize real project evidence.
- Use thumbnails when available.
- Avoid placeholder-heavy visuals in final.

### 7.6 Motion

Use motion as progressive enhancement:
- fade/slide reveal only when content remains visible if JS fails
- no scramble effect on essential headings or eyebrow copy
- no animation that leaves content invisible in screenshots or browser QA

## 8. Frontend Implementation Checklist

Documentation rule:
- Before finishing a frontend change, update this document or `docs/WORKLOG.md`.
- If the change affects launch QA, update `docs/PRODUCTION-QA-CHECKLIST.md`.

### 8.1 Before Editing Theme

- Confirm the page route and sitemap position.
- Confirm copy from this document.
- Confirm wireframe section order.
- Confirm which content is dynamic and which is static.

### 8.2 Homepage Implementation

- Simplify hero animation so content is visible by default.
- Remove or disable scramble on hero eyebrow and primary section headings.
- Ensure mobile hero spacing does not push CTA too far down.
- Reduce excess vertical blank space caused by reveal states.
- Keep `Portfolio` as the visible label.
- Do not expose `Work` in primary nav.

### 8.3 Template Cleanup

- Restore or replace `archive-portfolio.php` and `single-portfolio.php` intentionally.
- Decide if `/work/` templates become redirect-only legacy templates.
- Avoid adding new component folders unless they are actually used.
- Remove local screenshots and tool artifacts from commit scope.

### 8.4 QA Checklist

- Desktop screenshot: 1440px.
- Mobile screenshot: 390px.
- Route smoke test:
  - `/`
  - `/about/`
  - `/services/`
  - `/portfolio/`
  - `/insights/`
  - `/contact/`
- Heading hierarchy check:
  - One `h1` per page.
  - Section headings as `h2`.
  - Footer group labels should not be `h2`.
- Animation check:
  - No essential copy remains hidden after 3 seconds.
  - Content remains readable with JS disabled or failed.

## 9. Immediate Next Actions

1. Treat current frontend changes as draft until reviewed against this document.
2. Clean or isolate local artifacts:
   - `.playwright-mcp/`
   - `.sisyphus/`
   - `homepage.png`
   - `services-section.png`
   - `zoom-homepage.png`
3. Fix homepage hero stability first.
4. Restore portfolio template strategy.
5. Then implement the sitemap-led page sequence:
   - Home
   - Services
   - Portfolio archive/detail
   - About
   - Contact
   - Insights

Progress on 2026-06-06:
- Homepage hero markup was cleaned so the workspace preview is not duplicated.
- Hero and portfolio CTAs now normalize legacy `/work/` values to `/portfolio/`.
- Homepage selected portfolio now reads the `portfolio` CPT instead of legacy `work`.
- `archive-portfolio.php` and `single-portfolio.php` were restored as intentional final-route templates.
- Scroll reveal motion was adjusted so essential content remains visible instead of starting at `opacity: 0`.
- Portfolio archive SEO now has final-route metadata, legacy `/work/` archive has temporary migration metadata, and `/work/` archive canonical points to `/portfolio/`.
- 404 portfolio CTA now points to the final `/portfolio/` route.

## 10. Open Decisions

- Confirm final visible brand casing: `Kastalabs` or `KastaLabs`.
- Confirm whether `/work/` should redirect immediately or only after migration.
- Confirm whether service detail pages are needed for launch.
- Confirm real portfolio projects and images.
- Confirm whether testimonials/client logos exist or should be hidden.
- Confirm final contact channels: email, WhatsApp, or both.
