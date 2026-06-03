/**
 * Text scramble/decode effect.
 *
 * Characters "decode" from random glyphs to the actual text.
 * Used on eyebrow elements for a techy, premium feel.
 *
 * Usage:
 *   import { scrambleText } from './text-scramble.js';
 *   scrambleText(el, { duration: 1.5 });
 *
 * Or declarative via [data-scramble] attribute (auto-init in home.js).
 */

const CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%&*';

/**
 * @param {HTMLElement} el
 * @param {{ duration?: number, delay?: number, onComplete?: () => void }} opts
 */
export function scrambleText(el, opts = {}) {
  const duration = opts.duration || 1.2;
  const delay = opts.delay || 0;
  const originalText = el.textContent || '';
  const length = originalText.length;

  let frame = 0;
  const totalFrames = Math.round(duration * 60); // ~60fps
  const delayFrames = Math.round(delay * 60);
  let rafId = null;
  let currentFrame = -delayFrames;

  function randomChar() {
    return CHARS[Math.floor(Math.random() * CHARS.length)];
  }

  function update() {
    currentFrame++;

    if (currentFrame < 0) {
      rafId = requestAnimationFrame(update);
      return;
    }

    const progress = Math.min(currentFrame / totalFrames, 1);
    // Ease: chars resolve left-to-right with some randomness
    const resolved = Math.floor(progress * length);

    let output = '';
    for (let i = 0; i < length; i++) {
      if (originalText[i] === ' ') {
        output += ' ';
      } else if (i < resolved) {
        output += originalText[i];
      } else {
        // Random chance to show correct char early
        output += Math.random() > 0.7 ? originalText[i] : randomChar();
      }
    }

    el.textContent = output;

    if (progress < 1) {
      rafId = requestAnimationFrame(update);
    } else {
      el.textContent = originalText;
      if (opts.onComplete) opts.onComplete();
    }
  }

  rafId = requestAnimationFrame(update);

  return {
    kill() {
      if (rafId) cancelAnimationFrame(rafId);
      el.textContent = originalText;
    },
  };
}
