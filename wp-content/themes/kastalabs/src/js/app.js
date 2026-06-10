/**
 * KastaLabs theme — JS entrypoint.
 *
 * Code-split strategy:
 * - Core (always): mobile-menu, mega-menu
 * - GSAP animations: lazy via dynamic import, only on pages that need them
 * - Page-specific: filtered by data-page attr on <main>
 *
 * ~22KB gzip saved on pages without animations (contact, 404, search, etc.)
 */

import '../css/app.css';
import { initMobileMenu } from './components/mobile-menu.js';
import initMegaMenu from './components/mega-menu.js';
import { initPageTransitions } from './components/page-transition.js';

/**
 * Page → GSAP module mapping.
 * Each entry is a dynamic import that loads GSAP + page-specific animations.
 * GSAP ~40KB gzip — only loaded when needed.
 */
const PAGE_ANIMATIONS = {
  'home':             () => import('./pages/home.js'),
  'portfolio-archive': () => import('./pages/work-archive.js'),
  'portfolio-single': () => import('./pages/portfolio-single.js'),
  'blog-single':      () => import('./pages/blog-single.js'),
  'insight-single':   () => import('./pages/blog-single.js'), // shares reading-progress
};

/**
 * Global GSAP animations shared across multiple pages.
 * Loaded when any page needs reveal, magnetic, or counters.
 */
const GLOBAL_ANIMATION_PAGES = new Set([
  'home', 'about', 'services', 'portfolio-archive', 'portfolio-single',
  'blog', 'insights', 'insight-single', 'blog-single',
]);

function bootstrap() {
  initMobileMenu();
  initMegaMenu();
  initPageTransitions();

  const main = document.querySelector('main[data-page]');
  if (!main) return;

  const page = main.dataset.page;

  // Load page-specific module
  const pageLoader = PAGE_ANIMATIONS[page];
  if (pageLoader) {
    pageLoader().then((mod) => mod.default?.()).catch(() => {});
  }

  // Load global GSAP animations for pages that need them
  if (GLOBAL_ANIMATION_PAGES.has(page)) {
    import('./animations.js').then((mod) => mod.default?.()).catch(() => {});
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', bootstrap);
} else {
  bootstrap();
}
