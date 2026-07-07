document.addEventListener('DOMContentLoaded', function () {
  var addToCartButtons = document.querySelectorAll('.add_to_cart_button, .single_add_to_cart_button');

  addToCartButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      var originalText = this.textContent;

      if (typeof rozholyWoo !== 'undefined') {
        this.textContent = rozholyWoo.i18n.added;
        setTimeout(function () {
          if (originalText) button.textContent = originalText;
        }, 2000);
      }
    });
  });

  var orderBy = document.querySelector('select.orderby');
  if (orderBy) {
    orderBy.addEventListener('change', function () {
      var form = this.closest('form');
      if (form) form.submit();
    });
  }

  if (typeof rozholyWoo !== 'undefined') {
    document.body.addEventListener('wc_fragments_refreshed', function () {
      var countEl = document.getElementById('header-cart-count');
      if (countEl) {
        countEl.textContent = rozholyWoo.cartCount || '0';
      }
    });
  }

  document.querySelectorAll('.products .product').forEach(function (product) {
    var link = product.querySelector('.woocommerce-loop-product__link');
    var title = product.querySelector('.woocommerce-loop-product__title');
    var price = product.querySelector('.price');
    var rating = product.querySelector('.star-rating');
    var button = product.querySelector('.button');

    if (link) {
      var wrap = document.createElement('div');
      wrap.className = 'product-image-wrap';
      while (link.firstChild) wrap.appendChild(link.firstChild);
      link.appendChild(wrap);
    }

    var details = document.createElement('div');
    details.className = 'product-details';

    if (title) details.appendChild(title);
    if (rating) details.appendChild(rating);
    if (price) details.appendChild(price);

    product.appendChild(details);
    if (button) product.appendChild(button);
  });
});
