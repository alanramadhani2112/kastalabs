/**
 * Scroll progress indicator.
 *
 * Thin horizontal bar at the top of the viewport showing page scroll progress.
 * Auto-creates its own DOM element.
 */

import { gsap, ScrollTrigger } from '../lib/gsap-init.js';

let bar = null;

export function initScrollProgress() {
  if (bar) return;

  bar = document.createElement('div');
  bar.className = 'scroll-progress';
  bar.setAttribute('aria-hidden', 'true');
  bar.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    width: 0%;
    height: 3px;
    background: linear-gradient(90deg, var(--color-primary-400), var(--color-primary-600));
    z-index: 9999;
    pointer-events: none;
    transform-origin: left;
    will-change: width;
  `;
  document.body.appendChild(bar);

  gsap.to(bar, {
    width: '100%',
    ease: 'none',
    scrollTrigger: {
      trigger: document.documentElement,
      start: 'top top',
      end: 'bottom bottom',
      scrub: 0.3,
    },
  });
}

export function destroyScrollProgress() {
  if (bar) {
    bar.remove();
    bar = null;
  }
}
