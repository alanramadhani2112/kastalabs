/**
 * Smooth scroll via Lenis.
 *
 * Integrates Lenis with GSAP ScrollTrigger for buttery smooth scrolling.
 * Automatically disabled on reduced-motion preference.
 */

import Lenis from 'lenis';
import { gsap, ScrollTrigger } from '../lib/gsap-init.js';
import { isReducedMotion } from '../lib/reduced-motion.js';

let lenis = null;

export function initSmoothScroll() {
  if (isReducedMotion()) return;
  if (lenis) return;

  lenis = new Lenis({
    duration: 1.2,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    orientation: 'vertical',
    gestureOrientation: 'vertical',
    smoothWheel: true,
    touchMultiplier: 2,
  });

  // Sync Lenis scroll with GSAP ScrollTrigger
  lenis.on('scroll', ScrollTrigger.update);

  gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
  });

  gsap.ticker.lagSmoothing(0);
}

export function destroySmoothScroll() {
  if (lenis) {
    lenis.destroy();
    lenis = null;
  }
}

export { lenis };
