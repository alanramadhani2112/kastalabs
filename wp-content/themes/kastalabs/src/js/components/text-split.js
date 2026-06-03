/**
 * Text splitting utility for GSAP animations.
 *
 * Splits text into chars/words/lines for staggered animations.
 * No external dependency — pure DOM manipulation.
 *
 * Usage:
 *   const split = splitText(el, { type: 'chars' });
 *   gsap.from(split.chars, { y: '100%', stagger: 0.02 });
 *   split.revert(); // restore original HTML
 */

/**
 * @typedef {'chars'|'words'|'lines'} SplitType
 * @typedef {{ chars: HTMLElement[], words: HTMLElement[], lines: HTMLElement[], revert: () => void }} SplitResult
 */

/**
 * @param {HTMLElement} el
 * @param {{ type?: SplitType|SplitType[] }} opts
 * @returns {SplitResult}
 */
export function splitText(el, opts = {}) {
  const types = Array.isArray(opts.type) ? opts.type : [opts.type || 'chars'];
  const originalHTML = el.innerHTML;
  const text = el.textContent || '';

  const result = { chars: [], words: [], lines: [], revert };

  // Split into words first (always needed as base)
  const wordTexts = text.split(/\s+/).filter(Boolean);
  el.innerHTML = '';
  el.setAttribute('aria-label', text);

  const wordEls = wordTexts.map((word, wi) => {
    const wordSpan = document.createElement('span');
    wordSpan.className = 'split-word';
    wordSpan.style.display = 'inline-block';
    wordSpan.style.whiteSpace = 'nowrap';

    if (types.includes('chars')) {
      const chars = word.split('').map((char) => {
        const charSpan = document.createElement('span');
        charSpan.className = 'split-char';
        charSpan.style.display = 'inline-block';
        charSpan.textContent = char;
        charSpan.setAttribute('aria-hidden', 'true');
        result.chars.push(charSpan);
        return charSpan;
      });
      chars.forEach((c) => wordSpan.appendChild(c));
    } else {
      wordSpan.textContent = word;
    }

    wordSpan.setAttribute('aria-hidden', 'true');
    result.words.push(wordSpan);
    return wordSpan;
  });

  // Append words with spaces between
  wordEls.forEach((wordEl, i) => {
    el.appendChild(wordEl);
    if (i < wordEls.length - 1) {
      el.appendChild(document.createTextNode(' '));
    }
  });

  // Line detection (after DOM render)
  if (types.includes('lines')) {
    requestAnimationFrame(() => {
      let currentTop = null;
      let currentLine = null;

      result.words.forEach((wordEl) => {
        const top = wordEl.getBoundingClientRect().top;
        if (currentTop === null || Math.abs(top - currentTop) > 2) {
          currentLine = document.createElement('span');
          currentLine.className = 'split-line';
          currentLine.style.display = 'block';
          currentLine.style.overflow = 'hidden';
          result.lines.push(currentLine);
          currentTop = top;
        }
      });
    });
  }

  function revert() {
    el.innerHTML = originalHTML;
    el.removeAttribute('aria-label');
    result.chars = [];
    result.words = [];
    result.lines = [];
  }

  return result;
}
