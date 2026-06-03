/**
 * GSAP bootstrapping.
 *
 * - Register plugin yang dipakai project ini.
 * - Set defaults supaya konsisten di seluruh komponen.
 * - Refresh ScrollTrigger setelah font siap supaya layout SplitText akurat.
 *
 * SplitText dan plugin GSAP lain semuanya FREE setelah Webflow akuisisi.
 */

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

let initialized = false;

export function initGsap() {
  if (initialized) return;
  initialized = true;

  gsap.registerPlugin(ScrollTrigger);

  gsap.defaults({
    ease: 'power3.out',
    duration: 0.6,
  });

  ScrollTrigger.config({
    ignoreMobileResize: true,
  });

  // Refresh ScrollTrigger ketika font selesai di-load,
  // mencegah glitch dari font swap yang ubah layout.
  if (typeof document !== 'undefined' && document.fonts && document.fonts.ready) {
    document.fonts.ready.then(() => ScrollTrigger.refresh());
  }
}

export { gsap, ScrollTrigger };