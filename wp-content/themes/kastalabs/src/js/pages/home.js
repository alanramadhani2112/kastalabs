/**
 * Home page animations.
 *
 * Progressive enhancement — all content visible before JS runs.
 * Only adds motion polish on top.
 */

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { splitText } from '../components/text-split.js';
import { initCounters } from '../components/counter.js';

gsap.registerPlugin(ScrollTrigger);

export default function initHome() {
  initHeroHeading();
  initHeroParallax();
  initCounters();
}

/**
 * Hero heading — subtle word-by-word reveal.
 * Words start at y+12px and fade up, staggered 60ms.
 * Content is already visible; this just adds polish.
 */
function initHeroHeading() {
  const heading = document.querySelector('[data-hero-headline]');
  if (!heading) return;

  const split = splitText(heading, { type: 'words' });
  if (!split.words.length) return;

  gsap.fromTo(
    split.words,
    { y: 12, opacity: 0.85 },
    {
      y: 0,
      opacity: 1,
      duration: 0.5,
      stagger: 0.06,
      ease: 'power3.out',
      delay: 0.2,
    }
  );
}

/**
 * Hero parallax — subtle background shift on scroll.
 */
function initHeroParallax() {
  const bg = document.querySelector('[data-hero-bg]');
  if (!bg) return;

  gsap.to(bg, {
    y: '5%',
    ease: 'none',
    scrollTrigger: {
      trigger: '[data-hero]',
      start: 'top top',
      end: 'bottom top',
      scrub: 0.5,
    },
  });
}
