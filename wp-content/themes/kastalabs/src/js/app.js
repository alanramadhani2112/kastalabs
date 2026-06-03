/**
 * KastaLabs theme - JS entrypoint.
 *
 * - Boot GSAP & always-on components (reveal).
 * - Lazy-load page-specific bundles berdasarkan body[data-page].
 * - Respect prefers-reduced-motion: disable scroll-driven animations.
 */

import './../css/app.css';
import { initGsap } from './lib/gsap-init.js';
import { isReducedMotion } from './lib/reduced-motion.js';
import { initReveal } from './components/reveal.js';

const PAGE_LOADERS = {
  'home':         () => import('./pages/home.js'),
  'work-archive': () => import('./pages/work-archive.js'),
  // 'work-single':  () => import('./pages/work-single.js'),
  // 'blog':         () => import('./pages/blog.js'),
  'blog-single':  () => import('./pages/blog-single.js'),
};

function bootstrap() {
  initGsap();
  initReveal();

  if (isReducedMotion()) {
    document.documentElement.dataset.motion = 'reduced';
    return;
  }

  const page = document.body.dataset.page || document.querySelector('[data-page]')?.dataset.page;
  const loader = PAGE_LOADERS[page];
  if (typeof loader === 'function') {
    loader().then((mod) => {
      if (typeof mod.default === 'function') mod.default();
    });
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', bootstrap);
} else {
  bootstrap();
}
