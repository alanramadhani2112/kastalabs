# Kastalabs Project Restructure Plan

Status: Draft v1
Date: 2026-06-03
Latest implementation update: 2026-06-04
Source documents:
- `C:\Users\LENOVO\Downloads\KASTALABS_PRD_FINAL.md`
- `C:\Users\LENOVO\Downloads\Documents\Kastalabs Visual Direction.pdf`
- `C:\Users\LENOVO\Downloads\Documents\Kastalabs Website Copywriting.pdf`
- `C:\Users\LENOVO\Downloads\Documents\Kastalabs Technical Architecture.pdf`

## 1. New North Star

Kastalabs website is a company profile and digital branding platform for a creative technology company.

It should feel:
- intelligent
- premium
- calm
- structured
- breathable
- human-centered
- modern without becoming generic

Final experience target:

> A thoughtful digital company that understands systems, design, and communication deeply.

Primary user journey:

Attention -> Trust -> Capability -> Proof -> Personality -> Conversion

## 2. What Changes From Current Build

The current implementation is a strong WordPress theme foundation, but it was moving toward a dark-first portfolio/agency landing page with heavy GSAP-style presentation.

The new documents shift the project toward:

- company profile first, portfolio second
- light/breathable premium visual system, with dark navy used selectively
- CMS-editable structured content
- Services as a first-class content area
- Portfolio, Services, and Insights managed as CMS content
- backend/CMS logic moved out of the theme into a core plugin
- subtle motion instead of animation-heavy presentation

## 3. Source Of Truth Priority

Use this priority order when documents conflict:

1. `KASTALABS_PRD_FINAL.md`
2. `Kastalabs Technical Architecture.pdf`
3. `Kastalabs Website Copywriting.pdf`
4. `Kastalabs Visual Direction.pdf`
5. Existing `docs/PRD.md`, `docs/TECH-DOC.md`, and previous implementation notes

The older M1 docs remain useful as build-history, but they are no longer the product direction.

## 4. Naming Decisions

Brand display:
- Use `Kastalabs` in visible copy unless the brand team confirms `KastaLabs`.

Code prefix:
- Use `kastalabs_` for new PHP functions.
- Existing `kasta_` helpers may remain temporarily, then migrate gradually.

Theme:
- Keep current folder `wp-content/themes/kastalabs`.
- Update metadata later to remove dark-first/GSAP wording.

Plugin:
- Add `wp-content/plugins/kastalabs-core`.

Routes:
- Final navigation uses `Portfolio`, not `Work`.
- Recommended final route: `/portfolio/`.
- Existing `/work/` content should be migrated or redirected later.

## 5. Target Information Architecture

Main navigation:
- Home
- About
- Services
- Portfolio
- Insights
- Contact

Pages:
- `/`
- `/about/`
- `/services/`
- `/portfolio/`
- `/portfolio/{slug}/`
- `/insights/`
- `/insights/{slug}/`
- `/contact/`

Future:
- `/careers/`
- multilingual
- client portal
- project tracker
- dedicated service landing pages

## 6. Target Content Model

### 6.1 Portfolio

Post type:
- `portfolio`

Fields:
- project title
- client
- category
- challenge
- solution
- gallery
- technologies
- results
- featured flag
- project URL

Taxonomies:
- `portfolio_category`
- `portfolio_tag`

Templates:
- `archive-portfolio.php`
- `single-portfolio.php`

Migration:
- Existing `work` posts should be migrated to `portfolio`.
- Existing `work_category` and `work_tag` should be migrated to portfolio taxonomies.
- `/work/*` should redirect to `/portfolio/*` after migration.

### 6.2 Services

Post type:
- `service`

Fields:
- title
- overview
- benefits
- workflow
- expected impact
- CTA label
- CTA URL
- icon or index

Templates:
- `page-services.php` for service overview
- optional future `single-service.php`

Core services:
- Branding Design
- UI/UX Design
- Web Development
- Custom Software Development

### 6.3 Insights

Post type:
- `insight`

Fields:
- title
- featured image
- category
- author
- SEO metadata

Templates:
- `archive-insight.php`
- `single-insight.php`

Note:
- WordPress built-in posts can be left unused or redirected into the Insights model.

### 6.4 Theme Options

Managed through ACF options or fallback Customizer fields:
- logo
- social links
- email
- WhatsApp
- CTA text
- CTA URL
- company location
- footer copy

### 6.5 Homepage Sections

The homepage layout can stay hardcoded, but content should become dynamic:
- hero
- trust section
- about preview
- services overview
- featured portfolio
- working process
- core values
- CTA

## 7. Target Visual System

Core palette:
- Primary Blue: `#007BFF`
- Soft Blue: `#E5F2FF`
- White: `#FFFFFF`
- Dark Navy: `#000C1A`

Current theme state:
- Dark-first background `#0A0A0B`
- Surface `#141416`
- muted gray
- large glow/grain/cinematic treatment

