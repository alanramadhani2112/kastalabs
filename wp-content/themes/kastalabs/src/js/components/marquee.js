/**
 * Infinite marquee / ticker component.
 *
 * Selector: [data-marquee]
 * Options via attributes:
 *   data-marquee-speed="30"    — pixels per second (default 50)
 *   data-marquee-direction="left" | "right" (default "left")
 *   data-marquee-pause-hover   — pause on hover (presence = true)
 *
 * Structure expected:
 *   <div data-marquee>
 *     <div data-marquee-track>
 *       <span>Item 1</span>
 *       <span>Item 2</span>
 *     </div>
 *   </div>
 *
 * The track is duplicated automatically for seamless loop.
 */

import { gsap } from '../lib/gsap-init.js';
import { isReducedMotion } from '../lib/reduced-motion.js';

export function initMarquee(root = document) {
  const marquees = root.querySelectorAll('[data-marquee]:not([data-marquee-init])');
  if (!marquees.length) return;

  marquees.forEach((container) => {
    container.setAttribute('data-marquee-init', '1');

    const track = container.querySelector('[data-marquee-track]');
    if (!track) return;

    // Duplicate content for seamless loop
    const clone = track.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    container.appendChild(clone);

    if (isReducedMotion()) return;

    const speed = parseFloat(container.dataset.marqueeSpeed || '50');
    const direction = container.dataset.marqueeDirection || 'left';
    const pauseOnHover = container.hasAttribute('data-marquee-pause-hover');

    // Calculate duration based on track width and speed
    const trackWidth = track.scrollWidth;
    const duration = trackWidth / speed;

    const xPercent = direction === 'left' ? -100 : 100;

    const tl = gsap.timeline({ repeat: -1 });
    tl.fromTo(
      [track, clone],
      { xPercent: direction === 'left' ? 0 : -100 },
      { xPercent, duration, ease: 'none' }
    );

    if (pauseOnHover) {
      container.addEventListener('mouseenter', () => tl.pause());
      container.addEventListener('mouseleave', () => tl.resume());
    }
  });
}
