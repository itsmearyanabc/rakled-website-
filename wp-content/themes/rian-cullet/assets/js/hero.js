/**
 * Hero rotation.
 *
 * Advances the photography and the tagline together, using two
 * deliberately different motions: the image cross-dissolves while the
 * tagline leaves upward and the next one rises in, line by line.
 *
 * Accessibility rules this file obeys:
 *
 *   - Under prefers-reduced-motion the timer never starts. The hero is
 *     slide one, held. The controls still work for manual changes.
 *   - WCAG 2.2.2 requires a way to stop content that moves on its own
 *     for longer than five seconds, so the pause control is part of the
 *     component rather than an extra.
 *   - Only the active tagline is exposed to assistive technology; the
 *     rest are aria-hidden, so the heading reads as one line of text.
 *   - Rotation stops while the tab is hidden and while the user is
 *     interacting with the controls.
 */
(function () {
  'use strict';

  var hero = document.querySelector('[data-rc-hero]');
  if (!hero) { return; }

  var slides = Array.prototype.slice.call(hero.querySelectorAll('[data-rc-slide]'));
  var taglines = Array.prototype.slice.call(hero.querySelectorAll('[data-rc-tagline]'));
  var bars = Array.prototype.slice.call(hero.querySelectorAll('[data-rc-goto]'));
  var toggle = hero.querySelector('[data-rc-hero-toggle]');
  var controls = hero.querySelector('[data-rc-hero-controls]');

  if (slides.length < 2) {
    if (controls) { controls.hidden = true; }
    return;
  }

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
  var HOLD = 6500;
  var LEAVE = 520;

  /*
   * The incoming tagline waits for the outgoing one to clear its mask.
   * Running both at once puts two headlines in the same grid cell and
   * the result is an unreadable overlap, so the change is a handoff:
   * out first, then in.
   *
   * The gap is kept to a beat rather than a pause. Too short and the two
   * headlines smear together; too long and the hero sits headline-less
   * for a noticeable stretch of every cycle.
   */
  var HANDOFF = 420;

  var current = 0;
  var timer = null;
  var handoff = null;
  var paused = false;

  /* --- Bar timer ---------------------------------------------------------- */

  function resetBar(bar, seen) {
    var fill = bar.querySelector('.rc-hero__bar-fill');
    if (!fill) { return; }

    fill.style.transition = 'none';
    fill.style.inlineSize = seen ? '100%' : '0%';
    // Flush the change so the next transition starts from this value.
    void fill.offsetWidth;
  }

  function runBar(bar) {
    var fill = bar.querySelector('.rc-hero__bar-fill');
    if (!fill) { return; }

    resetBar(bar, false);
    fill.style.transition = 'inline-size ' + HOLD + 'ms linear';
    fill.style.inlineSize = '100%';
  }

  function paintBars() {
    bars.forEach(function (bar, i) {
      bar.classList.toggle('is-active', i === current);

      if (i === current) {
        bar.setAttribute('aria-current', 'true');
      } else {
        bar.removeAttribute('aria-current');
      }

      if (i < current) {
        bar.classList.add('is-seen');
        resetBar(bar, true);
      } else if (i > current) {
        bar.classList.remove('is-seen');
        resetBar(bar, false);
      }
    });

    if (!paused && !reduced.matches) {
      runBar(bars[current]);
    } else {
      resetBar(bars[current], false);
    }
  }

  /* --- Transition --------------------------------------------------------- */

  function settle() {
    // Park every tagline that is not current, and hide it from
    // assistive technology, so the heading always reads as one line.
    taglines.forEach(function (tagline, i) {
      tagline.classList.remove('is-leaving');

      if (i === current) {
        tagline.classList.add('is-active');
        tagline.removeAttribute('aria-hidden');
      } else {
        tagline.classList.remove('is-active');
        tagline.setAttribute('aria-hidden', 'true');
      }
    });
  }

  function show(next) {
    if (next === current) { return; }

    // A change already in flight is completed immediately rather than
    // interrupted, so a fast run of clicks cannot strand a tagline
    // halfway out of its mask.
    if (handoff) {
      window.clearTimeout(handoff);
      handoff = null;
      settle();
    }

    var from = taglines[current];

    // The photography cross-dissolves straight away. The tagline does
    // not: it leaves first, and the next one arrives afterwards.
    slides[current].classList.remove('is-active');
    slides[next].classList.add('is-active');

    from.classList.remove('is-active');
    from.classList.add('is-leaving');
    from.setAttribute('aria-hidden', 'true');

    current = next;
    paintBars();

    handoff = window.setTimeout(function () {
      handoff = null;

      // Dropping is-leaving snaps the old lines from above the mask back
      // to below it. Both positions are clipped, so this is never seen.
      settle();
    }, HANDOFF);
  }

  function advance() {
    show((current + 1) % slides.length);
  }

  /* --- Timer -------------------------------------------------------------- */

  function start() {
    if (reduced.matches || paused) { return; }
    stop();
    timer = window.setInterval(advance, HOLD);
    paintBars();
  }

  function stop() {
    if (timer) {
      window.clearInterval(timer);
      timer = null;
    }
  }

  // LEAVE is the CSS duration; HANDOFF must never undercut it by so much
  // that the outgoing lines are still visible when the next ones arrive.
  if (HANDOFF < LEAVE * 0.8) { HANDOFF = Math.round(LEAVE * 0.8); }

  function setPaused(value) {
    paused = value;

    if (toggle) {
      toggle.setAttribute('aria-pressed', paused ? 'true' : 'false');
      var label = toggle.querySelector('.rc-hero__toggle-text');
      if (label) { label.textContent = paused ? 'Play' : 'Pause'; }
    }

    if (paused) {
      stop();
      resetBar(bars[current], false);
    } else {
      start();
    }
  }

  /* --- Wiring ------------------------------------------------------------- */

  if (toggle) {
    toggle.addEventListener('click', function () { setPaused(!paused); });
  }

  bars.forEach(function (bar, i) {
    bar.addEventListener('click', function () {
      show(i);
      // A deliberate choice is respected: restart the clock from here
      // rather than cutting the chosen slide short.
      if (!paused) { start(); }
    });
  });

  // A hidden tab should not be burning frames on a dissolve nobody sees.
  document.addEventListener('visibilitychange', function () {
    if (document.hidden) { stop(); } else if (!paused) { start(); }
  });

  // Honour a change of motion preference without a reload.
  var onPreferenceChange = function () {
    if (reduced.matches) {
      stop();
      resetBar(bars[current], false);
    } else {
      start();
    }
  };

  if (typeof reduced.addEventListener === 'function') {
    reduced.addEventListener('change', onPreferenceChange);
  }

  if (reduced.matches) {
    if (controls) {
      // Manual navigation still works; the timer simply never runs.
      paintBars();
    }
    return;
  }

  // Wait for the hero reveal to finish before the first change.
  window.setTimeout(start, 1200);
})();
