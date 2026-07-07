(function () {
  /* ── Tab switching in activity ── */
  const tabBtns = document.querySelectorAll('.dashboard-tabs__btn');
  tabBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      const tab = btn.dataset.tab;
      const parent = btn.closest('.dashboard-tabs');

      parent.querySelectorAll('.dashboard-tabs__btn').forEach(function (b) {
        b.classList.remove('active');
      });
      btn.classList.add('active');

      parent.querySelectorAll('.dashboard-tabs__panel').forEach(function (p) {
        p.classList.remove('active');
      });

      var panel = document.getElementById('tab-' + tab);
      if (panel) {
        panel.classList.add('active');
      }
    });
  });

  /* ── Load more activity ── */
  const loadMoreBtns = document.querySelectorAll('.dashboard-load-more');
  loadMoreBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var type = btn.dataset.type;
      var page = parseInt(btn.dataset.page, 10) + 1;
      var panel = btn.closest('.dashboard-tabs__panel');

      btn.textContent = 'در حال بارگذاری...';
      btn.disabled = true;

      var formData = new FormData();
      formData.append('action', 'rozholy_load_activity');
      formData.append('nonce', rozholyDashboard.nonce);
      formData.append('type', type);
      formData.append('page', page);

      fetch(rozholyDashboard.ajaxUrl, {
        method: 'POST',
        body: formData,
      })
        .then(function (r) {
          return r.json();
        })
        .then(function (data) {
          if (data.success && data.data.html) {
            var temp = document.createElement('div');
            temp.innerHTML = data.data.html;
            panel.insertBefore(temp.firstElementChild, btn);

            btn.dataset.page = data.data.page;
            btn.textContent = 'بیشتر';
            btn.disabled = false;
          } else {
            btn.textContent = 'مورد دیگری نیست';
            btn.disabled = true;
          }
        })
        .catch(function () {
          btn.textContent = 'خطا در بارگذاری';
          btn.disabled = false;
        });
    });
  });
})();
