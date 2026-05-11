# Implementation spec — custom theme lightbox gallery

This file is intended for the agent working inside the WordPress theme.

## Goal
Enhance imported article galleries with:
- responsive thumbnail grid
- click-to-open lightbox
- previous/next carousel navigation
- graceful fallback to raw media links when JS is unavailable

## Imported markup to target

```html
<section class="ittm-lightbox-gallery" data-ittm-gallery="post-slug" aria-label="Galleria immagini: Article title">
  <figure class="ittm-lightbox-gallery__item">
    <a href="https://example.com/wp-content/uploads/.../image-1.webp"
       class="ittm-lightbox-gallery__link"
       data-ittm-lightbox-trigger
       data-ittm-gallery-index="1">
      <img src="https://example.com/wp-content/uploads/.../image-1.webp"
           alt="Article title"
           class="ittm-lightbox-gallery__image wp-image-123">
    </a>
  </figure>
</section>
```

## Expected behavior
- Clicking a gallery image opens a modal overlay.
- The clicked image is the first one shown.
- Prev/next controls cycle through images in the same gallery.
- `Esc` closes the modal.
- Clicking the backdrop closes the modal.
- Arrow keys navigate between images.
- Focus returns to the clicked thumbnail when the modal closes.
- If JS is disabled, normal anchor navigation still opens the image URL.

## Recommended theme files
Adjust names/paths to your theme conventions.

- `assets/js/ittm-lightbox-gallery.js`
- `assets/css/ittm-lightbox-gallery.css`
- theme enqueue location, e.g. `functions.php` or `inc/enqueue.php`

## Suggested enqueue strategy
Load assets only on singular pages where post content is rendered.

### Example PHP enqueue snippet
```php
add_action('wp_enqueue_scripts', function () {
    if (!is_singular()) {
        return;
    }

    wp_enqueue_style(
        'ittm-lightbox-gallery',
        get_stylesheet_directory_uri() . '/assets/css/ittm-lightbox-gallery.css',
        array(),
        '1.0.0'
    );

    wp_enqueue_script(
        'ittm-lightbox-gallery',
        get_stylesheet_directory_uri() . '/assets/js/ittm-lightbox-gallery.js',
        array(),
        '1.0.0',
        true
    );
});
```

If your theme has a build pipeline, integrate these files there instead.

---

## JS implementation outline
A small custom implementation is enough; no dependency is required.

### Responsibilities
1. Find every `.ittm-lightbox-gallery`
2. Build an array of links/images for each gallery
3. Intercept click on `.ittm-lightbox-gallery__link`
4. Open one shared modal component
5. Render clicked image and navigate within current gallery

### Suggested DOM for the modal
The script can create this once and append it to `document.body`:

```html
<div class="ittm-lightbox" hidden>
  <div class="ittm-lightbox__backdrop" data-ittm-close></div>
  <div class="ittm-lightbox__dialog" role="dialog" aria-modal="true" aria-label="Galleria immagini">
    <button type="button" class="ittm-lightbox__close" aria-label="Chiudi" data-ittm-close>×</button>
    <button type="button" class="ittm-lightbox__prev" aria-label="Immagine precedente">‹</button>
    <figure class="ittm-lightbox__figure">
      <img class="ittm-lightbox__image" alt="" />
      <figcaption class="ittm-lightbox__caption"></figcaption>
    </figure>
    <button type="button" class="ittm-lightbox__next" aria-label="Immagine successiva">›</button>
    <div class="ittm-lightbox__counter" aria-live="polite"></div>
  </div>
</div>
```

### Suggested JS data model
For each gallery:
```js
{
  id: 'post-slug',
  items: [
    { href: '...', alt: '...', caption: '' },
    { href: '...', alt: '...', caption: '' }
  ]
}
```

### Suggested JS algorithm
1. Query:
   - `document.querySelectorAll('.ittm-lightbox-gallery')`
2. For each gallery:
   - read `data-ittm-gallery`
   - collect `.ittm-lightbox-gallery__link`
   - map each link to `{ href, alt }`
3. Add click listener to each link:
   - `event.preventDefault()`
   - open modal with current gallery and clicked index
4. In modal state keep:
   - `activeGallery`
   - `activeIndex`
   - `lastTrigger`
5. `render()` updates:
   - modal image `src`
   - modal image `alt`
   - counter text like `2 / 7`
   - disabled/loop state if desired
6. Keyboard:
   - `Escape` => close
   - `ArrowLeft` => prev
   - `ArrowRight` => next
7. On close:
   - hide modal
   - clear body scroll lock
   - return focus to `lastTrigger`

