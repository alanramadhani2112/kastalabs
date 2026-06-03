/**
 * Home page GSAP orchestrator — ENHANCED.
 *
 * Loaded lazily via PAGE_LOADERS['home'] in app.js.
 * Premium interactions:
 *   - Pinned hero with horizontal text reveal
 *   - Text scramble on eyebrows
 *   - Parallax depth layers
 *   - Velocity-based marquee
 *   - Services stagger per-viewport-position
 *   - Work grid clip-path reveals + hover distortion
 *   - Counter animation on about stats
 *   - CTA scale-in
 *   - Scroll progress bar
 */

import { gsap, ScrollTrigger } from '../lib/gsap-init.js';
import { splitText } from '../components/text-split.js';
import { initMagnetic } from '../components/magnetic.js';
import { initMarquee } from '../components/marquee.js';
import { initCursor } from '../components/cursor.js';
import { initSmoothScroll } from '../lib/smooth-scroll.js';
import { initScrollProgress } from '../components/scroll-progress.js';
import { initCounters } from '../components/counter.js';
import { scrambleText } from '../components/text-scramble.js';

export default function initHome() {
  initSmoothScroll();
  initCursor();
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
 * Hero — pinned section with split text + multi-layer parallax
 * -------------------------------------------------------------------------- */
function heroAnimation() {
  const hero = document.querySelector('[data-hero]');
  if (!hero) return;

  const headline = hero.querySelector('[data-hero-headline]');
  const subtitle = hero.querySelector('[data-hero-subtitle]');
  const ctas = hero.querySelector('[data-hero-ctas]');
  const eyebrow = hero.querySelector('[data-hero-eyebrow]');
  const layers = hero.querySelectorAll('[data-hero-layer]');

  // Pin hero for dramatic entrance
  ScrollTrigger.create({
    trigger: hero,
    start: 'top top',
    end: '+=50%',
    pin: true,
    pinSpacing: true,
  });

  // Entrance timeline
  const tl = gsap.timeline({
    defaults: { ease: 'power3.out' },
    delay: 0.3,
  });

  // Eyebrow scramble + fade
  if (eyebrow) {
    tl.from(eyebrow, { opacity: 0, y: 20, duration: 0.6 });
  }

  // Headline split-text with perspective
  if (headline) {
    headline.style.perspective = '1000px';
    const split = splitText(headline, { type: 'chars' });
    tl.from(split.chars, {
      y: '120%',
      rotateX: -90,
      opacity: 0,
      stagger: 0.018,
      duration: 1,
      ease: 'power4.out',
    }, '-=0.2');
  }

  // Subtitle slide up
  if (subtitle) {
    tl.from(subtitle, { opacity: 0, y: 40, duration: 1, ease: 'power3.out' }, '-=0.6');
  }

  // CTA buttons pop in
  if (ctas) {
    tl.from(ctas.children, {
      opacity: 0,
      y: 30,
      scale: 0.9,
      stagger: 0.12,
      duration: 0.7,
    }, '-=0.5');
  }

  // Multi-layer parallax on scroll (after pin releases)
  layers.forEach((layer) => {
    const depth = parseFloat(layer.dataset.heroLayer || '1');
    gsap.to(layer, {
      yPercent: 30 * depth,
      ease: 'none',
      scrollTrigger: {
        trigger: hero,
        start: 'top top',
        end: 'bottom top',
        scrub: true,
      },
    });
  });

  // Fallback: if no layers, parallax the bg
  const bg = hero.querySelector('[data-hero-bg]');
  if (bg && !layers.length) {
    gsap.to(bg, {
      yPercent: 40,
      ease: 'none',
      scrollTrigger: {
        trigger: hero,
        start: 'top top',
        end: 'bottom top',
        scrub: true,
      },
    });
  }
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
      y: 80,
      opacity: 0,
      rotateX: -15,
      scale: 0.95,
      duration: 0.9,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: card,
        start: 'top 85%',
        once: true,
      },
    });

    // Glow line on top of card
    const glow = document.createElement('div');
    glow.className = 'service-card-glow';
    glow.setAttribute('aria-hidden', 'true');
    card.style.position = 'relative';
    card.appendChild(glow);
  });

  // 3D tilt on hover
  cards.forEach((card) => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = (e.clientX - rect.left) / rect.width - 0.5;
      const y = (e.clientY - rect.top) / rect.height - 0.5;

      gsap.to(card, {
        rotateY: x * 12,
        rotateX: -y * 12,
        transformPerspective: 800,
        duration: 0.3,
        ease: 'power2.out',
      });
    });

    card.addEventListener('mouseleave', () => {
      gsap.to(card, {
        rotateY: 0,
        rotateX: 0,
        duration: 0.7,
        ease: 'elastic.out(1, 0.4)',
      });
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

    // Hover distortion (skew + scale)
    item.addEventListener('mouseenter', () => {
      gsap.to(item, {
        scale: 0.98,
        skewY: -1,
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
        skewY: 0,
        duration: 0.6,
        ease: 'elastic.out(1, 0.5)',
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
