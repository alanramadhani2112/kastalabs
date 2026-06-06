/**
 * Work archive interactions.
 *
 * Filter cards client-side dengan toggle visibility.
 * Tanpa animasi — efek GSAP ditunda ke akhir development.
 */

export default function initWorkArchive() {
  const filterBar = document.querySelector('[data-work-filters]');
  const cards = Array.from(document.querySelectorAll('[data-work-card]'));

  if (!filterBar || !cards.length) return;

  const buttons = Array.from(filterBar.querySelectorAll('[data-filter]'));
  const liveRegion = document.createElement('p');
  liveRegion.className = 'sr-only';
  liveRegion.setAttribute('aria-live', 'polite');
  filterBar.appendChild(liveRegion);

  function applyFilter(filter) {
    let visibleCount = 0;

    buttons.forEach((button) => {
      const isActive = button.dataset.filter === filter;
      button.classList.toggle('is-active', isActive);
      button.setAttribute('aria-selected', isActive ? 'true' : 'false');
    });

    cards.forEach((card) => {
      const categories = (card.dataset.category || '').split(/\s+/);
      const isVisible = filter === '*' || categories.includes(filter);

      if (isVisible) visibleCount += 1;
      card.hidden = !isVisible;
    });

    liveRegion.textContent = `${visibleCount} project${visibleCount === 1 ? '' : 's'} shown`;
  }

  buttons.forEach((button) => {
    button.addEventListener('click', () => {
      applyFilter(button.dataset.filter || '*');
    });
  });
}
