# Kastalabs Worklog

Purpose:
- Record each meaningful development cycle.
- Keep implementation, verification, and documentation traceable.

## 2026-06-11 — Frontend Polish & M3 Motion

Scope:
- Homepage: wire semua section ke site options, client-logos fallback trust strip, testimonials enabled, spacing normalized
- About: posture copy update matching FRONTEND-PLANNING
- Services page: inclusion lists, guidance section, process summary
- Portfolio single: structured case study (Konteks → Tantangan → Pendekatan → Solusi → Hasil) with sidebar navigation
- Portfolio meta: added `context`, `approach` fields; service `inclusions` field
- ACF: synced field groups with new meta keys
- Insights: archive stagger reveal + empty state CTA, single reading time fix + CTA
- Blog index: hero layout + empty state CTA
- Contact: copy polish matching FRONTEND-PLANNING
- 404: search form + alt nav + improved layout
- M3 Motion: GSAP code-split (dynamic import per page), hero word reveal, cover parallax, View Transitions API crossfade, reduced-motion safe
- M4 Perf: font preload with hash-aware Vite manifest scanning, theme-color meta, `size-adjust` on @font-face
- Seed data: Service inclusions, Portfolio context/approach, Indonesian CTA labels
- All spacing normalized: py-24 md:py-32 for sections, py-20 md:py-28 for CTA

Files (30+ changed):
- `wp-content/themes/kastalabs/front-page.php` — testimonials section call
- `wp-content/themes/kastalabs/header.php` — font preload, theme-color, apple-touch-icon
- `wp-content/themes/kastalabs/page-about.php` — posture copy
- `wp-content/themes/kastalabs/page-services.php` — inclusions + guidance
- `wp-content/themes/kastalabs/page-contact.php` — copy polish
- `wp-content/themes/kastalabs/single-portfolio.php` — case study structure
- `wp-content/themes/kastalabs/single-service.php` — sidebar inclusions
- `wp-content/themes/kastalabs/single-insight.php` — CTA + reading time
- `wp-content/themes/kastalabs/archive-insight.php` — empty state CTA
- `wp-content/themes/kastalabs/home.php` — blog index layout
- `wp-content/themes/kastalabs/404.php` — search + alt nav
- `wp-content/themes/kastalabs/src/js/app.js` — code-split architecture
- `wp-content/themes/kastalabs/src/js/pages/home.js` — hero word reveal
- `wp-content/themes/kastalabs/src/js/pages/portfolio-single.js` — cover parallax + section stagger
- `wp-content/themes/kastalabs/src/js/components/page-transition.js` — View Transitions API
- `wp-content/themes/kastalabs/src/css/app.css` — font size-adjust, view-transition CSS, trust-strip, testimonial-card
- `wp-content/themes/kastalabs/template-parts/sections/*` — 10 section files updated
- `wp-content/themes/kastalabs/template-parts/cards/testimonial-card.php`
- `wp-content/plugins/kastalabs-core/includes/meta.php` — context, approach, inclusions
- `wp-content/plugins/kastalabs-core/acf/field-groups.php` — field sync
- `wp-content/plugins/kastalabs-core/admin/seed.php` — inclusions + context/approach

Verification:
- PHP lint: tidak bisa dijalankan otomatis — perlu `php -l` manual untuk semua file PHP yang berubah
- Build: perlu `npm run build` dari `wp-content/themes/kastalabs/`
- Route smoke test: `/`, `/about/`, `/services/`, `/portfolio/`, `/portfolio/{slug}/`, `/insights/`, `/insights/{slug}/`, `/contact/`, `/404`, `/blog/`
- Lighthouse target: ≥90 desktop, ≥85 mobile
- axe-core: zero serious/critical violations
- Mobile 390px: semua section tidak overflow

Status:
- Completed in this cycle.

---

## 2026-06-07 - Legacy Work Redirect Control

