/**
 * Home page interaction orchestrator.
 *
 * Loaded lazily via PAGE_LOADERS['home'] in app.js.
 * Keep motion subtle and useful. The site direction is a calm company profile,
 * not an animation-heavy portfolio presentation.
 */

import { gsap, ScrollTrigger } from '../lib/gsap-init.js';
import { splitText } from '../components/text-split.js';
import { initMagnetic } from '../components/magnetic.js';
import { initMarquee } from '../components/marquee.js';
import { initSmoothScroll } from '../lib/smooth-scroll.js';
import { initScrollProgress } from '../components/scroll-progress.js';
import { initCounters } from '../components/counter.js';
import { scrambleText } from '../components/text-scramble.js';

export default function initHome() {
  initSmoothScroll();
  initScrollProgress();

  heroAnimation();
  marqueeVelocity();
  servicesAnimation();
  workGridAnimation();
  aboutTeaserAnimation();
  ctaAnimation();
  eyebrowScramble();

  initMagnetic();
  initMarquee();
  initCounters();
}

/* --------------------------------------------------------------------------
 * Hero — simple entrance with restrained parallax
 * -------------------------------------------------------------------------- */
function heroAnimation() {
  const hero = document.querySelector('[data-hero]');
  if (!hero) return;

  const headline = hero.querySelector('[data-hero-headline]');
  const subtitle = hero.querySelector('[data-hero-subtitle]');
  const ctas = hero.querySelector('[data-hero-ctas]');
  const eyebrow = hero.querySelector('[data-hero-eyebrow]');
  const layers = hero.querySelectorAll('[data-hero-layer]');

  const tl = gsap.timeline({
    defaults: { ease: 'power3.out' },
    delay: 0.15,
  });

  if (eyebrow) {
    tl.from(eyebrow, { opacity: 0, y: 14, duration: 0.45 });
  }

  if (headline) {
    const split = splitText(headline, { type: 'chars' });
    tl.from(split.chars, {
      y: '70%',
      opacity: 0,
      stagger: 0.012,
      duration: 0.72,
      ease: 'power3.out',
    }, '-=0.2');
  }

  if (subtitle) {
    tl.from(subtitle, { opacity: 0, y: 24, duration: 0.7, ease: 'power3.out' }, '-=0.45');
  }

  if (ctas) {
    tl.from(ctas.children, {
      opacity: 0,
      y: 18,
      stagger: 0.08,
      duration: 0.55,
    }, '-=0.5');
  }

  layers.forEach((layer) => {
    const depth = parseFloat(layer.dataset.heroLayer || '1');
    gsap.to(layer, {
      yPercent: 10 * depth,
      ease: 'none',
      scrollTrigger: {
        trigger: hero,
        start: 'top top',
        end: 'bottom top',
        scrub: true,
      },
    });
  });
}

/* --------------------------------------------------------------------------
 * Marquee — velocity-reactive speed
 * -------------------------------------------------------------------------- */
function marqueeVelocity() {
  const marquees = document.querySelectorAll('[data-marquee]');
  if (!marquees.length) return;

  let scrollVelocity = 0;
  let currentVelocity = 0;

  ScrollTrigger.create({
    trigger: document.body,
    start: 'top top',
    end: 'bottom bottom',
    onUpdate: (self) => {
      scrollVelocity = Math.abs(self.getVelocity());
    },
  });

  // Skew marquee tracks based on velocity
  const tracks = document.querySelectorAll('[data-marquee-track]');

  gsap.ticker.add(() => {
    currentVelocity += (scrollVelocity - currentVelocity) * 0.05;
    const skew = Math.min(currentVelocity / 1500, 4);

    tracks.forEach((track) => {
      gsap.set(track, { skewX: -skew });
    });

    scrollVelocity = 0;
  });
}

/* --------------------------------------------------------------------------
 * Services — individual ScrollTrigger per card (viewport-position stagger)
 * -------------------------------------------------------------------------- */
