/**
 * Counter animation component.
 *
 * Animates a number from 0 to target value when scrolled into view.
 *
 * Usage:
 *   <span data-counter="50">50</span>
 *   <span data-counter="5" data-counter-suffix="+">5+</span>
 *
 * Options:
 *   data-counter="100"          — target number
 *   data-counter-duration="2"   — animation duration in seconds (default 2)
 *   data-counter-suffix="+"     — suffix appended after number
 *   data-counter-prefix="$"     — prefix prepended before number
 */

import { gsap, ScrollTrigger } from '../lib/gsap-init.js';

export function initCounters(root = document) {
  const counters = root.querySelectorAll('[data-counter]:not([data-counter-init])');
  if (!counters.length) return;

  counters.forEach((el) => {
    el.setAttribute('data-counter-init', '1');

    const target = parseFloat(el.dataset.counter);
    const duration = parseFloat(el.dataset.counterDuration || '2');
    const suffix = el.dataset.counterSuffix || '';
    const prefix = el.dataset.counterPrefix || '';
    const isDecimal = target % 1 !== 0;

    const obj = { val: 0 };

    gsap.to(obj, {
      val: target,
      duration,
      ease: 'power2.out',
      scrollTrigger: {
        trigger: el,
        start: 'top 85%',
        once: true,
      },
      onUpdate() {
        const display = isDecimal ? obj.val.toFixed(1) : Math.round(obj.val);
        el.textContent = `${prefix}${display}${suffix}`;
      },
    });
  });
}
