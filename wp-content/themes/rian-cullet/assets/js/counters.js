/**
 * Statistic counters.
 *
 * Counts once, on entry, then stops observing.
 *
 * The final value is rendered in the HTML by PHP, so the correct number
 * is present for search engines, for people with scripting disabled and
 * for anyone who has asked for reduced motion. This script only animates
 * a value that is already there.
 */
(function () {
  'use strict';

  var counters = document.querySelectorAll('[data-rc-count]');
  if (!counters.length) { return; }

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduced || !('IntersectionObserver' in window)) { return; }

  var DURATION = 1400;

  // easeOutExpo, matched to --rc-ease-out so motion feels consistent.
  function ease(t) {
    return t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
  }

  function run(el) {
    var target = parseInt(el.getAttribute('data-rc-count'), 10);
    if (isNaN(target)) { return; }

    var prefix = el.getAttribute('data-rc-prefix') || '';
    var suffix = el.getAttribute('data-rc-suffix') || '';
    var started = null;

    function step(now) {
      if (started === null) { started = now; }

      var progress = Math.min((now - started) / DURATION, 1);
      el.textContent = prefix + Math.round(ease(progress) * target) + suffix;

      if (progress < 1) { window.requestAnimationFrame(step); }
    }

    window.requestAnimationFrame(step);
  }

  var observer = new IntersectionObserver(
    function (entries, obs) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) { return; }
        run(entry.target);
        obs.unobserve(entry.target);
      });
    },
    { threshold: 0.6 }
  );

  Array.prototype.forEach.call(counters, function (el) { observer.observe(el); });
})();
