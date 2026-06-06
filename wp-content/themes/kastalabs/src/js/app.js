/**
 * KastaLabs theme - JS entrypoint.
 */

import './../css/app.css';
import { initMobileMenu } from './components/mobile-menu.js';
import initMegaMenu from './components/mega-menu.js';
import initWorkArchive from './pages/work-archive.js';
import initAnimations from './animations.js';

function bootstrap() {
  initMobileMenu();
  initMegaMenu();

  if (document.querySelector('[data-work-filters]')) {
    initWorkArchive();
  }

  initAnimations();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', bootstrap);
} else {
  bootstrap();
}