Scope:
- Added a backend setting for legacy Work redirects in Settings > Kastalabs Settings.
- Kept the redirect setting disabled by default.
- Added guarded `/work/` archive redirect to `/portfolio/` only when the setting is enabled and migration status has zero pending legacy Work items.
- Added guarded single Work redirect to the migrated Portfolio URL only when a matching migrated Portfolio record exists.
- Added a dedicated legacy route handler in `kastalabs-core`.

Why:
- `/portfolio/` is the final route, but `/work/` should not be redirected automatically before admin approval.
- The backend needs a controlled switch so redirect can be enabled after migration QA is complete.

Files:
- `wp-content/plugins/kastalabs-core/includes/options.php`
- `wp-content/plugins/kastalabs-core/admin/settings.php`
- `wp-content/plugins/kastalabs-core/includes/legacy-routes.php`
- `wp-content/plugins/kastalabs-core/kastalabs-core.php`
- `docs/WORKLOG.md`
- `docs/PROJECT-RESTRUCTURE-PLAN.md`
- `docs/PRODUCTION-QA-CHECKLIST.md`

Verification:
- PHP lint passed for all plugin and theme PHP files.
- WordPress bootstrap confirmed the legacy redirect option default is `0`, redirect handler is registered, and migration safety returns true locally.
- With the setting disabled, `/work/` returned `200` with no redirect and no PHP warnings.
- With the setting temporarily enabled, `/work/` returned `301` to `/portfolio/`.
- With the setting temporarily enabled, one migrated `/work/{slug}/` URL returned `301` to its matching `/portfolio/{slug}/`.
- The local redirect setting was restored to disabled after verification.
- Option sanitization stores checkbox values as `1` or `0`.

Status:
- Completed in this cycle.

## 2026-06-07 - Portfolio Migration Admin Status

Scope:
- Added Legacy Work migration status summary to Tools > Kastalabs Migration.
- Added pending legacy Work item listing with title and slug.
- Added reusable helper to detect whether a legacy Work item already has a migrated Portfolio record.
- Reused the helper inside the migration routine to avoid duplicate migration logic.
- Normalized old `_kasta_is_featured` migration into the final `is_featured` Portfolio meta.

Why:
- `/portfolio/` is the final public route, but `/work/` remains active until legacy content migration is proven safe.
- Admin users need visibility into migrated and pending legacy items before deciding whether `/work/` can be redirected.

Files:
- `wp-content/plugins/kastalabs-core/admin/migration.php`
- `docs/WORKLOG.md`
- `docs/PROJECT-RESTRUCTURE-PLAN.md`
- `docs/PRODUCTION-QA-CHECKLIST.md`

Verification:
- PHP lint passed for all plugin and theme PHP files.
- WordPress bootstrap confirmed the migration status and migrated Portfolio lookup helpers are available.
- Temporary QA legacy Work item was detected as pending, migrated into Portfolio, copied featured state, category, and tag, then removed together with its migrated Portfolio record.
- Local migration helper also migrated existing pending legacy Work content; local status now reports 7 legacy Work items, 7 migrated Portfolio records, and 0 pending items.
- `/portfolio/` and `/work/` returned `200` with no PHP warnings.

Status:
- Completed in this cycle.

## 2026-06-07 - Main Route SEO Settings

Scope:
- Added editable SEO title and meta description fields for Home, About, Services, Portfolio, Insights, and Contact.
- Added the new fields to Settings > Kastalabs Settings under SEO Main Routes.
- Updated theme SEO helpers so route-specific settings are used before global defaults and hardcoded archive fallback copy.
- Kept per-post/page `seo_title` and `seo_description` meta as the highest priority for singular content.

Why:
- Primary landing page routes need predictable backend SEO control before frontend polish and production QA.
- Admin users should not need to edit templates to tune meta title and description for core pages.

