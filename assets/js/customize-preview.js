(function ($) {
  'use strict';

  if (typeof wp === 'undefined' || !wp.customize) return;

  /* ── Color custom properties ── */
  var colorOpts = [
    'primary_color', 'primary_dark', 'primary_light',
    'secondary_color', 'secondary_dark',
    'accent_gold', 'accent_light',
    'base_bg', 'base_alt',
    'dark_color', 'text_color', 'text_light', 'border_color',
    'footer_bg'
  ];

  colorOpts.forEach(function (opt) {
    wp.customize('rozholy_options[' + opt + ']', function (value) {
      value.bind(function (to) {
        var prop = '--rz-' + opt.replace(/_/g, '-');
        document.documentElement.style.setProperty(prop, to);
      });
    });
  });

  /* ── Font options ── */
  wp.customize('rozholy_options[heading_font]', function (value) {
    value.bind(function (to) {
      document.documentElement.style.setProperty('--rz-heading-font', 'var(--rz-font-' + to + ')');
    });
  });

  wp.customize('rozholy_options[body_font]', function (value) {
    value.bind(function (to) {
      document.documentElement.style.setProperty('--rz-body-font', 'var(--rz-font-' + to + ')');
    });
  });

  /* ── Base font size ── */
  wp.customize('rozholy_options[base_font_size]', function (value) {
    value.bind(function (to) {
      document.documentElement.style.setProperty('--rz-base-font-size', to + 'px');
    });
  });

  /* ── Header sticky ── */
  wp.customize('rozholy_options[sticky_header]', function (value) {
    value.bind(function (to) {
      var body = document.body;
      if (to === 'off') body.classList.add('no-sticky-header');
      else body.classList.remove('no-sticky-header');
    });
  });

  /* ── Motion intensity ── */
  wp.customize('rozholy_options[motion_intensity]', function (value) {
    value.bind(function (to) {
      var body = document.body;
      ['full', 'subtle', 'off'].forEach(function (level) {
        body.classList.remove('motion-' + level);
      });
      if (to !== 'full') body.classList.add('motion-' + to);
    });
  });

  /* ── Parallax ── */
  wp.customize('rozholy_options[parallax]', function (value) {
    value.bind(function (to) {
      document.body.classList.toggle('parallax-off', to === 'off');
    });
  });

})(jQuery);
