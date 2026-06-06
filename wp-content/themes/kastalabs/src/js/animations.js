/**
 * GSAP interaction effects — animation layer.
 *
 * 1. ScrollReveal — subtle slide saat scroll
 * 2. Magnetic hover — button follow cursor
 * 3. Hero parallax — subtle bg movement
 * 4. Counter — angka animasi
 * 5. Card tilt — 3D perspective hover pada cards
 * 6. FAQ accordion — smooth GSAP height expand/collapse
 * 7. Stagger reveal — cascade children in data-reveal containers
 *
 * @requires gsap ^3.13.0 (ScrollTrigger included)
 */

import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollToPlugin } from 'gsap/ScrollToPlugin';

gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

/**
 * 1. ScrollReveal — fade up + slide
 * Target: .reveal (data-reveal elements), [data-section] pada homepage
 */
function initScrollReveal() {
  const sections = document.querySelectorAll('[data-reveal]');

  if (!sections.length) return;

  sections.forEach((el) => {
    const delay = el.dataset.revealDelay
      ? parseFloat(el.dataset.revealDelay)
      : 0;
    const speed = el.dataset.revealSpeed
      ? parseFloat(el.dataset.revealSpeed)
      : 0.6;

    gsap.fromTo(
      el,
      { y: 18, opacity: 1 },
      {
        y: 0,
        opacity: 1,
        duration: speed,
        delay,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: el,
          start: 'top 88%',
          toggleActions: 'play none none none',
        },
      }
    );
  });
}

/**
 * 2. Magnetic hover — CTA buttons
 * Target: [data-magnetic] atau .btn-primary
 * Bergerak max 6px mengikuti kursor.
 */
function initMagnetic() {
  const buttons = document.querySelectorAll('[data-magnetic]');

  buttons.forEach((btn) => {
    const strength = parseFloat(btn.dataset.magneticStrength) || 6;

    btn.addEventListener('mousemove', (e) => {
      const rect = btn.getBoundingClientRect();
      const x = (e.clientX - rect.left - rect.width / 2) / strength;
      const y = (e.clientY - rect.top - rect.height / 2) / strength;
      gsap.to(btn, {
        x,
        y,
        duration: 0.3,
        ease: 'power2.out',
      });
    });

    btn.addEventListener('mouseleave', () => {
      gsap.to(btn, {
        x: 0,
        y: 0,
        duration: 0.4,
        ease: 'power3.out',
      });
    });
  });
}

/**
 * 3. Hero parallax — subtle background movement
 * Target: [data-hero-bg]
 * Bergerak ~8% dari scroll.
 */
function initHeroParallax() {
  const bg = document.querySelector('[data-hero-bg]');
  if (!bg) return;

  gsap.to(bg, {
    y: '8%',
    ease: 'none',
    scrollTrigger: {
      trigger: '[data-hero]',
      start: 'top top',
      end: 'bottom top',
      scrub: true,
    },
  });
}

/**
 * 4. Counter — animate angka stat
 * Target: [data-counter]
 */
function initCounters() {
  const counters = document.querySelectorAll('[data-counter]');

  counters.forEach((el) => {
    const target = parseInt(el.dataset.counter, 10);
    const suffix = el.dataset.counterSuffix || '';
    const speed = parseFloat(el.dataset.counterSpeed) || 1.8;
    const obj = { val: 0 };

    ScrollTrigger.create({
      trigger: el,
      start: 'top 85%',
      once: true,
      onEnter: () => {
        gsap.to(obj, {
          val: target,
          duration: speed,
          ease: 'power2.out',
          onUpdate: () => {
            el.textContent = Math.round(obj.val) + suffix;
          },
        });
      },
    });
  });
}

/**
 * 5. Card tilt — 3D perspective hover pada interactive cards.
 * Target: [data-tilt]
 * Subtle rotation mengikuti posisi kursor di dalam card.
 */
function initCardTilt() {
  const cards = document.querySelectorAll('[data-tilt]');

  cards.forEach((card) => {
    const strength = parseFloat(card.dataset.tiltStrength) || 8;

    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = (e.clientX - rect.left) / rect.width - 0.5;
      const y = (e.clientY - rect.top) / rect.height - 0.5;

      gsap.to(card, {
        rotateY: x * strength,
        rotateX: -y * strength,
        duration: 0.4,
        ease: 'power2.out',
      });
    });

    card.addEventListener('mouseleave', () => {
      gsap.to(card, {
        rotateY: 0,
        rotateX: 0,
        duration: 0.6,
        ease: 'power3.out',
      });
    });
  });
}

