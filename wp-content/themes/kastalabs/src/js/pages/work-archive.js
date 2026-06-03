/**
 * Work archive interactions.
 *
 * Filters cards client-side for the current archive page and keeps the
 * controls accessible through aria-selected state.
 */

import { gsap, ScrollTrigger } from '../lib/gsap-init.js';

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

      card.classList.toggle('is-hidden', !isVisible);
      card.setAttribute('aria-hidden', isVisible ? 'false' : 'true');

      gsap.to(card, {
        autoAlpha: isVisible ? 1 : 0,
        y: isVisible ? 0 : 24,
        scale: isVisible ? 1 : 0.96,
        duration: 0.35,
        ease: 'power2.out',
        onStart: () => {
          if (isVisible) card.style.display = '';
        },
        onComplete: () => {
          if (!isVisible) card.style.display = 'none';
          ScrollTrigger.refresh();
        },
      });
    });

    liveRegion.textContent = `${visibleCount} project${visibleCount === 1 ? '' : 's'} shown`;
  }

  buttons.forEach((button) => {
    button.addEventListener('click', () => {
      applyFilter(button.dataset.filter || '*');
    });
  });

  gsap.from(cards, {
    opacity: 0,
    y: 48,
    stagger: 0.08,
    duration: 0.8,
    ease: 'power3.out',
  });
}
