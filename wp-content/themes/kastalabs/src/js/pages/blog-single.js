/**
 * Blog single interactions.
 */

export default function initBlogSingle() {
  const bar = document.querySelector('[data-reading-progress]');
  const article = document.querySelector('[data-reading-article]');

  if (!bar || !article) return;

  function updateProgress() {
    const rect = article.getBoundingClientRect();
    const viewport = window.innerHeight || document.documentElement.clientHeight;
    const total = rect.height - viewport;
    const current = Math.min(Math.max(-rect.top, 0), Math.max(total, 1));
    const progress = total <= 0 ? 1 : current / total;

    bar.style.transform = `scaleX(${progress})`;
  }

  updateProgress();
  window.addEventListener('scroll', updateProgress, { passive: true });
  window.addEventListener('resize', updateProgress);
}
