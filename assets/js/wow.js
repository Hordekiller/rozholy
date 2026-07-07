(function () {
  'use strict';

  var isReduced = window.matchMedia('(prefers-reduced-motion: no-preference)');
  if (!isReduced.matches) return;

  var motionClass = document.body.className.match(/motion-(\w+)/);
  if (motionClass && motionClass[1] === 'off') return;

  /* ═════════════════════════════════
     data-reveal — ONE IntersectionObserver
     ═════════════════════════════════ */
  var revealEls = document.querySelectorAll('[data-reveal]');
  if (revealEls.length) {
    var revealObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
    );

    revealEls.forEach(function (el) {
      revealObserver.observe(el);
    });
  }

  /* ═════════════════════════════════
     Pointer 3D tilt on cards (desktop only)
     ═════════════════════════════════ */
  var isFinePointer = window.matchMedia('(pointer: fine)').matches;
  if (isFinePointer) {
    var tiltCards = document.querySelectorAll('[data-tilt]');
    tiltCards.forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        var rect = card.getBoundingClientRect();
        var x = e.clientX - rect.left;
        var y = e.clientY - rect.top;
        var centerX = rect.width / 2;
        var centerY = rect.height / 2;
        var rotateX = ((y - centerY) / centerY) * -6;
        var rotateY = ((x - centerX) / centerX) * 6;

        var target = card.querySelector('[data-tilt-target]') || card;
        target.style.transform =
          'perspective(800px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) scale3d(1.02, 1.02, 1.02)';
      });

      card.addEventListener('mouseleave', function () {
        var target = card.querySelector('[data-tilt-target]') || card;
        target.style.transform = '';
      });
    });

    /* ── Glare layer ── */
    tiltCards.forEach(function (card) {
      var glare = document.createElement('div');
      glare.className = 'tilt-glare';
      glare.style.cssText =
        'position:absolute;inset:0;pointer-events:none;z-index:2;border-radius:inherit;opacity:0;transition:opacity 0.3s;background:radial-gradient(circle at 50% 50%, rgba(255,255,255,0.15), transparent 70%)';
      card.style.position = 'relative';
      card.appendChild(glare);

      card.addEventListener('mousemove', function (e) {
        var rect = card.getBoundingClientRect();
        var x = ((e.clientX - rect.left) / rect.width) * 100;
        var y = ((e.clientY - rect.top) / rect.height) * 100;
        glare.style.background =
          'radial-gradient(circle at ' + x + '% ' + y + '%, rgba(255,255,255,0.18), transparent 70%)';
        glare.style.opacity = '1';
      });

      card.addEventListener('mouseleave', function () {
        glare.style.opacity = '0';
      });
    });
  }

  /* ═════════════════════════════════
     Glass navbar scroll effect
     ═════════════════════════════════ */
  var nav = document.querySelector('.nav-glass');
  if (nav) {
    var navThreshold = nav.dataset.scrollThreshold || 40;
    var ticking = false;

    window.addEventListener(
      'scroll',
      function () {
        if (!ticking) {
          window.requestAnimationFrame(function () {
            if (window.scrollY > navThreshold) {
              nav.classList.add('is-scrolled');
            } else {
              nav.classList.remove('is-scrolled');
            }
            ticking = false;
          });
          ticking = true;
        }
      },
      { passive: true }
    );
  }

  /* ═════════════════════════════════
     Animated counters
     ═════════════════════════════════ */
  var counters = document.querySelectorAll('[data-counter]');
  if (counters.length) {
    var counterObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            var el = entry.target;
            var target = parseInt(el.dataset.counter, 10);
            var suffix = el.dataset.suffix || '';
            var duration = parseInt(el.dataset.duration, 10) || 1500;
            var startTime = null;

            function animate(timestamp) {
              if (!startTime) startTime = timestamp;
              var progress = Math.min((timestamp - startTime) / duration, 1);
              var eased = 1 - Math.pow(1 - progress, 3);
              var current = Math.floor(eased * target);
              el.textContent = current + suffix;
              if (progress < 1) {
                requestAnimationFrame(animate);
              } else {
                el.textContent = target + suffix;
              }
            }

            requestAnimationFrame(animate);
            counterObserver.unobserve(el);
          }
        });
      },
      { threshold: 0.5 }
    );

    counters.forEach(function (el) {
      counterObserver.observe(el);
    });
  }

  /* ═════════════════════════════════
     Magnetic buttons (desktop only)
     ═════════════════════════════════ */
  if (isFinePointer) {
    var magneticBtns = document.querySelectorAll('[data-magnetic]');
    magneticBtns.forEach(function (btn) {
      btn.addEventListener('mousemove', function (e) {
        var rect = btn.getBoundingClientRect();
        var x = e.clientX - rect.left - rect.width / 2;
        var y = e.clientY - rect.top - rect.height / 2;
        var strength = parseFloat(btn.dataset.magnetic) || 0.3;
        btn.style.transform =
          'translate(' + x * strength + 'px, ' + y * strength + 'px)';
      });

      btn.addEventListener('mouseleave', function () {
        btn.style.transform = '';
      });
    });
  }
})();
