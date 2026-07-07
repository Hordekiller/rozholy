/**
 * Rozholy WooCommerce Customizations
 */
(function($) {
  'use strict';

  $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
    if ($button && $button.length) {
      const originalText = $button.text();
      $button.text(rozholyWoo?.i18n?.added || 'به سبد خرید اضافه شد!');

      setTimeout(function() {
        $button.text(originalText);
      }, 2000);
    }
  });

  $(document).on('change', 'select.orderby', function() {
    $(this).closest('form').trigger('submit');
  });

  if (typeof rozholyWoo !== 'undefined') {
    $(document.body).on('wc_fragments_refreshed', function() {
      const count = rozholyWoo?.cartCount || 0;
      $('#header-cart-count').text(count);
    });
  }

  $('.products .product').each(function() {
    const $product = $(this);
    const $link = $product.find('.woocommerce-loop-product__link');
    const $title = $product.find('.woocommerce-loop-product__title');
    const $price = $product.find('.price');
    const $rating = $product.find('.star-rating');
    const $button = $product.find('.button');

    $link.wrapInner('<div class="product-image-wrap"></div>');

    const $details = $('<div class="product-details"></div>');
    if ($title.length) $details.append($title.detach());
    if ($rating.length) $details.append($rating.detach());
    if ($price.length) $details.append($price.detach());

    $product.append($details);
    if ($button.length) $product.append($button);
  });

})(jQuery);