### Suggested JS implementation skeleton
```js
(function () {
  const galleryEls = document.querySelectorAll('.ittm-lightbox-gallery');
  if (!galleryEls.length) return;

  const galleries = Array.from(galleryEls).map((galleryEl) => {
    const links = Array.from(galleryEl.querySelectorAll('.ittm-lightbox-gallery__link'));
    return {
      el: galleryEl,
      id: galleryEl.getAttribute('data-ittm-gallery') || '',
      links,
      items: links.map((link) => {
        const img = link.querySelector('img');
        return {
          href: link.getAttribute('href') || '',
          alt: img ? (img.getAttribute('alt') || '') : '',
        };
      }),
    };
  });

  const modal = createModal();
  let activeGallery = null;
  let activeIndex = 0;
  let lastTrigger = null;

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
  }

  function prev() {
    if (!activeGallery) return;
    activeIndex = (activeIndex - 1 + activeGallery.items.length) % activeGallery.items.length;
    render();
  }

  function next() {
    if (!activeGallery) return;
    activeIndex = (activeIndex + 1) % activeGallery.items.length;
    render();
  }

  function render() {
    if (!activeGallery) return;
    const item = activeGallery.items[activeIndex];
    modal.image.src = item.href;
    modal.image.alt = item.alt;
    modal.counter.textContent = `${activeIndex + 1} / ${activeGallery.items.length}`;
    modal.caption.textContent = item.alt || '';
  }

  galleries.forEach((gallery) => {
    gallery.links.forEach((link, index) => {
      link.addEventListener('click', (event) => {
        event.preventDefault();
        open(gallery, index, link);
      });
    });
  });

  modal.closeBtn.addEventListener('click', close);
  modal.backdrop.addEventListener('click', close);
  modal.prevBtn.addEventListener('click', prev);
  modal.nextBtn.addEventListener('click', next);

  document.addEventListener('keydown', (event) => {
    if (modal.root.hidden) return;
    if (event.key === 'Escape') close();
    if (event.key === 'ArrowLeft') prev();
    if (event.key === 'ArrowRight') next();
  });

  function createModal() {
    const root = document.createElement('div');
    root.className = 'ittm-lightbox';
    root.hidden = true;
    root.innerHTML = `
      <div class="ittm-lightbox__backdrop" data-ittm-close></div>
      <div class="ittm-lightbox__dialog" role="dialog" aria-modal="true" aria-label="Galleria immagini">
        <button type="button" class="ittm-lightbox__close" aria-label="Chiudi">×</button>
        <button type="button" class="ittm-lightbox__prev" aria-label="Immagine precedente">‹</button>
        <figure class="ittm-lightbox__figure">
          <img class="ittm-lightbox__image" alt="" />
          <figcaption class="ittm-lightbox__caption"></figcaption>
        </figure>
        <button type="button" class="ittm-lightbox__next" aria-label="Immagine successiva">›</button>
        <div class="ittm-lightbox__counter" aria-live="polite"></div>
      </div>
    `;

    document.body.appendChild(root);

    return {
      root,
      backdrop: root.querySelector('.ittm-lightbox__backdrop'),
      closeBtn: root.querySelector('.ittm-lightbox__close'),
      prevBtn: root.querySelector('.ittm-lightbox__prev'),
      nextBtn: root.querySelector('.ittm-lightbox__next'),
      image: root.querySelector('.ittm-lightbox__image'),
      caption: root.querySelector('.ittm-lightbox__caption'),
      counter: root.querySelector('.ittm-lightbox__counter'),
    };
  }
})();
```

---

## CSS implementation outline

### Gallery grid selectors
- `.ittm-lightbox-gallery`
- `.ittm-lightbox-gallery__item`
- `.ittm-lightbox-gallery__link`
- `.ittm-lightbox-gallery__image`

### Modal selectors
- `.ittm-lightbox`
- `.ittm-lightbox__backdrop`
- `.ittm-lightbox__dialog`
- `.ittm-lightbox__figure`
- `.ittm-lightbox__image`
- `.ittm-lightbox__caption`
- `.ittm-lightbox__counter`
- `.ittm-lightbox__close`
- `.ittm-lightbox__prev`
- `.ittm-lightbox__next`
- `body.ittm-lightbox-open`

### Suggested CSS starter
```css
.ittm-lightbox-gallery {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 1rem;
  margin: 2rem 0;
}

@media (min-width: 768px) {
  .ittm-lightbox-gallery {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }
}

.ittm-lightbox-gallery__item {
  margin: 0;
}

.ittm-lightbox-gallery__link {
  display: block;
  text-decoration: none;
}

.ittm-lightbox-gallery__image {
  display: block;
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: 8px;
}

body.ittm-lightbox-open {
  overflow: hidden;
}

.ittm-lightbox {
  position: fixed;
  inset: 0;
  z-index: 9999;
}

.ittm-lightbox__backdrop {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.82);
}

.ittm-lightbox__dialog {
  position: relative;
  z-index: 1;
  height: 100%;
  display: grid;
  grid-template-columns: auto minmax(0, 1fr) auto;
  align-items: center;
  gap: 1rem;
  padding: 2rem;
}

.ittm-lightbox__figure {
  margin: 0;
  text-align: center;
}

.ittm-lightbox__image {
  max-width: 100%;
  max-height: 80vh;
  width: auto;
  height: auto;
}

.ittm-lightbox__caption,
.ittm-lightbox__counter {
  color: #fff;
  margin-top: 0.75rem;
}

.ittm-lightbox__close,
.ittm-lightbox__prev,
.ittm-lightbox__next {
  appearance: none;
  border: 0;
  background: rgba(255, 255, 255, 0.12);
  color: #fff;
  cursor: pointer;
  border-radius: 999px;
}

.ittm-lightbox__close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  width: 44px;
  height: 44px;
}

.ittm-lightbox__prev,
.ittm-lightbox__next {
  width: 48px;
  height: 48px;
}
```

---

## Edge cases to handle
- Gallery with only 1 image:
  - still open modal
  - prev/next may be hidden or disabled
- Missing `href`:
  - skip that image in JS dataset
- Multiple galleries on one page:
  - navigation must stay inside the active gallery
- Lazy-loaded images from theme plugins:
  - read `href` from anchor, not thumbnail `src`

## Acceptance checklist
- [ ] Grid displays correctly in article content
- [ ] Clicking any gallery image opens lightbox
- [ ] Prev/next carousel works
- [ ] Esc closes modal
- [ ] Backdrop click closes modal
- [ ] Focus returns to triggering thumbnail
- [ ] No-JS fallback opens media URL normally
- [ ] Multiple galleries do not mix images

## Optional upgrade path
If the theme already includes a lightbox library such as PhotoSwipe or GLightbox, reuse it instead of custom JS. In that case, only map the imported selectors/attributes to the library initialization.