/**
 * 6. FAQ accordion — smooth GSAP height expand/collapse.
 * Target: [data-faq-item]
 * Mengganti CSS height transition dengan GSAP untuk animasi yang lebih halus.
 */
function initFaqAccordion() {
  const faqItems = document.querySelectorAll('[data-faq-item]');

  faqItems.forEach((item) => {
    const trigger = item.querySelector('[data-faq-toggle]');
    const panel = item.querySelector('[data-faq-panel]');
    if (!trigger || !panel) return;

    // Ukur tinggi natural
    const getHeight = () => {
      const clone = panel.cloneNode(true);
      clone.style.position = 'absolute';
      clone.style.visibility = 'hidden';
      clone.style.height = 'auto';
      clone.style.width = panel.offsetWidth + 'px';
      document.body.appendChild(clone);
      const h = clone.offsetHeight;
      document.body.removeChild(clone);
      return h;
    };

    let isOpen = panel.style.display !== 'none' || !panel.hasAttribute('hidden');
    let tween = null;

    trigger.addEventListener('click', () => {
      isOpen = !isOpen;
      const targetHeight = isOpen ? getHeight() : 0;

      if (tween) tween.kill();

      trigger.setAttribute('aria-expanded', isOpen);
      item.classList.toggle('is-open', isOpen);

      if (isOpen) {
        panel.style.display = '';
        panel.style.overflow = 'hidden';
      }

      tween = gsap.to(panel, {
        height: targetHeight,
        duration: 0.35,
        ease: 'power2.inOut',
        onComplete: () => {
          if (!isOpen) panel.style.display = 'none';
          panel.style.overflow = isOpen ? 'visible' : 'hidden';
        },
      });
    });
  });
}

/**
 * 7. Stagger reveal — cascade children di dalam [data-reveal] containers.
 * Target: [data-reveal] yang punya > 1 child langsung.
 * Children bergerak staggered 80ms per item tanpa menyembunyikan konten.
 */
function initStaggerReveal() {
  const containers = document.querySelectorAll('[data-reveal]');

  containers.forEach((container) => {
    const children = Array.from(container.children);
    if (children.length <= 1) return;

    gsap.fromTo(
      children,
      { y: 12, opacity: 1 },
      {
        y: 0,
        opacity: 1,
        duration: 0.45,
        stagger: 0.08,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: container,
          start: 'top 85%',
          toggleActions: 'play none none none',
        },
      }
    );
  });
}

/**
 * 8. Smooth scroll — GSAP-based anchor link scrolling.
 * Intercepts clicks on [data-scroll-to] and internal #hash links.
 */
function initSmoothScroll() {
  // Scroll-to buttons
  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('[data-scroll-to]');
    if (!trigger) {
      // Handle hash links
      const link = e.target.closest('a[href^="#"]');
      if (!link) return;
      const target = document.querySelector(link.getAttribute('href'));
      if (!target) return;
      e.preventDefault();
      gsap.to(window, {
        duration: 0.8,
        scrollTo: { y: target, offsetY: 80 },
        ease: 'power2.inOut',
      });
      return;
    }

    e.preventDefault();
    const target = document.querySelector(trigger.dataset.scrollTo);
    if (!target) return;

    gsap.to(window, {
      duration: 0.8,
      scrollTo: { y: target, offsetY: 80 },
      ease: 'power2.inOut',
    });
  });
}

/**
 * Entrypoint — init semua efek.
 * Hanya load GSAP kalau ada element yang membutuhkan.
 */
export default function initAnimations() {
  const hasReveal = !!document.querySelector('[data-reveal]');
  const hasMagnetic = !!document.querySelector('[data-magnetic]');
  const hasParallax = !!document.querySelector('[data-hero-bg]');
  const hasCounters = !!document.querySelector('[data-counter]');
  const hasTilt = !!document.querySelector('[data-tilt]');
  const hasFaq = !!document.querySelector('[data-faq-item]');

  if (!hasReveal && !hasMagnetic && !hasParallax && !hasCounters && !hasTilt && !hasFaq) return;

  if (hasReveal) {
    initStaggerReveal();
    initScrollReveal();
  }
  if (hasMagnetic) initMagnetic();
  if (hasParallax) initHeroParallax();
  if (hasCounters) initCounters();
  if (hasTilt) initCardTilt();
  if (hasFaq) initFaqAccordion();
  initSmoothScroll();
}
