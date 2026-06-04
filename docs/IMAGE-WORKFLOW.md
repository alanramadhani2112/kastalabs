# Kastalabs Image Workflow

This document records the production image workflow implemented in the Kastalabs WordPress theme.

## Theme Sizes

The theme registers three cropped image sizes in `wp-content/themes/kastalabs/inc/setup.php`:

| Size | Dimensions | Usage |
| --- | --- | --- |
| `kasta-cover` | 1920 x 1080 | Portfolio, insight, and article hero images |
| `kasta-card` | 960 x 720 | Portfolio archive and featured cards |
| `kasta-thumb` | 480 x 360 | Blog and insight listing thumbnails |

## Upload Policy

The media workflow lives in `wp-content/themes/kastalabs/inc/media.php`:

- Oversized uploads are capped at `1920px`.
- Generated image quality is set to `82`.
- WebP and AVIF uploads are explicitly allowed.
- WordPress-rendered images receive `decoding="async"` by default.
- Non-priority images receive `loading="lazy"` by default.
- Known theme sizes receive responsive `sizes` attributes.

## LCP Images

Primary featured images on single Portfolio, Insight, Work, and Post templates use:

- `loading="eager"`
- `fetchpriority="high"`
- `decoding="async"` through the global media helper

Use this only for the main above-the-fold image on detail pages. Listing cards and below-the-fold images should stay lazy-loaded.

## Editorial Guidance

- Prefer WebP or AVIF for final assets.
- Keep hero images close to 16:9.
- Avoid uploading very large originals unless archival quality is needed.
- Use descriptive featured image alt text in WordPress Media Library.
- Regenerate thumbnails after changing image sizes on an existing production site.