Required reset:
- Move to light-first, breathable company profile visual system.
- Use Dark Navy for typography and selected premium sections.
- Use Primary Blue only for CTA, active state, focus, highlights.
- Use Soft Blue for calm section separation and hover surfaces.
- Reduce heavy gradients, glow layers, custom cursor, and aggressive parallax.

Typography:
- Use Plus Jakarta Sans across the website.
- Self-host fonts in production.
- Build clear heading/body scale and spacing rhythm. Done 2026-06-04; see `docs/TYPOGRAPHY-SYSTEM.md`.

Components:
- buttons: precise, modern, not overly rounded
- cards: lightweight, organized, subtle
- navigation: simple, non-crowded, clear active states
- motion: subtle, fast, meaningful

## 8. Target Technical Architecture

### 8.1 Theme Responsibility

Theme handles:
- UI rendering
- layout
- templates
- styling
- frontend interactions
- asset loading

Theme must not own long-term:
- CPT registration
- taxonomies
- reusable backend logic
- API logic
- admin enhancements
- theme settings

### 8.2 Core Plugin Responsibility

`kastalabs-core` handles:
- CPT registration
- taxonomies
- ACF field groups
- theme options
- contact settings
- reusable helpers
- admin enhancements
- future integrations

Recommended plugin structure:

```text
wp-content/plugins/kastalabs-core/
  kastalabs-core.php
  includes/
  post-types/
  taxonomies/
  acf/
  admin/
  helpers/
```

### 8.3 Frontend Stack

Keep:
- WordPress
- custom theme
- TailwindCSS
- Vite
- PHP 8+

Add:
- Alpine.js for navigation, accordion, tabs, dropdown, modal states

Reduce:
- GSAP to selective narrative motion only
- Lenis/custom cursor unless they clearly improve the experience

## 9. Development Roadmap

### Phase 0 - Stabilize And Freeze Direction

Goal:
- Stop expanding the old direction.
- Make the new documents the source of truth.

Tasks:
- Create this restructure plan.
- Update old docs to point to this plan.
- Initialize Git if not already done.
- Commit current state before major refactor.
- Decide visible brand casing: `Kastalabs` vs `KastaLabs`.
- Decide final portfolio route: `/portfolio/` vs `/work/`.

Definition of done:
- Team agrees on source of truth and routing.
- No more new work is based on old dark-first portfolio direction.

### Phase 1 - Architecture Reset

Goal:
- Move CMS/business logic from theme into `kastalabs-core`.

Tasks:
- Scaffold `wp-content/plugins/kastalabs-core`. Done 2026-06-04.
- Move CPT `work` logic out of theme. Done 2026-06-04; legacy `work` is temporarily registered by the core plugin.
- Register new CPTs: `portfolio`, `service`, `insight`. Done 2026-06-04.
- Register related taxonomies. Done 2026-06-04.
- Add migration helpers for existing `work` posts. Done 2026-06-04; first local migration copied 1 dummy Work item to Portfolio.
- Add ACF field groups if ACF Pro exists. Done 2026-06-04; local ACF groups are conditionally registered when ACF is active.
- Add safe fallbacks if ACF is not active. Done 2026-06-04; REST-exposed post meta and Custom Fields support remain available without ACF.
- Seed initial Services content. Done 2026-06-04; four core services were seeded locally when Service content was empty.

Definition of done:
- Theme can be changed without losing content models.
- Admin can manage Portfolio, Services, and Insights.

### Phase 2 - Design System Reset

Goal:
- Align visual foundation with the Visual Direction document.

Tasks:
- Update Tailwind tokens to new palette. Started 2026-06-04; base CSS now uses `#007BFF`, `#E5F2FF`, `#FFFFFF`, and `#000C1A`.
- Convert base layout from dark-first to light-first. Started 2026-06-04; global body/editor surfaces now default to a light visual system.
- Rebuild component classes for buttons, cards, forms, nav, sections. Started 2026-06-04; buttons, hairlines, prose, filters, forms, and header received first light-system pass.
- Remove or tone down noisy visual effects. Started 2026-06-04; custom cursor, hero glow/orbs, pinned hero, 3D service card tilt, and heavy hero motion were removed or toned down.
- Align homepage and primary page surfaces. Continued 2026-06-04; Home sections, About, Services, Contact, Portfolio detail, Insight detail, footer, and 404 received a light-system pass.
- Move homepage Featured Work toward final content model. Continued 2026-06-04; homepage now reads Portfolio items instead of legacy Work.
- Implement responsive typography tokens. Done 2026-06-04; semantic classes now cover display, heading, body, label, and button text using Plus Jakarta Sans.
- Self-host fonts.
- Keep motion subtle.

Definition of done:
- Homepage immediately feels premium, calm, structured, and breathable.
- CSS uses semantic component classes and consistent spacing.

### Phase 3 - Content And CMS Wiring

Goal:
- Make main site content editable without code changes.

