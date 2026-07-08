(function () {
  'use strict';

  var body = document.body;
  var desktopHeader = document.getElementById('rz-masthead');
  var fseHeader = document.querySelector('.wp-block-group.site-header');

  /* ── Sticky header shadow on scroll ── */
  function handleScroll() {
    if (body.classList.contains('no-sticky-header')) return;
    var scrolled = window.scrollY > 20;
    if (desktopHeader) {
      desktopHeader.classList.toggle('is-scrolled', scrolled);
    }
    if (fseHeader) {
      fseHeader.classList.toggle('is-scrolled', scrolled);
    }
  }
  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll();

  /* ── Focus Trap ── */
  function trapFocus(container) {
    var focusable = container.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])');
    if (!focusable.length) return function () {};
    var first = focusable[0];
    var last = focusable[focusable.length - 1];

    function handler(e) {
      if (e.key !== 'Tab') return;
      if (e.shiftKey) {
        if (document.activeElement === first) {
          e.preventDefault();
          last.focus();
        }
      } else {
        if (document.activeElement === last) {
          e.preventDefault();
          first.focus();
        }
      }
    }
    container.addEventListener('keydown', handler);
    return function () { container.removeEventListener('keydown', handler); };
  }

  /* ── Mobile Drawer ── */
  var mhHamburger = document.getElementById('rz-mh-hamburger');
  var mhDrawer = document.getElementById('rz-mh-drawer');
  var mhOverlay = document.getElementById('rz-mh-overlay');
  var mhClose = document.getElementById('rz-mh-drawer-close');
  var removeMhTrap = null;

  if (mhHamburger && mhDrawer && mhOverlay) {
    function openMhDrawer() {
      mhDrawer.classList.add('is-open');
      mhOverlay.classList.add('is-visible');
      mhHamburger.classList.add('is-active');
      body.classList.add('rz-mh-drawer-open');
      mhDrawer.setAttribute('aria-hidden', 'false');
      mhHamburger.setAttribute('aria-expanded', 'true');
      if (removeMhTrap) removeMhTrap();
      removeMhTrap = trapFocus(mhDrawer);
      var first = mhDrawer.querySelector('a[href], button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])');
      if (first) first.focus();
    }

    function closeMhDrawer() {
      mhDrawer.classList.remove('is-open');
      mhOverlay.classList.remove('is-visible');
      mhHamburger.classList.remove('is-active');
      body.classList.remove('rz-mh-drawer-open');
      mhDrawer.setAttribute('aria-hidden', 'true');
      mhHamburger.setAttribute('aria-expanded', 'false');
      if (removeMhTrap) {
        removeMhTrap();
        removeMhTrap = null;
      }
      mhHamburger.focus();
    }

    mhHamburger.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      if (mhDrawer.classList.contains('is-open')) {
        closeMhDrawer();
      } else {
        openMhDrawer();
      }
    });

    mhOverlay.addEventListener('click', closeMhDrawer);

    if (mhClose) {
      mhClose.addEventListener('click', function (e) {
        e.preventDefault();
        closeMhDrawer();
      });
    }

    /* ── Close on Escape ── */
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && mhDrawer.classList.contains('is-open')) {
        closeMhDrawer();
      }
    });

    /* ── Close on link click ── */
    mhDrawer.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', closeMhDrawer);
    });

    /* ── Sub-menu toggle buttons ── */
    mhDrawer.querySelectorAll('.menu-item-has-children > a').forEach(function (link) {
      var parent = link.parentElement;
      var sub = parent.querySelector('.sub-menu');
      if (!sub) return;
      var toggle = document.createElement('button');
      toggle.className = 'rz-mh-sub-toggle';
      toggle.setAttribute('aria-label', 'Toggle submenu');
      toggle.setAttribute('type', 'button');
      toggle.innerHTML = '<svg viewBox="0 0 24 24" width="16" height="16"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z" fill="currentColor"/></svg>';
      link.parentNode.insertBefore(toggle, link.nextSibling);
      toggle.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        parent.classList.toggle('sub-open');
        toggle.classList.toggle('is-open');
      });
    });
  }

  /* ── Search overlay ── */
  var searchToggle = document.getElementById('rz-search-toggle');
  var searchOverlay = document.getElementById('rz-search-overlay');
  var searchClose = document.getElementById('rz-search-overlay-close');

  if (searchToggle && searchOverlay) {
    function openSearch() {
      searchOverlay.classList.add('is-open');
      body.classList.add('rz-drawer-open');
      var field = searchOverlay.querySelector('.rz-search-field');
      setTimeout(function () { if (field) field.focus(); }, 100);
    }

    function closeSearch() {
      searchOverlay.classList.remove('is-open');
      body.classList.remove('rz-drawer-open');
      searchToggle.focus();
    }

    searchToggle.addEventListener('click', function (e) {
      e.preventDefault();
      openSearch();
    });

    if (searchClose) {
      searchClose.addEventListener('click', function (e) {
        e.preventDefault();
        closeSearch();
      });
    }

    searchOverlay.addEventListener('click', function (e) {
      if (e.target === searchOverlay) closeSearch();
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && searchOverlay.classList.contains('is-open')) {
        closeSearch();
      }
    });
  }

  /* ── WooCommerce cart count update ── */
  document.body.addEventListener('added_to_cart', function () {
    var badges = document.querySelectorAll('.rz-cart-count, .rz-mh-cart-count, .rz-nav-cart-badge');
    var xhr = new XMLHttpRequest();
    xhr.open('GET', window.rzCartBadgeUrl + '?t=' + Date.now(), true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        try {
          var data = JSON.parse(xhr.responseText);
          if (typeof data.count === 'number') {
            badges.forEach(function (el) {
              el.textContent = data.count;
              el.style.display = data.count > 0 ? 'flex' : 'none';
            });
          }
        } catch (e) {}
      }
    };
    xhr.send();
  });

  /* ── Add has-bottom-nav class to body ── */
  if (document.querySelector('.rz-bottom-nav')) {
    body.classList.add('has-bottom-nav');
  }
})();
