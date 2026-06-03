/**
 * Magnetic button effect.
 *
 * Selector: [data-magnetic]
 * The element subtly follows the cursor when hovered, creating a "magnetic" pull.
 *
 * Options:
 *   data-magnetic-strength="0.3"  — pull strength 0-1 (default 0.3)
 *   data-magnetic-radius="1.5"    — activation radius multiplier (default 1.5)
 */

import { gsap } from '../lib/gsap-init.js';
import { isReducedMotion } from '../lib/reduced-motion.js';

export function initMagnetic(root = document) {
  if (isReducedMotion()) return;

  const elements = root.querySelectorAll('[data-magnetic]:not([data-magnetic-init])');
  if (!elements.length) return;

  elements.forEach((el) => {
    el.setAttribute('data-magnetic-init', '1');

    const strength = parseFloat(el.dataset.magneticStrength || '0.3');

    el.addEventListener('mousemove', (e) => {
      const rect = el.getBoundingClientRect();
      const cx = rect.left + rect.width / 2;
      const cy = rect.top + rect.height / 2;

      const dx = e.clientX - cx;
      const dy = e.clientY - cy;

      gsap.to(el, {
        x: dx * strength,
        y: dy * strength,
        duration: 0.4,
        ease: 'power2.out',
      });
    });

    el.addEventListener('mouseleave', () => {
      gsap.to(el, {
        x: 0,
        y: 0,
        duration: 0.6,
        ease: 'elastic.out(1, 0.4)',
      });
    });
  });
}
