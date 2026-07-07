(function ($) {
  'use strict';

  wp.customize('rozholy_primary_color', function (value) {
    value.bind(function (newval) {
      $(':root').css('--rozholy-primary', newval);
    });
  });

  wp.customize('rozholy_secondary_color', function (value) {
    value.bind(function (newval) {
      $(':root').css('--rozholy-secondary', newval);
    });
  });

  wp.customize('rozholy_footer_text', function (value) {
    value.bind(function (newval) {
      $('.footer-copyright').html(newval);
    });
  });
})(jQuery);
