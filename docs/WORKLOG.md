# Kastalabs Worklog

Purpose:
- Record each meaningful development cycle.
- Keep implementation, verification, and documentation traceable.

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
