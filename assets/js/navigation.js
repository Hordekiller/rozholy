(function () {
  'use strict';

  var header = document.querySelector('.site-header');
  var toggle = document.querySelector('.wp-block-navigation__responsive-container-open');
  var close = document.querySelector('.wp-block-navigation__responsive-container-close');
  var overlay = document.querySelector('.wp-block-navigation__responsive-container');

  /* ── Sticky header shadow on scroll ── */
  var body = document.body;

  function handleScroll() {
    if (!header) return;
    if (body.classList.contains('no-sticky-header')) return;

    if (window.scrollY > 20) {
      header.classList.add('is-sticky');
    } else {
      header.classList.remove('is-sticky');
    }
  }

  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll();

  /* ── Mobile menu toggle ── */
  if (!toggle || !overlay) return;

  toggle.addEventListener('click', function () {
    overlay.classList.add('is-menu-open');
    document.body.style.overflow = 'hidden';
  });

  if (close) {
    close.addEventListener('click', function () {
      overlay.classList.remove('is-menu-open');
      document.body.style.overflow = '';
    });
  }

  overlay.addEventListener('click', function (e) {
    if (e.target === overlay) {
      overlay.classList.remove('is-menu-open');
      document.body.style.overflow = '';
    }
  });

  /* ── Close menu on escape ── */
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && overlay.classList.contains('is-menu-open')) {
      overlay.classList.remove('is-menu-open');
      document.body.style.overflow = '';
    }
  });

  /* ── Close menu on anchor link click ── */
  overlay.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      overlay.classList.remove('is-menu-open');
      document.body.style.overflow = '';
    });
  });
})();