Files:
- `wp-content/plugins/kastalabs-core/includes/options.php`
- `wp-content/plugins/kastalabs-core/admin/settings.php`
- `wp-content/themes/kastalabs/inc/seo.php`
- `docs/WORKLOG.md`
- `docs/PRODUCTION-QA-CHECKLIST.md`

Verification:
- PHP lint passed for all plugin and theme PHP files.
- WordPress bootstrap confirmed the new SEO route option keys are available through merged Kastalabs options.
- Sanitization keeps route meta descriptions as textarea content and strips markup from route SEO titles.
- `/`, `/about/`, `/services/`, `/portfolio/`, `/insights/`, and `/contact/` returned `200`, rendered the expected route-specific SEO title and description, and exposed no PHP warnings.

Status:
- Completed in this cycle.

## 2026-06-07 - Inquiry Admin Operations Polish

Scope:
- Added sortable Inquiry columns for Lead Status, Follow Up, and Email Status.
- Added Email Status filtering to the Inquiry admin list table.
- Added Follow-up state filtering for due, upcoming, and no-date inquiries.
- Updated Inquiry CSV export to preserve the active Lead Status, Email Status, and Follow-up filters.
- Displayed email delivery state as readable labels in admin columns and CSV output.

Why:
- Contact inquiries are the primary backend conversion workflow.
- Admin users need to triage leads by follow-up timing and email delivery state, not only by lead status.

Files:
- `wp-content/plugins/kastalabs-core/post-types/inquiry.php`
- `docs/WORKLOG.md`
- `docs/PRODUCTION-QA-CHECKLIST.md`

Verification:
- PHP lint passed for all plugin and theme PHP files.
- `/contact/` returned `200`, kept the `admin-post.php` form action, kept the `kasta_contact` action, rendered the nonce field, and exposed no PHP warnings.
- WordPress bootstrap confirmed the private Inquiry CPT, sortable Inquiry columns hook, and Inquiry filtering hook are registered.
- Temporary QA Inquiry was created, matched by combined Lead Status + Email Status + due Follow-up export helper filters, then deleted successfully.

Status:
- Completed in this cycle.

## 2026-06-07 - Service Admin CMS Polish

Scope:
- Added Service admin columns for Order, Icon, Overview, and CTA.
- Added sortable Service Order and Icon columns.
- Added a CTA completeness filter for the Service admin list table.
- Fixed the Services page icon mapping so Service CPT content can render without relying on an undefined variable.
- Updated the restructure plan with the new Service CMS admin workflow.

Why:
- Services are a first-class CMS content area and need to be easy to review before frontend page polish.
- Editors should be able to see ordering, icon labels, summaries, and CTA completeness without opening every Service post.

Files:
- `wp-content/plugins/kastalabs-core/post-types/service.php`
- `wp-content/themes/kastalabs/page-services.php`
- `docs/PROJECT-RESTRUCTURE-PLAN.md`
- `docs/WORKLOG.md`

Verification:
- PHP lint passed for all plugin and theme PHP files.
- `/services/` returned `200`, rendered service copy, and did not expose PHP warnings.
- WordPress bootstrap confirmed the `service` CPT and Service admin hooks are registered.

Status:
- Completed in this cycle.

## 2026-06-07 - Backend Ownership And Portfolio Admin Cleanup

Scope:
- Removed inactive theme backend files for legacy contact handling, Work CPT registration, Work taxonomies, and Work meta registration.
- Confirmed active backend ownership remains in `wp-content/plugins/kastalabs-core`.
- Added Portfolio admin columns for Client, Year, Scope, and Featured state.
- Added sortable Portfolio Year and Featured columns.
- Added a Featured status filter for the Portfolio admin list table.
- Updated the restructure plan to record that CPTs, taxonomies, structured meta, inquiry handling, and migration helpers are plugin-owned.

Why:
- Backend-first development should keep CMS/business logic in the core plugin, not in the theme.
- Removing unused legacy files reduces ambiguity before the next Portfolio/Inquiry backend work.
- Portfolio content will be easier to review before frontend polish because admin users can quickly see which projects are featured.