Tasks:
- Implement theme options. Started 2026-06-04; `kastalabs-core` now provides fallback WordPress options through Settings > Kastalabs Settings.
- Wire homepage copy to dynamic fields. Started 2026-06-04; homepage hero and global CTA now read editable options.
- Wire services section to Service CPT.
- Wire featured portfolio to Portfolio CPT.
- Wire contact information to theme options. Started 2026-06-04; contact email, WhatsApp URL, location, social links, and footer copy now read editable options.
- Replace placeholder testimonials or hide testimonials until real content exists. Started 2026-06-04; placeholder testimonial section is hidden from the homepage.

Definition of done:
- Admin can update homepage, services, portfolio, insights, CTA, and contact data.

### Phase 4 - Page Buildout

Goal:
- Complete required pages from PRD.

Tasks:
- Home. In progress 2026-06-04; homepage follows final IA, Portfolio CPT, editable hero/CTA, and light visual system.
- About. In progress 2026-06-04; page template exists with final copy direction and light visual system.
- Services. In progress 2026-06-04; page template reads Service CPT and seeded core services.
- Portfolio archive. In progress 2026-06-04; archive template exists for `/portfolio/`.
- Portfolio detail. In progress 2026-06-04; single template exists for `/portfolio/{slug}`.
- Insights archive. In progress 2026-06-04; archive template exists for `/insights/`.
- Insight detail. In progress 2026-06-04; single template exists for `/insights/{slug}`.
- Contact. In progress 2026-06-04; page template exists and reads editable contact options.
- Generic fallback templates. Started 2026-06-04; `page.php`, `single.php`, `index.php`, and `search.php` are aligned with the light visual system.

Definition of done:
- All primary nav pages exist, render correct templates, and use final copy direction.

### Phase 5 - SEO, Security, Performance

Goal:
- Prepare the site for production quality.

Tasks:
- Install/configure one SEO plugin: Rank Math or Yoast.
- Add schema for Organization, Portfolio/CreativeWork, Articles. Started 2026-06-04; theme now outputs Organization, WebSite, CreativeWork, and Article JSON-LD baseline.
- Validate contact form nonce/sanitization. Started 2026-06-04; contact form uses nonce, honeypot, sanitization, and lightweight IP throttling.
- Add analytics placeholder/integration. Started 2026-06-04; Google Analytics Measurement ID can be set from Kastalabs Settings and only loads when configured.
- Optimize image sizes and WebP workflow.
- Run Lighthouse checks.
- Run accessibility checks.
- Add production QA checklist. Started 2026-06-04; see `docs/PRODUCTION-QA-CHECKLIST.md`.

Definition of done:
- Lighthouse target: 90+ where realistic.
- Contact form is secure.
- SEO metadata can be managed.

### Phase 6 - Content Load And QA

Goal:
- Replace placeholders with real content.

Tasks:
- Add real services.
- Add 3-6 real portfolio projects.
- Add initial insights/articles.
- Add real testimonials if available.
- Add social/contact information.
- Test responsive layouts.
- Cross-browser QA.

Definition of done:
- Site can be reviewed as a realistic company profile, not a scaffold.

## 10. Immediate Next Sprint

Recommended next sprint:

1. Initialize Git and save current state.
2. Scaffold `kastalabs-core`.
3. Move CPT/taxonomy/meta/contact logic into plugin.
4. Register `service`, `portfolio`, and `insight`.
5. Add `/services/` page template and make nav match PRD.
6. Start visual reset from dark-first to breathable light-first.

Completed on 2026-06-04:
- `kastalabs-core` plugin scaffolded and activated locally.
- New CMS post types available: Portfolio, Services, Insights.
- Legacy Work retained temporarily to avoid breaking `/work/`.
- New templates added: `/services/`, `/portfolio/`, `/portfolio/{slug}`, `/insights/`, `/insights/{slug}`.
- Header fallback navigation now follows PRD IA.
- Homepage Services section can read from Service CPT with fallback content.
- Local ACF field groups were added for Portfolio, Services, and Insight SEO, with fallback registered post meta when ACF is not active.
- Default Service content was seeded for Branding Design, UI/UX Design, Web Development, and Custom Software Development.

Do not continue polishing the current dark landing page until architecture and direction are aligned.

## 11. Key Risks

### ACF Pro availability

Docs assume ACF Pro. If it is unavailable, build fallback post meta/options first, then add ACF when ready.

### Existing `work` content

Existing dummy content uses `work`. Migrating too early can break routes. Handle migration in a controlled step.

### Visual direction drift

The Cassis reference is useful for flow and premium SaaS clarity, but Kastalabs should not become a SaaS template clone.

### Hardcoded content

Current templates contain a lot of hardcoded copy. That is acceptable for early layout, but not for final CMS requirements.

### Motion overload

Existing GSAP components may conflict with "calm, subtle, meaningful" motion. Use motion only where it supports clarity.

## 12. Open Decisions

Need confirmation:
- Display brand: `Kastalabs` or `KastaLabs`?
- Final portfolio URL: `/portfolio/` or keep `/work/`?
- ACF Pro is available or not?
- SEO plugin: Rank Math or Yoast?
- Contact channel: email only, WhatsApp, or both?
- Real services wording approved?
- Should Insights use CPT `insight` or built-in WordPress posts renamed as Insights?
