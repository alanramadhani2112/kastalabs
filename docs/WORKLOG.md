# Kastalabs Worklog

Purpose:
- Record each meaningful development cycle.
- Keep implementation, verification, and documentation traceable.

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