Files:
- `wp-content/plugins/kastalabs-core/post-types/portfolio.php`
- `wp-content/themes/kastalabs/inc/contact.php`
- `wp-content/themes/kastalabs/inc/post-types.php`
- `wp-content/themes/kastalabs/inc/taxonomies.php`
- `wp-content/themes/kastalabs/inc/meta.php`
- `docs/PROJECT-RESTRUCTURE-PLAN.md`
- `docs/WORKLOG.md`

Verification:
- PHP lint passed for all plugin and theme PHP files.
- Public smoke routes `/`, `/contact/`, `/portfolio/`, and `/work/` returned `200`.
- Contact page still renders the `admin-post.php` form action, `kasta_contact` action, and nonce field handled by `kastalabs-core`.
- Runtime search found no remaining references to the removed legacy theme backend files/functions.
- WordPress bootstrap confirmed the `portfolio` CPT and Portfolio admin hooks are registered.

Status:
- Completed in this cycle.

## 2026-06-06 - Portfolio Route SEO Alignment

Scope:
- Aligned SEO metadata with the final `Portfolio` route.
- Added archive description support for `portfolio`.
- Kept `/work/` reachable as a legacy route but marked it as temporary through archive copy and canonical output.
- Expanded CreativeWork JSON-LD support from legacy `work` singles to final `portfolio` singles.
- Updated the 404 portfolio CTA to point to the final `/portfolio/` archive.

Why:
- Frontend planning defines `/portfolio/` as the final public route while `/work/` remains active only for migration safety.
- SEO and fallback CTAs should reinforce the final information architecture without forcing a redirect before migration is approved.

Files:
- `wp-content/themes/kastalabs/inc/seo.php`
- `wp-content/themes/kastalabs/404.php`
- `docs/FRONTEND-PLANNING.md`
- `docs/WORKLOG.md`

Verification:
- PHP lint passed for touched theme files.
- `/portfolio/` returned `200` and includes final Portfolio SEO description plus canonical `/portfolio/`.
- `/work/` returned `200` and includes temporary legacy SEO description plus canonical `/portfolio/`.
- A missing route returned `404` and the Portfolio CTA points to `/portfolio/`.

Status:
- Completed in this cycle.

## 2026-06-06 - Frontend Planning And Portfolio Stabilization

Scope:
- Added frontend planning source of truth.
- Stabilized homepage hero structure and reveal motion.
- Normalized primary portfolio CTAs from legacy `/work/` to `/portfolio/`.
- Restored final Portfolio archive and detail templates.
- Kept legacy Work route alive temporarily.
- Cleaned footer heading hierarchy.

Why:
- The project is moving from direct frontend experimentation into a sitemap -> copywriting -> wireframe -> hi-fi -> frontend workflow.
- The final public IA uses `Portfolio`, while `/work/` remains temporary legacy support.

Files:
- `docs/FRONTEND-PLANNING.md`
- `wp-content/themes/kastalabs/template-parts/hero/home.php`
- `wp-content/themes/kastalabs/archive-portfolio.php`
- `wp-content/themes/kastalabs/single-portfolio.php`
- `wp-content/themes/kastalabs/single-work.php`
- `wp-content/themes/kastalabs/src/js/animations.js`
- `wp-content/themes/kastalabs/template-parts/navigation/menu-footer.php`
- `wp-content/themes/kastalabs/template-parts/navigation/menu-social.php`

Verification:
- PHP lint passed for 106 files.
- `npm run build` passed.
- `/`, `/portfolio/`, and `/work/` returned `200`.
- Homepage heading hierarchy no longer includes footer labels as `h2`.

Status:
- Committed and pushed as `d9a0cbf Stabilize frontend planning and portfolio theme`.

## 2026-06-06 - Development Documentation Workflow

Scope:
- Added an active development workflow that requires documentation with every meaningful change.
- Added this worklog as the project-level implementation journal.
- Linked the workflow from frontend planning and project restructure documents.

