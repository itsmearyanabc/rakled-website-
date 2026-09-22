/**
 * Scroll reveals, hero settle and the scroll cue.
 *
 * Reveals are one-shot: each element is unobserved the moment it fires,
 * so nothing re-animates when the visitor scrolls back up.
 *
 * Under prefers-reduced-motion nothing is observed at all. Every element
 * is marked revealed immediately, so the content is complete and static.
 */
(function () {
  'use strict';

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var targets = document.querySelectorAll('.rc-reveal, .rc-line');
  var hero = document.querySelector('.rc-hero');

  function revealAll() {
    Array.prototype.forEach.call(targets, function (el) { el.classList.add('is-revealed'); });
    if (hero) { hero.classList.add('is-ready'); }
  }

  if (reduced || !('IntersectionObserver' in window)) {
    revealAll();
    return;
  }

  /* --- Hero ---------------------------------------------------------------
     The image settles first; the text follows. Waiting for the hero image
     to decode avoids starting the sequence against a blank frame. */

  if (hero) {
    var heroImage = hero.querySelector('img');

    var startHero = function () {
      hero.classList.add('is-ready');
      Array.prototype.forEach.call(
        hero.querySelectorAll('.rc-reveal, .rc-line'),
        function (el) { el.classList.add('is-revealed'); }
      );
    };

    if (!heroImage || heroImage.complete) {
      window.requestAnimationFrame(startHero);
    } else {
      heroImage.addEventListener('load', startHero, { once: true });
      heroImage.addEventListener('error', startHero, { once: true });
      // Never let a stalled image hold the headline hostage.
      window.setTimeout(startHero, 1200);
    }
  }

  /* --- Everything below the fold ------------------------------------------ */

  /*
   * An element is revealed when it enters the viewport OR once it sits
   * above it.
   *
   * The second condition is the important one. Without it, anything the
   * viewport skips past stays invisible forever: a deep anchor link, a
   * restored scroll position on reload, a fast flick on a phone, or a
   * callback the browser coalesces away under rapid scrolling. Content
   * that never appears is far worse than content that appears unanimated,
   * so the observer is written to fail towards visible.
   */
  function shouldReveal(entry) {
    return entry.isIntersecting || entry.boundingClientRect.top < 0;
  }

  var observer = new IntersectionObserver(
    function (entries, obs) {
      entries.forEach(function (entry) {
        if (!shouldReveal(entry)) { return; }
        entry.target.classList.add('is-revealed');
        obs.unobserve(entry.target);
      });
    },
    { threshold: 0.15, rootMargin: '0px 0px -10% 0px' }
  );

  Array.prototype.forEach.call(targets, function (el) {
    if (hero && hero.contains(el)) { return; }
    observer.observe(el);
  });

  /*
   * Final safety net. On a settled scroll, reveal anything still hidden
   * that the viewport has already passed. This costs one pass over a
   * shrinking list and guarantees nothing is ever stranded invisible.
   */
  var sweepTimer = null;

  function sweep() {
    var stranded = document.querySelectorAll('.rc-reveal:not(.is-revealed), .rc-line:not(.is-revealed)');

    Array.prototype.forEach.call(stranded, function (el) {
      if (el.getBoundingClientRect().top < window.innerHeight) {
        el.classList.add('is-revealed');
        observer.unobserve(el);
      }
    });

    if (!stranded.length) {
      window.removeEventListener('scroll', onScrollSweep);
    }
  }

  function onScrollSweep() {
    window.clearTimeout(sweepTimer);
    sweepTimer = window.setTimeout(sweep, 150);
  }

  window.addEventListener('scroll', onScrollSweep, { passive: true });
  window.addEventListener('load', sweep);

  /* --- Scroll cue ---------------------------------------------------------- */

  var cue = document.querySelector('.rc-hero__cue');

  if (cue) {
    window.addEventListener(
      'scroll',
      function () { cue.classList.toggle('is-hidden', window.scrollY > 80); },
      { passive: true }
    );
  }
})();
