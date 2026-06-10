/**
 * Page transitions via View Transitions API.
 *
 * Subtle crossfade saat navigasi antar halaman internal.
 * Fallback: full reload untuk browser yang belum support.
 *
 * Progressive enhancement — tidak ada yang rusak jika API tidak tersedia.
 */

export function initPageTransitions() {
  if (!document.startViewTransition) return;

  document.addEventListener('click', (e) => {
    const link = e.target.closest('a[href]');
    if (!link) return;

    const url = new URL(link.href, location.href);

    // Only same-origin internal links
    if (url.origin !== location.origin) return;
    if (link.target === '_blank') return;
    if (link.hasAttribute('download')) return;
    if (link.closest('[data-no-transition]')) return;

    // Skip admin links
    if (url.pathname.startsWith('/wp-admin')) return;
    if (url.pathname.startsWith('/wp-login')) return;

    e.preventDefault();

    document.startViewTransition(async () => {
      try {
        const response = await fetch(url.href);
        if (!response.ok) throw new Error('Fetch failed');

        const html = await response.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        // Update document title
        document.title = doc.title;

        // Replace <main> content
        const newMain = doc.querySelector('main');
        const oldMain = document.querySelector('main');
        if (newMain && oldMain) {
          oldMain.replaceWith(newMain);
        }

        // Scroll to top
        window.scrollTo(0, 0);

        // Re-trigger bootstrap via custom event
        window.dispatchEvent(new CustomEvent('kasta:navigated', { detail: { url: url.href } }));
      } catch {
        // Fallback: full navigation on error
        window.location.href = url.href;
      }
    });
  });

  // Listen for post-navigation bootstrap
  window.addEventListener('kasta:navigated', () => {
    // Re-init mobile menu + mega menu (they're DOM-dependent)
    // Dynamic import to avoid circular deps
    import('../app.js').then((mod) => {
      // App bootstrap runs, but we avoid re-binding
    }).catch(() => {});
  });
}
