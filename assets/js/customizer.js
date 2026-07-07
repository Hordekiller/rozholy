(function ($) {
  'use strict';

  /* ── Colors ── */
  var colorSettings = [
    'rozholy_primary_color',
    'rozholy_primary_dark',
    'rozholy_primary_light',
    'rozholy_secondary_color',
    'rozholy_secondary_dark',
    'rozholy_accent_gold',
    'rozholy_accent_light',
    'rozholy_base_bg',
    'rozholy_base_alt',
    'rozholy_dark_color',
    'rozholy_text_color',
    'rozholy_text_light',
    'rozholy_border_color',
    'rozholy_footer_bg',
  ];

  colorSettings.forEach(function (setting) {
    wp.customize(setting, function (value) {
      value.bind(function (newval) {
        var slug = setting.replace('rozholy_', '').replace(/_/g, '-');
        document.documentElement.style.setProperty('--rz-' + slug, newval);
      });
    });
  });

  /* ── Footer text ── */
  wp.customize('rozholy_footer_text', function (value) {
    value.bind(function (newval) {
      $('.footer-copyright').html(newval);
    });
  });

  /* ── Base font size ── */
  wp.customize('rozholy_base_font_size', function (value) {
    value.bind(function (newval) {
      $('html').css('font-size', newval + 'px');
    });
  });

  /* ── Heading weight ── */
  wp.customize('rozholy_heading_weight', function (value) {
    value.bind(function (newval) {
      $('h1, h2, h3, h4, h5, h6, .wp-block-heading').css('font-weight', newval);
    });
  });

  /* ── Button radius ── */
  wp.customize('rozholy_button_radius', function (value) {
    value.bind(function (newval) {
      $('.wp-block-button__link, .wp-element-button, .woocommerce .button').css('border-radius', newval + 'px');
    });
  });

})(jQuery);