function servicesAnimation() {
  const section = document.querySelector('[data-services]');
  if (!section) return;

  const cards = section.querySelectorAll('[data-service-card]');
  if (!cards.length) return;

  // Each card triggers independently based on its own position
  cards.forEach((card, i) => {
    gsap.from(card, {
      y: 36,
      opacity: 0,
      duration: 0.65,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: card,
        start: 'top 85%',
        once: true,
      },
    });

  });
}

/* --------------------------------------------------------------------------
 * Work grid — clip-path reveal + hover distortion
 * -------------------------------------------------------------------------- */
function workGridAnimation() {
  const section = document.querySelector('[data-work-grid]');
  if (!section) return;

  const items = section.querySelectorAll('[data-work-item]');
  if (!items.length) return;

  items.forEach((item, i) => {
    const img = item.querySelector('img, video, [class*="bg-gradient"]');
    const overlay = item.querySelector('[class*="from-bg"]');

    // Clip-path reveal: polygon wipe from bottom
    gsap.from(item, {
      clipPath: 'polygon(0% 100%, 100% 100%, 100% 100%, 0% 100%)',
      duration: 1.2,
      ease: 'power4.inOut',
      scrollTrigger: {
        trigger: item,
        start: 'top 80%',
        once: true,
      },
    });

    // Slight scale on the image for depth
    if (img) {
      gsap.from(img, {
        scale: 1.3,
        duration: 1.5,
        ease: 'power3.out',
        scrollTrigger: {
          trigger: item,
          start: 'top 80%',
          once: true,
        },
      });

      // Continuous parallax
      gsap.to(img, {
        yPercent: -15,
        ease: 'none',
        scrollTrigger: {
          trigger: item,
          start: 'top bottom',
          end: 'bottom top',
          scrub: true,
        },
      });
    }

    item.addEventListener('mouseenter', () => {
      gsap.to(item, {
        scale: 0.99,
        duration: 0.4,
        ease: 'power2.out',
      });
      if (img) {
        gsap.to(img, { scale: 1.08, duration: 0.6, ease: 'power2.out' });
      }
    });

    item.addEventListener('mouseleave', () => {
      gsap.to(item, {
        scale: 1,
        duration: 0.45,
        ease: 'power2.out',
      });
      if (img) {
        gsap.to(img, { scale: 1.05, duration: 0.6, ease: 'power2.out' });
      }
    });
  });
}

/* --------------------------------------------------------------------------
 * About teaser — word-by-word scrub reveal + counter
 * -------------------------------------------------------------------------- */
function aboutTeaserAnimation() {
  const section = document.querySelector('[data-about-teaser]');
  if (!section) return;

  const heading = section.querySelector('[data-about-heading]');
  if (!heading) return;

  const split = splitText(heading, { type: 'words' });

  gsap.from(split.words, {
    opacity: 0.08,
    y: 10,
    stagger: 0.04,
    ease: 'none',
    scrollTrigger: {
      trigger: section,
      start: 'top 65%',
      end: 'top 20%',
      scrub: true,
    },
  });
}

/* --------------------------------------------------------------------------
 * CTA banner — scale + rotation entrance
 * -------------------------------------------------------------------------- */
function ctaAnimation() {
  const section = document.querySelector('[data-cta-banner]');
  if (!section) return;

  const inner = section.querySelector('[class*="rounded-3xl"]');
  if (!inner) return;

  gsap.from(inner, {
    scale: 0.85,
    opacity: 0,
    rotateX: -5,
    y: 60,
    duration: 1.2,
    ease: 'power3.out',
    scrollTrigger: {
      trigger: section,
      start: 'top 75%',
      once: true,
    },
  });
}

/* --------------------------------------------------------------------------
 * Eyebrow scramble — decode effect on all eyebrow elements
 * -------------------------------------------------------------------------- */
function eyebrowScramble() {
  const eyebrows = document.querySelectorAll('.eyebrow');
  if (!eyebrows.length) return;

  eyebrows.forEach((el) => {
    ScrollTrigger.create({
      trigger: el,
      start: 'top 85%',
      once: true,
      onEnter: () => {
        scrambleText(el, { duration: 1.0 });
      },
    });
  });
}
