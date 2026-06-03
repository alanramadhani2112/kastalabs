/**
 * Generic reveal-on-scroll. Selector universal: [data-reveal].
 * Element fade-in + translate y kecil saat masuk viewport, sekali saja.
 *
 * Setiap markup yang ingin di-reveal cukup tambahkan attribute:
 *   <h2 data-reveal>...</h2>
 *
 * Dengan opsi fine-tune via attribute:
 *   data-reveal="up" | "down" | "left" | "right" | "fade"  (default "up")
 *   data-reveal-delay="0.2"
 *   data-reveal-duration="0.9"
 *
 * Idempoten: panggil ulang aman, marker dataset.revealInit cegah duplikasi.
 */

import { gsap, ScrollTrigger } from '../lib/gsap-init.js';
import { isReducedMotion } from '../lib/reduced-motion.js';

const DIRECTIONS = {
  up:    { y: 40, x: 0,  opacity: 0 },
  down:  { y: -40, x: 0, opacity: 0 },
  left:  { y: 0, x: 40,  opacity: 0 },
  right: { y: 0, x: -40, opacity: 0 },
  fade:  { y: 0, x: 0,   opacity: 0 },
};

export function initReveal(root = document) {
  const targets = root.querySelectorAll('[data-reveal]:not([data-reveal-init])');
  if (!targets.length) return;

  if (isReducedMotion()) {
    // Tampilkan langsung tanpa animasi.
    targets.forEach((el) => el.setAttribute('data-reveal-init', '1'));
    return;
  }

  targets.forEach((el) => {
    el.setAttribute('data-reveal-init', '1');
    const dir = el.dataset.reveal || 'up';
    const from = DIRECTIONS[dir] || DIRECTIONS.up;
    const delay = parseFloat(el.dataset.revealDelay || '0');
    const duration = parseFloat(el.dataset.revealDuration || '0.9');

    gsap.from(el, {
      ...from,
      duration,
      delay,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: el,
        start: 'top 85%',
        once: true,
      },
    });
  });
}