/**
 * Mega menu toggle — open/close dropdown panels.
 */

export default function initMegaMenu() {
  const header = document.querySelector('[data-site-header]');
  if (!header) return;

  const toggles = header.querySelectorAll('[data-mega-toggle]');
  const panels = header.querySelectorAll('[data-mega-panel]');
  if (!toggles.length || !panels.length) return;

  let openId = null;

  const closeAll = () => {
    toggles.forEach((t) => t.setAttribute('aria-expanded', 'false'));
    panels.forEach((p) => {
      p.hidden = true;
      p.setAttribute('aria-hidden', 'true');
    });
    openId = null;
  };

  toggles.forEach((toggle) => {
    const id = toggle.dataset.megaToggle;
    const panel = header.querySelector(`#mega-${id}`);

    if (!panel) return;

    toggle.addEventListener('click', (e) => {
      e.stopPropagation();

      if (openId === id) {
        closeAll();
        return;
      }

      closeAll();
      toggle.setAttribute('aria-expanded', 'true');
      panel.hidden = false;
      panel.setAttribute('aria-hidden', 'false');
      openId = id;
    });

    // Hover to open on desktop
    toggle.addEventListener('mouseenter', () => {
      if (window.matchMedia('(max-width: 767px)').matches) return;
      closeAll();
      toggle.setAttribute('aria-expanded', 'true');
      panel.hidden = false;
      panel.setAttribute('aria-hidden', 'false');
      openId = id;
    });

    // Keep open when hovering panel
    panel.addEventListener('mouseenter', () => {
      if (window.matchMedia('(max-width: 767px)').matches) return;
      // Already open, keep it
    });
  });

  // Close when leaving header area
  header.addEventListener('mouseleave', () => {
    closeAll();
  });

  // Close on Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && openId) closeAll();
  });
}