Why:
- The team agreed that every change should be documented immediately so implementation and project direction stay aligned.

Files:
- `docs/DEVELOPMENT-WORKFLOW.md`
- `docs/WORKLOG.md`
- `docs/FRONTEND-PLANNING.md`
- `docs/PROJECT-RESTRUCTURE-PLAN.md`

Verification:
- Documentation files reviewed after creation.

Status:
- Committed in `Document development workflow`.

## 2026-06-06 - Local Artifact Cleanup

Scope:
- Added ignore rules for local Playwright/MCP output, Sisyphus output, and temporary screenshots.
- Removed existing local generated artifacts from the workspace.
- Updated the development workflow to explicitly keep root screenshots out of commits.

Why:
- The repo should stay focused on source code and project documentation.
- Local visual QA artifacts are useful during development but should not appear in `git status` or be committed accidentally.

Files:
- `.gitignore`
- `docs/DEVELOPMENT-WORKFLOW.md`
- `docs/WORKLOG.md`

Verification:
- Removed generated local artifacts with path checks constrained to the workspace.
- Checked `git status --short --untracked-files=normal` after cleanup.

Status:
- Committed in `Clean local development artifacts`.

## 2026-06-06 - Contact Page Microcopy QA

Scope:
- Reviewed primary frontend pages from local rendered screenshots.
- Updated Contact page hero pills to Indonesian-first labels.
- Updated contact form labels and feedback messages to match the frontend planning copy.
- Changed the form submit CTA from `Kirim pesan` to `Kirim inquiry`.

Why:
- Kastalabs copy direction is Indonesian-first with selective English industry terms.
- The contact form is a conversion-critical surface and should clearly map to the backend Inquiry workflow.

Files:
- `wp-content/themes/kastalabs/page-contact.php`
- `wp-content/themes/kastalabs/template-parts/forms/contact-form.php`
- `docs/WORKLOG.md`

Verification:
- PHP lint passed for touched Contact PHP files.
- Contact page HTML contains `Nama`, `Estimasi budget`, `Kirim inquiry`, `Inquiry proyek`, `Siap remote`, and `Berbasis di Indonesia`.
- Mobile Contact screenshot checked at 390px width.

Status:
- Committed in `Improve contact page microcopy`.

## 2026-06-07 - Backend Production QA Pass

Scope:
- Audited the public hardening layer for frontend and REST responses.
- Removed the public shortlink HTTP header from frontend pages.
- Added baseline security headers to public REST responses.
- Verified contact form nonce, honeypot, rate-limit, and Inquiry persistence behavior.
- Added backend QA evidence to the production QA checklist.

Why:
- The project is still in backend-first stabilization, so security/contact/SEO surfaces need evidence before the frontend rebuild phase.
- The documentation workflow requires every meaningful change to be captured in the same development cycle.

Files:
- `wp-content/plugins/kastalabs-core/includes/security.php`
- `docs/PRODUCTION-QA-CHECKLIST.md`
- `docs/WORKLOG.md`

Verification:
- `php -l wp-content/plugins/kastalabs-core/includes/security.php` passed.
- Homepage returned `200` with `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, and `Permissions-Policy`.
- Homepage no longer exposes the WordPress shortlink HTTP header.
- `/wp-json/wp/v2/users` returned `404` for anonymous requests and included baseline public headers.
- `/robots.txt` returned the required wp-admin rules and sitemap URL.
- `/sitemap.xml` returned `301` to `/wp-sitemap.xml`.
- Contact POST without nonce redirected to `contact_status=error`.
- Contact POST with honeypot redirected to `contact_status=sent` without creating an Inquiry.
- Valid contact POST created a private Inquiry and the QA record was deleted afterward.
- Contact rate limit allowed five attempts from the same IP and rejected the sixth.

Status:
- Committed in `Harden backend production QA`.
