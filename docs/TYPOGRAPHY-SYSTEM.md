# Kastalabs Typography System

This document records the responsive typography system implemented in the Kastalabs WordPress theme.

## Source

The system follows the provided "KASTALABS RESPONSIVE TYPOGRAPHY SYSTEM" direction:

- Font family: Plus Jakarta Sans across the website.
- Tone: modern, editorial, spacious, readable, premium, and calm.
- Primary text color: `#000C1A`.
- Paragraph measure: `65ch`.
- Large heading measure: `12ch` to `16ch`.
- Typography sizes use explicit breakpoint steps, not fluid viewport scaling.

## Theme Implementation

The implementation lives in:

- `wp-content/themes/kastalabs/src/css/app.css`
- `wp-content/themes/kastalabs/inc/enqueue.php`

Google Fonts now loads only Plus Jakarta Sans. Former mono styling has been removed from labels, counters, navigation helpers, form labels, and code snippets so the whole site uses one consistent type family.

## Semantic Classes

Use these classes in templates and components:

| Class | Usage |
| --- | --- |
| `type-display-xl` | Main homepage hero heading |
| `type-display-lg` | Large page and project hero headings |
| `type-h1` | Main editorial/article page heading |
| `type-h2` | Major section heading |
| `type-h3` | Sub-section heading |
| `type-h4` | Card, feature, compact panel heading |
| `type-body-lg` | Hero descriptions and featured intro copy |
| `type-body` | Default paragraph text |
| `type-body-sm` | Metadata, secondary copy, menu links |
| `type-label` | Tags, labels, counters, small navigation labels |
| `type-button` | Button-like inline text when not using `.btn-primary` or `.btn-ghost` |

## Measure Utilities

| Class | Usage |
| --- | --- |
| `measure-copy` | Limits prose and intro copy to `65ch` |
| `measure-heading` | Limits large headings to `16ch` |

The `.prose` component also defaults to a `65ch` max-width and maps content headings to the same semantic scale.

## Scale

| Token | Mobile | Tablet | Desktop | Weight | Line height |
| --- | --- | --- | --- | --- | --- |
| Display XL | 48px | 64px | 84px | 700 | 110% |
| Display Large | 40px | 56px | 72px | 700 | 115% |
| H1 | 36px | 48px | 56px | 700 | 120% |
| H2 | 30px | 40px | 48px | 700 | 125% |
| H3 | 24px | 30px | 36px | 600 | 130% |
| H4 | 20px | 24px | 24px | 600 | 135% |
| Body Large | 18px | 18px | 20px | 400 | 170% |
| Body | 16px | 16px | 18px | 400 | 170% |
| Body Small | 14px | 14px | 15px | 400 | 165% |
| Label | 12px | 12px | 13px | 500 | 150% |
| Button | 14px | 14px | 15px | 600 | 100% |

## Template Mapping

- Homepage hero: `type-display-xl`, `type-body-lg`.
- Page and portfolio/work hero headings: `type-display-lg`.
- Blog and insight single headings: `type-h1`.
- Homepage section headings: `type-h2`.
- Cards and compact headings: `type-h4`.
- Eyebrows, counters, and filter labels: `.eyebrow` or `type-label`.
- Buttons: `.btn-primary` and `.btn-ghost`, which now inherit the button scale.

## Rules For Future Sections

- Do not add ad hoc large Tailwind text classes such as `text-8xl`, `text-9xl`, or arbitrary `text-[...]` for typography.
- Do not use `font-size: clamp()` for typography. Use semantic classes and breakpoint steps.
- Keep body copy within `65ch`.
- Use `type-h4` inside cards and compact panels instead of oversized headings.
- Use Plus Jakarta Sans for all visible website typography.
