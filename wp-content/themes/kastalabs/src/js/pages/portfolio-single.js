/**
 * Portfolio single — scroll-driven storytelling.
 *
 * Parallax pada cover image + stagger reveal untuk case study sections.
 * Subtle, architectural motion — bukan heavy animation.
 */

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export default function initPortfolioSingle() {
  initCoverParallax();
  initSectionReveal();
}

/**
 * Cover image parallax — subtle shift on scroll.
 */
function initCoverParallax() {
  const cover = document.querySelector('.zoom-page-hero + figure img');
  if (!cover) return;

  gsap.fromTo(
    cover,
    { y: 0 },
    {
      y: '6%',
      ease: 'none',
      scrollTrigger: {
        trigger: cover.closest('figure'),
        start: 'top 80%',
        end: 'bottom top',
        scrub: 0.5,
      },
    }
  );
}

/**
 * Stagger reveal untuk section headings di prose content.
 */
function initSectionReveal() {
  const sections = document.querySelectorAll('.prose section');
  if (!sections.length) return;

  sections.forEach((section, i) => {
    gsap.fromTo(
      section,
      { y: 16, opacity: 0.92 },
      {
        y: 0,
        opacity: 1,
        duration: 0.45,
        delay: i * 0.06,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: section,
          start: 'top 85%',
          toggleActions: 'play none none none',
        },
      }
    );
  });
}
