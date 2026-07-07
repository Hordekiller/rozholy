(function () {
  const toggle = document.querySelector(
    '.wp-block-navigation__responsive-container-open'
  );
  const close = document.querySelector(
    '.wp-block-navigation__responsive-container-close'
  );
  const overlay = document.querySelector(
    '.wp-block-navigation__responsive-container'
  );

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
})();
