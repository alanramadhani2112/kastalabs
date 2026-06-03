/**
 * Helper untuk respect prefers-reduced-motion.
 * Dipakai di seluruh komponen animasi sebelum spawn tween/scroll-driven effect.
 */

export function isReducedMotion() {
  if (typeof window === 'undefined') return false;
  return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}