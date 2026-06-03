/**
 * Custom cursor follower.
 *
 * Creates a smooth-following dot cursor that reacts to interactive elements.
 * Only active on pointer devices (no touch).
 *
 * Markup injected automatically:
 *   <div class="cursor-dot" aria-hidden="true"></div>
 *
 * Interactive states:
 *   [data-cursor="grow"]   — cursor scales up (links, buttons)
 *   [data-cursor="hide"]   — cursor hides (video, custom cursors)
 *   [data-cursor="invert"] — cursor inverts color
 */

import { gsap } from '../lib/gsap-init.js';
import { isReducedMotion } from '../lib/reduced-motion.js';

let dot = null;
let pos = { x: 0, y: 0 };
let mouse = { x: 0, y: 0 };
let rafId = null;

export function initCursor() {
  // Skip on touch devices or reduced motion
  if (isReducedMotion()) return;
  if (!window.matchMedia('(pointer: fine)').matches) return;
  if (dot) return; // already initialized

  dot = document.createElement('div');
  dot.className = 'cursor-dot';
  dot.setAttribute('aria-hidden', 'true');
  document.body.appendChild(dot);

  // Hide default cursor
  document.documentElement.classList.add('has-custom-cursor');

  document.addEventListener('mousemove', onMouseMove, { passive: true });
  document.addEventListener('mouseenter', onEnterInteractive, true);
  document.addEventListener('mouseleave', onLeaveInteractive, true);

  pos.x = window.innerWidth / 2;
  pos.y = window.innerHeight / 2;
  mouse.x = pos.x;
  mouse.y = pos.y;

  tick();
}

function onMouseMove(e) {
  mouse.x = e.clientX;
  mouse.y = e.clientY;
}

function tick() {
  // Smooth lerp
  pos.x += (mouse.x - pos.x) * 0.15;
  pos.y += (mouse.y - pos.y) * 0.15;

  if (dot) {
    dot.style.transform = `translate3d(${pos.x}px, ${pos.y}px, 0)`;
  }

  rafId = requestAnimationFrame(tick);
}

function onEnterInteractive(e) {
  const target = e.target.closest('[data-cursor]');
  if (!target || !dot) return;

  const type = target.dataset.cursor;
  dot.classList.remove('is-grow', 'is-hide', 'is-invert');

  if (type === 'grow') dot.classList.add('is-grow');
  else if (type === 'hide') dot.classList.add('is-hide');
  else if (type === 'invert') dot.classList.add('is-invert');
}

function onLeaveInteractive(e) {
  const target = e.target.closest('[data-cursor]');
  if (!target || !dot) return;
  dot.classList.remove('is-grow', 'is-hide', 'is-invert');
}

export function destroyCursor() {
  if (rafId) cancelAnimationFrame(rafId);
  if (dot) dot.remove();
  dot = null;
  document.documentElement.classList.remove('has-custom-cursor');
  document.removeEventListener('mousemove', onMouseMove);
}
