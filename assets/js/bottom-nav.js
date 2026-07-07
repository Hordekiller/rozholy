(function () {
  'use strict';

  var nav = document.querySelector('.rz-bottom-nav');
  if (!nav) return;

  var lastScroll = 0;
  var ticking = false;
  var threshold = 20;
  var hideOnScroll = nav.dataset.hideOnScroll !== 'off';

  function updateNav() {
    var st = window.scrollY;
    if (st > threshold && st > lastScroll) {
      nav.classList.add('is-hidden');
    } else {
      nav.classList.remove('is-hidden');
    }
    lastScroll = st <= 0 ? 0 : st;
    ticking = false;
  }

  if (hideOnScroll) {
    window.addEventListener('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(updateNav);
        ticking = true;
      }
    }, { passive: true });
  }

  if (window.visualViewport) {
    var initialVH = window.visualViewport.height;
    window.visualViewport.addEventListener('resize', function () {
      var isKeyboardOpen = window.visualViewport.height < initialVH * 0.8;
      nav.classList.toggle('is-hidden', isKeyboardOpen);
    });
  }

  var cartBadge = document.querySelector('.rz-nav-cart-badge');
  if (cartBadge && window.rzCartBadgeUrl) {
    var updateBadge = function () {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', window.rzCartBadgeUrl + '?t=' + Date.now(), true);
      xhr.onload = function () {
        if (xhr.status === 200) {
          try {
            var data = JSON.parse(xhr.responseText);
            if (typeof data.count === 'number') {
              cartBadge.textContent = data.count;
              cartBadge.style.display = data.count > 0 ? 'flex' : 'none';
            }
          } catch (e) {}
        }
      };
      xhr.send();
    };
    document.body.addEventListener('added_to_cart', updateBadge);
    document.addEventListener('wc_fragments_refreshed', updateBadge);
  }
})();
