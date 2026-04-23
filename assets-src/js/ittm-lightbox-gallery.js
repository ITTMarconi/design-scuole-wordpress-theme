/**
 * ITTM Lightbox Gallery
 *
 * Enhances .ittm-lightbox-gallery sections, standalone [data-ittm-lightbox-trigger]
 * links, and WordPress "Link To: Media File" image blocks with a click-to-open modal,
 * prev/next carousel navigation, keyboard controls, and focus management.
 *
 * - Links inside .ittm-lightbox-gallery are grouped by their container's data-ittm-gallery.
 * - Standalone [data-ittm-lightbox-trigger] links outside any gallery merge into
 *   the first gallery's carousel.
 * - WordPress image blocks (a[href] inside figure.wp-block-image) that point to
 *   image files are also intercepted and grouped into a per-post gallery.
 * - When JS is unavailable, anchor links still open image URLs directly.
 */
(function () {
  'use strict';

  var IMAGE_EXTENSIONS = /\.(jpe?g|png|gif|webp|avif|svg|bmp|tiff?)($|[?#])/i;

  function isImageUrl(href) {
    return IMAGE_EXTENSIONS.test(href);
  }

  /* ── Collect all trigger links on the page ─────────────────────── */

  var galleryEls = document.querySelectorAll('.ittm-lightbox-gallery');
  var standaloneTriggers = document.querySelectorAll('[data-ittm-lightbox-trigger]:not(.ittm-lightbox-gallery .ittm-lightbox-gallery__link)');

  // WordPress image blocks: <figure class="wp-block-image ..."><a href="image.webp"><img></a></figure>
  // Also handles unlinked images: <figure class="wp-block-image ..."><img></figure>
  var wpImageLinks = [];
  var wpUnlinkedImages = [];

  Array.prototype.forEach.call(document.querySelectorAll('.wp-block-image'), function (figure) {
    // Skip figures inside our lightbox gallery
    if (figure.closest('.ittm-lightbox-gallery')) return;
    // Skip figures with our explicit trigger
    if (figure.querySelector('[data-ittm-lightbox-trigger]')) return;

    var link = figure.querySelector('a[href]');
    if (link && isImageUrl(link.getAttribute('href'))) {
      // Linked image — use the link as the trigger
      wpImageLinks.push(link);
    } else {
      // Unlinked image — use the img src as the source
      var img = figure.querySelector('img');
      if (img && img.src) {
        wpUnlinkedImages.push(figure);
      }
    }
  });

  if (!galleryEls.length && !standaloneTriggers.length && !wpImageLinks.length && !wpUnlinkedImages.length) return;

  /* ── Build gallery data grouped by data-ittm-gallery ID ────────── */

  var groups = {};

  Array.prototype.forEach.call(galleryEls, function (galleryEl) {
    var id = galleryEl.getAttribute('data-ittm-gallery') || '__default__';
    if (!groups[id]) {
      groups[id] = { items: [], triggers: [], el: galleryEl };
    }
    var links = galleryEl.querySelectorAll('.ittm-lightbox-gallery__link');
    Array.prototype.forEach.call(links, function (link) {
      var href = link.getAttribute('href');
      if (!href) return;

      var img = link.querySelector('img');
      groups[id].items.push({
        href: href,
        alt: img ? (img.getAttribute('alt') || '') : '',
      });
      groups[id].triggers.push(link);
    });
  });

  var standaloneItems = [];
  var standaloneTriggerLinks = [];

  Array.prototype.forEach.call(standaloneTriggers, function (trigger) {
    var href = trigger.getAttribute('href');
    if (!href) return;
    var img = trigger.querySelector('img');

    if (trigger.hasAttribute('data-ittm-gallery')) {
      var groupId = trigger.getAttribute('data-ittm-gallery');
      if (!groups[groupId]) {
        groups[groupId] = { items: [], triggers: [], el: null };
      }
      groups[groupId].items.unshift({
        href: href,
        alt: img ? (img.getAttribute('alt') || '') : '',
      });
      groups[groupId].triggers.unshift(trigger);
    } else {
      standaloneItems.push({
        href: href,
        alt: img ? (img.getAttribute('alt') || '') : '',
      });
      standaloneTriggerLinks.push(trigger);
    }
  });

  // WordPress image blocks: group linked and unlinked images into '__wp_images__'
  var wpItems = [];
  var wpTriggerLinks = [];

  Array.prototype.forEach.call(wpImageLinks, function (link) {
    var href = link.getAttribute('href');
    if (!href || !isImageUrl(href)) return;
    // Skip links already handled by gallery or standalone triggers
    if (link.closest('.ittm-lightbox-gallery')) return;
    if (link.hasAttribute('data-ittm-lightbox-trigger')) return;

    var img = link.querySelector('img');
    wpItems.push({
      href: href,
      alt: img ? (img.getAttribute('alt') || '') : '',
    });
    wpTriggerLinks.push(link);
  });

  // Unlinked images inside .wp-block-image: make them clickable via the <figure>
  Array.prototype.forEach.call(wpUnlinkedImages, function (figure) {
    var img = figure.querySelector('img');
    if (!img || !img.src) return;

    // Try to get the full-size URL from data attributes WordPress adds
    var fullSrc = img.getAttribute('data-full-size') ||
                 img.getAttribute('data-large-file') ||
                 img.getAttribute('data-orig-file') ||
                 img.src;

    // Make the figure clickable and add cursor style
    figure.style.cursor = 'pointer';
    wpItems.push({
      href: fullSrc,
      alt: img.getAttribute('alt') || '',
    });
    wpTriggerLinks.push(figure);
  });

  if (wpItems.length) {
    groups['__wp_images__'] = { items: wpItems, triggers: wpTriggerLinks, el: null };
  }

  if (standaloneItems.length) {
    var keys = Object.keys(groups);
    var targetKey = keys.length ? keys[0] : '__standalone__';
    if (!groups[targetKey]) {
      groups[targetKey] = { items: [], triggers: [], el: null };
    }
    groups[targetKey].items = standaloneItems.concat(groups[targetKey].items);
    groups[targetKey].triggers = standaloneTriggerLinks.concat(groups[targetKey].triggers);
  }

  var galleryList = Object.keys(groups).map(function (key) {
    return {
      id: key,
      items: groups[key].items,
      triggers: groups[key].triggers,
      el: groups[key].el,
    };
  }).filter(function (g) {
    return g.items.length > 0;
  });

  if (!galleryList.length) return;

  /* ── Create shared modal DOM ─────────────────────────────────── */

  function createModal() {
    var root = document.createElement('div');
    root.className = 'ittm-lightbox';
    root.hidden = true;
    root.innerHTML =
      '<div class="ittm-lightbox__backdrop" data-ittm-close></div>' +
      '<div class="ittm-lightbox__dialog" role="dialog" aria-modal="true" aria-label="Galleria immagini">' +
        '<button type="button" class="ittm-lightbox__close" aria-label="Chiudi" data-ittm-close>\u00d7</button>' +
        '<div class="ittm-lightbox__content">' +
          '<button type="button" class="ittm-lightbox__prev" aria-label="Immagine precedente">\u2039</button>' +
          '<figure class="ittm-lightbox__figure">' +
            '<img class="ittm-lightbox__image" alt="" />' +
            '<figcaption class="ittm-lightbox__caption"></figcaption>' +
          '</figure>' +
          '<button type="button" class="ittm-lightbox__next" aria-label="Immagine successiva">\u203a</button>' +
        '</div>' +
        '<div class="ittm-lightbox__counter" aria-live="polite"></div>' +
      '</div>';

    document.body.appendChild(root);

    return {
      root: root,
      backdrop: root.querySelector('.ittm-lightbox__backdrop'),
      closeBtn: root.querySelector('.ittm-lightbox__close'),
      prevBtn: root.querySelector('.ittm-lightbox__prev'),
      nextBtn: root.querySelector('.ittm-lightbox__next'),
      image: root.querySelector('.ittm-lightbox__image'),
      caption: root.querySelector('.ittm-lightbox__caption'),
      counter: root.querySelector('.ittm-lightbox__counter'),
    };
  }

  var modal = createModal();
  var activeGallery = null;
  var activeIndex = 0;
  var lastTrigger = null;

  /* ── Open / close / navigation ───────────────────────────────── */

  function open(gallery, index, trigger) {
    activeGallery = gallery;
    activeIndex = index;
    lastTrigger = trigger;
    document.body.classList.add('ittm-lightbox-open');
    modal.root.hidden = false;
    render();
    modal.closeBtn.focus();
  }

  function close() {
    modal.root.hidden = true;
    document.body.classList.remove('ittm-lightbox-open');
    if (lastTrigger) lastTrigger.focus();
    activeGallery = null;
    activeIndex = 0;
    lastTrigger = null;
  }

  function goTo(index) {
    if (!activeGallery) return;
    activeIndex = index;
    render();
  }

  function prev() {
    if (!activeGallery) return;
    var len = activeGallery.items.length;
    goTo((activeIndex - 1 + len) % len);
  }

  function next() {
    if (!activeGallery) return;
    var len = activeGallery.items.length;
    goTo((activeIndex + 1) % len);
  }

  /* ── Render current item into modal ─────────────────────────── */

  function render() {
    if (!activeGallery) return;
    var item = activeGallery.items[activeIndex];
    modal.image.src = item.href;
    modal.image.alt = item.alt;
    modal.caption.textContent = item.alt || '';
    modal.counter.textContent = (activeIndex + 1) + ' / ' + activeGallery.items.length;

    var hideNav = activeGallery.items.length <= 1;
    if (hideNav) {
      modal.prevBtn.setAttribute('hidden', '');
      modal.nextBtn.setAttribute('hidden', '');
    } else {
      modal.prevBtn.removeAttribute('hidden');
      modal.nextBtn.removeAttribute('hidden');
    }
  }

  /* ── Bind trigger clicks ─────────────────────────────────────── */

  galleryList.forEach(function (gallery) {
    gallery.triggers.forEach(function (trigger, index) {
      trigger.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();
        open(gallery, index, trigger);
      });
    });
  });

  /* ── Modal control event listeners ────────────────────────────── */

  modal.closeBtn.addEventListener('click', close);
  modal.backdrop.addEventListener('click', close);
  modal.prevBtn.addEventListener('click', prev);
  modal.nextBtn.addEventListener('click', next);

  document.addEventListener('keydown', function (event) {
    if (modal.root.hidden) return;
    if (event.key === 'Escape') {
      event.preventDefault();
      close();
    } else if (event.key === 'ArrowLeft') {
      event.preventDefault();
      prev();
    } else if (event.key === 'ArrowRight') {
      event.preventDefault();
      next();
    }
  });
})();