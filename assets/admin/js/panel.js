(function () {
  'use strict';

  /* ── Tab persistence via sessionStorage ── */
  var storageKey = 'rozholy_active_tab';
  var tabs = document.querySelectorAll('.nav-tab-wrapper a');
  var activeTab = sessionStorage.getItem(storageKey);

  if (activeTab) {
    var currentParams = new URLSearchParams(window.location.search);
    var currentTab = currentParams.get('tab') || 'colors';

    if (currentTab !== activeTab) {
      tabs.forEach(function (tab) {
        if (tab.getAttribute('href').indexOf('tab=' + activeTab) !== -1) {
          document.location.href = tab.href;
        }
      });
    }
  }

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      var params = new URLSearchParams(this.href.split('?')[1] || '');
      var tabName = params.get('tab');
      if (tabName) sessionStorage.setItem(storageKey, tabName);
    });
  });

  /* ── Unsaved-changes guard ── */
  var form = document.querySelector('.rozholy-panel-wrap form');
  if (form) {
    var formDirty = false;
    var formElements = form.querySelectorAll('input, select, textarea');
    var initialValues = {};

    formElements.forEach(function (el) {
      if (el.type === 'hidden') return;
      if (el.name && el.name.indexOf('rozholy_options') === -1) return;
      initialValues[el.name + '_' + (el.type === 'checkbox' ? el.checked : el.value)] = true;
    });

    form.addEventListener('change', function () {
      formDirty = true;
    });

    form.addEventListener('input', function () {
      formDirty = true;
    });

    form.addEventListener('submit', function () {
      formDirty = false;
    });

    window.addEventListener('beforeunload', function (e) {
      if (!formDirty) return;
      e.preventDefault();
      e.returnValue = '';
    });
  }

  /* ── Color picker init ── */
  if (typeof jQuery !== 'undefined' && jQuery.fn.wpColorPicker) {
    jQuery('.rozholy-color-picker').wpColorPicker();
  }

  /* ── Image upload ── */
  var mediaFrame;
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.rozholy-upload-image');
    if (!btn) return;

    e.preventDefault();
    var input = document.getElementById(btn.getAttribute('data-target'));
    var preview = document.getElementById(btn.getAttribute('data-preview'));
    if (!input) return;

    if (mediaFrame) mediaFrame.open();
    else {
      mediaFrame = wp.media({
        title: btn.getAttribute('data-title') || 'Select Image',
        button: { text: btn.getAttribute('data-button') || 'Use Image' },
        multiple: false,
        library: { type: 'image' }
      });

      mediaFrame.on('select', function () {
        var attachment = mediaFrame.state().get('selection').first().toJSON();
        input.value = attachment.id;
        if (preview) {
          preview.innerHTML = '<img src="' + attachment.sizes.thumbnail.url + '" alt="">';
        }
      });

      mediaFrame.open();
    }
  });

  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.rozholy-remove-image');
    if (!btn) return;
    e.preventDefault();
    var input = document.getElementById(btn.getAttribute('data-target'));
    var preview = document.getElementById(btn.getAttribute('data-preview'));
    if (input) input.value = '';
    if (preview) preview.innerHTML = '';
  });
})();
