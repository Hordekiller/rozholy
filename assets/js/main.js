/**
 * Rozholy Main Script
 */
(function() {
  'use strict';

  function initGallery() {
    const filters = document.querySelectorAll('.rz-gallery-filter');
    const items = document.querySelectorAll('.rz-gallery-item');

    if (!filters.length || !items.length) return;

    filters.forEach(function(btn) {
      btn.addEventListener('click', function() {
        filters.forEach(function(f) { f.classList.remove('active'); });
        this.classList.add('active');

        const filter = this.getAttribute('data-filter');

        items.forEach(function(item) {
          const itemFilter = item.getAttribute('data-filter') || 'all';
          if (filter === 'all' || itemFilter === filter) {
            item.style.display = 'block';
            item.style.animation = 'scaleIn 0.4s ease forwards';
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  }

  function initBookingForm() {
    const form = document.querySelector('.rz-booking-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      formData.append('action', 'rozholy_submit_booking');

      const submitBtn = this.querySelector('[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'در حال ارسال...';
      }

      fetch(rozholyAjax?.ajaxUrl || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData,
      })
      .then(function(response) { return response.json(); })
      .then(function(data) {
        if (data.success) {
          form.style.display = 'none';
          document.querySelector('.rz-booking-success').style.display = 'block';
        } else {
          alert(data.data?.message || 'خطا در ارسال فرم. لطفاً دوباره تلاش کنید.');
        }
      })
      .catch(function() {
        alert('خطا در ارتباط با سرور.');
      })
      .finally(function() {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = form.getAttribute('data-submit-text') || 'ثبت درخواست';
        }
      });
    });
  }

  function addRevealClasses() {
    const cards = document.querySelectorAll('.blog-card, .rz-service-card, .rz-testimonial-card, .rz-gallery-item');
    cards.forEach(function(card, index) {
      if (!card.classList.contains('reveal')) {
        card.classList.add('reveal');
        card.style.transitionDelay = ((index % 4) * 0.1) + 's';
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    initGallery();
    initBookingForm();
    addRevealClasses();
  });
})();
