/**
 * Progressive activation for the process and flow sections.
 *
 * As the visitor moves down, stages activate in order and a single
 * hairline fills amber to show position in the sequence.
 *
 * Under prefers-reduced-motion this does nothing: the CSS already shows
 * every stage at full opacity, so the section reads as a plain list.
 */
(function () {
  'use strict';

  var groups = document.querySelectorAll('[data-rc-process]');
  if (!groups.length) { return; }

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (reduced || !('IntersectionObserver' in window)) {
    Array.prototype.forEach.call(groups, function (group) {
      Array.prototype.forEach.call(
        group.querySelectorAll('.rc-step'),
        function (step) { step.classList.add('is-active'); }
      );
      var fill = group.querySelector('.rc-progress__fill');
      if (fill) { fill.style.height = '100%'; }
    });
    return;
  }

  Array.prototype.forEach.call(groups, function (group) {
    var steps = Array.prototype.slice.call(group.querySelectorAll('.rc-step'));
    var fill = group.querySelector('.rc-progress__fill');
    if (!steps.length) { return; }

    var reached = 0;

    function paint() {
      steps.forEach(function (step, i) {
        step.classList.toggle('is-active', i < reached);
      });

      if (fill) {
        fill.style.height = (reached / steps.length) * 100 + '%';
      }
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          var index = steps.indexOf(entry.target) + 1;

          // Same fail-towards-visible rule as the reveal observer: a
          // stage the viewport has already passed counts as reached.
          var passed = entry.isIntersecting || entry.boundingClientRect.top < 0;

          if (passed && index > reached) {
            reached = index;
            paint();
          }
        });
      },
      // Fires as each stage crosses the lower third of the viewport.
      { threshold: 0, rootMargin: '0px 0px -33% 0px' }
    );

    steps.forEach(function (step) { observer.observe(step); });
  });
})();
