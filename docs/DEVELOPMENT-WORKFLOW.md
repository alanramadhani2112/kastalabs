# Kastalabs Development Workflow

Status: Active
Date: 2026-06-06

Purpose:
- Keep every project change traceable.
- Make documentation part of the development process, not a separate cleanup task.
- Reduce drift between sitemap, copywriting, wireframe, hi-fi direction, backend behavior, and committed code.

## 1. Core Rule

Every meaningful change must be documented in the same work cycle.

Meaningful changes include:
- page/template changes
- copywriting changes
- sitemap or route changes
- backend/admin changes
- contact/inquiry workflow changes
- SEO/security/performance changes
- visual system changes
- build tooling or asset pipeline changes
- bug fixes that affect user behavior

Small mechanical changes can be documented briefly in the worklog and commit message.

## 2. Required Workflow

Use this order for each development cycle:

1. Read the relevant source of truth.
2. Make the scoped change.
3. Verify locally.
4. Update documentation.
5. Commit with a clear message.
6. Push when the user asks or when the milestone is complete.

Do not let code and docs drift.

## 3. Documentation Targets

Use the most relevant document:

| Change Type | Documentation Target |
| --- | --- |
| Frontend sitemap, copy, wireframe, hi-fi, page flow | `docs/FRONTEND-PLANNING.md` |
| Architecture phases, project direction, roadmap | `docs/PROJECT-RESTRUCTURE-PLAN.md` |
| Launch checks and verification steps | `docs/PRODUCTION-QA-CHECKLIST.md` |
| Image and media workflow | `docs/IMAGE-WORKFLOW.md` |
| Typography decisions | `docs/TYPOGRAPHY-SYSTEM.md` |
| Daily implementation notes | `docs/WORKLOG.md` |

If no existing document fits, create a small focused document under `docs/`.

## 4. Worklog Format

Every development cycle should add an entry to `docs/WORKLOG.md`:

```text
## YYYY-MM-DD - Short Title

Scope:
- What changed.

Why:
- Why the change matters.

Files:
- Important files touched.

Verification:
- Commands or manual checks run.

Status:
- Draft, committed, pushed, or blocked.
```

## 5. Verification Expectations

Choose checks based on the change.

Baseline checks:
- `php -l` for touched PHP files.
- Full PHP lint when broad theme/plugin files changed.
- `npm run build` when CSS/JS/theme assets changed.
- Route smoke test for affected pages.
- Screenshot check for visual changes.

Frontend route smoke test should cover:
- `/`
- `/about/`
- `/services/`
- `/portfolio/`
- `/insights/`
- `/contact/`

Backend/contact changes should cover:
- contact form submission storage
- Inquiry admin visibility
- CSV export if export fields changed
- nonce/honeypot/rate limit behavior if form logic changed

## 6. Commit Discipline

Before commit:
- Stage only source files and intentional documentation.
- Do not stage local artifacts or screenshots unless explicitly needed.
- Keep `.playwright-mcp/`, `.sisyphus/`, temporary screenshots, and generated local evidence out of commits.
- Keep root screenshots such as `homepage.png`, `services-section.png`, and `zoom-homepage.png` out of commits.

Commit messages should describe the user-visible or project-visible outcome:
- `Document frontend development workflow`
- `Stabilize homepage hero and portfolio routing`
- `Add inquiry follow-up fields`

## 7. Push Discipline

Push when:
- the user asks for it
- a stable milestone is verified
- a backend/production safety change is complete

Before push:
- confirm the current branch
- confirm the remote
- verify the latest commit includes only intended files

## 8. Current Project State

Latest stable pushed commit before this workflow:
- `d9a0cbf Stabilize frontend planning and portfolio theme`

Current frontend source of truth:
- `docs/FRONTEND-PLANNING.md`

Current implementation priority:
1. Keep documentation updated with every change.
2. Keep local artifacts ignored and outside commits.
3. Continue sitemap-led frontend QA and polish.
4. Resolve `/work/` legacy route strategy.
5. Continue page-by-page frontend refinement.
