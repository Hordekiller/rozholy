/**
 * Rozholy Navigation
 */
(function() {
  'use strict';

  const menuToggle = document.querySelector('.menu-toggle');
  const primaryMenu = document.querySelector('.primary-menu');

  if (menuToggle && primaryMenu) {
    menuToggle.addEventListener('click', function() {
      this.classList.toggle('active');
      primaryMenu.classList.toggle('active');
      const expanded = this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true';
      this.setAttribute('aria-expanded', expanded);
    });
  }

  const submenuParents = document.querySelectorAll('.primary-menu .menu-item-has-children');
  submenuParents.forEach(function(item) {
    if (window.innerWidth <= 768) {
      const link = item.querySelector('a');
      if (link) {
        link.addEventListener('click', function(e) {
          const submenu = this.nextElementSibling;
          if (submenu && submenu.classList.contains('sub-menu')) {
            e.preventDefault();
            submenu.classList.toggle('open');
          }
        });
      }
    }
  });

  const header = document.querySelector('.site-header');
  let lastScroll = 0;

  if (header) {
    window.addEventListener('scroll', function() {
      const currentScroll = window.pageYOffset;
      if (currentScroll > 80) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
      lastScroll = currentScroll;
    }, { passive: true });
  }

  const searchToggle = document.querySelector('.header-search-toggle');
  const searchForm = document.querySelector('.header-search-form');
  const searchClose = document.querySelector('.search-close');

  if (searchToggle && searchForm) {
    searchToggle.addEventListener('click', function() {
      searchForm.classList.toggle('active');
      if (searchForm.classList.contains('active')) {
        setTimeout(function() {
          searchForm.querySelector('.search-field').focus();
        }, 100);
      }
    });

    if (searchClose) {
      searchClose.addEventListener('click', function() {
        searchForm.classList.remove('active');
      });
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && searchForm.classList.contains('active')) {
        searchForm.classList.remove('active');
      }
    });
  }

  const revealElements = document.querySelectorAll('.reveal');
  if (revealElements.length > 0 && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });

    revealElements.forEach(function(el) {
      observer.observe(el);
    });
  }
})();
