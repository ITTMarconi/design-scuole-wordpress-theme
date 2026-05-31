# Inventario Bootstrap Italia (superficie d'uso)

> Fotografia di **cosa** usiamo davvero di Bootstrap Italia, per pianificare la
> riduzione graduale della dipendenza (vedi `adr/0003-ridurre-dipendenza-bootstrap-italia.md`).
> Numeri rilevati il **2026-05-31** via grep sui 259 file PHP del tema (esclusi
> `inc/vendor/`); sono ordini di grandezza, non conteggi esatti.

## 0. Come è caricato — ⚠️ runtime legacy

| | File caricato | Versione reale |
|---|---|---|
| CSS | `assets/css/bootstrap-italia.css` (intero, **non** in `@layer`) | **v1.6.2 — Bootstrap 4** |
| JS | `assets/js/bootstrap-italia.js` (basato su **jQuery**) | BS4 (data-toggle) |

- Il `package.json` dichiara `bootstrap-italia ^2.0.9` (BS5), ma **non corrisponde
  al runtime**: i file effettivamente serviti sono la **v1.6.2 (Bootstrap 4 +
  jQuery)**. La dipendenza reale è quindi **legacy/EOL** — un motivo in più per
  ridurla.
- BI convive con uno **stack jQuery non-BI** importante: jPushMenu,
  perfect-scrollbar, jquery-match-height, sticky-kit, responsive-tabs, fitvids,
  splide, leaflet, scrollTo, ResponsiveDom, vallenato, easing — più `scuole.js`
  (logica propria del tema) e `marconi.js`.

## 0bis. Coverage — usiamo **~6%** del CSS di BI ⭐

Misura sul dev (selector-matching su `document.styleSheets`, pseudo-classi
dinamiche rimosse), unione su 4 tipi di pagina (single circolare, home, ricerca
con modali aperti, page-template "la-scuola"):

| | Valore |
|---|---|
| Regole di stile totali in `bootstrap-italia.css` | **5183** |
| Regole effettivamente usate (unione 4 pagine) | **297** |
| **Percentuale usata** | **~5,7%** (curva in plateau: 207 → 237 → 276 → 297) |

Ripartizione delle ~297 regole usate: componenti ~115, spacing ~45, griglia ~34,
reset/base ~30, display/flex ~18, testo ~15. **È tutta qui** la nostra dipendenza
reale dal CSS di BI.

**Implicazioni:**
- **~94% di BI è peso morto**: ~470 KB serviti per usarne ~6%. Un **purge/tree-shake**
  (build step) ridurrebbe il file a ~30–50 KB **senza cambiare nulla** — vittoria
  di performance immediata e indipendente dal lavoro sui layer.
- **Ridimensiona la fatica**: "sostituire BI" non è una montagna — la superficie
  vera è ~300 regole (griglia + spacing + pochi componenti).
- **Caveat purge**: serve una **safelist** delle classi aggiunte da JS (es.
  `.show`, `.is-active`, `.menu-open`, `.sticked-menu`, `.collapse`/`.collapsing`,
  stati dei modali) che il matching statico non vede. Senza, il purge romperebbe
  l'interattività.
- **Caveat misura**: euristica (match dei selettori, non paint reale); con più
  tipi di pagina e stati la % salirebbe un po', ma resta nettamente **<10%**.

**PoC purge (misurato sul dev):** simulazione PurgeCSS token-based (classi/id del
DOM su 3 pagine + safelist JS) → **413 regole tenute su 5183 (8%)**, **6,6% dei
byte** → stima **459 KB → ~30 KB** (≈ −93%), senza cambiamenti visivi. La safelist
usata: `show, fade, collapse, collapsing, is-active, is-sticky, sticked-menu,
menu-open, modal-open, modal-backdrop, push-body*, dropdown(-menu), focus--mouse,
zoom, utils-moved, …` — da completare e testare per l'implementazione reale.

## 1. Superficie CSS (per magnitudine)

| Area | Occorrenze | Note |
|------|-----------:|------|
| **Griglia** (`container` 449, `row` 529, `col-*` 789, `variable-gutters` 273) | **~2040** | la dipendenza più pervasiva |
| **Spacing utilities** (`m*-N`, `p*-N`, stile BS4 `ml/mr`) | ~630 | con `!important` (attrito per gli override) |
| `card` / `card-*` | ~1257 | in gran parte **già sovrascritte da noi** (card-noicon, card-bg…) |
| `badge` / `chip` | ~195 | |
| `breadcrumb` | ~125 | |
| `btn` / `btn-*` | ~98 | superficie piccola; abbiamo già il pattern `.btn-scopri` |
| `modal` | ~98 | dipende dal **JS di BI** (vedi §2) |
| `nav` / `navbar` / `nav-*` | ~87 | interattività gestita da `scuole.js` (non da BI JS) |
| `accordion` / `collapse` | ~76 | dipende dal **JS di BI** |
| `dropdown*` | ~51 | i menu nav usano il jQuery del tema, non BI JS |
| Display/flex/text utilities | ~330 | `d-*`, `align-items-*`, `justify-content-*`, `text-*`, `font-weight-*` |
| `form-control` / `form-group` | ~26 | |
| Sprite icone `#it-*` | ~26 | **già gestito nel nostro `svg.php`**: dipendenza BI minima |
| `callout` (componente BI) | 0 | non usato |

## 2. Dipendenza dal JS di Bootstrap Italia (delimitata)

Il markup usa convenzioni **Bootstrap 4** (`data-toggle` / `data-target` /
`data-dismiss`). Ciò che dipende davvero dal **JS di BI**:

- **Modali** (`data-toggle="modal"`, 4 + 3 dismiss): `search-modal`,
  `services-modal`, `access-modal`, `modal-more-items`.
- **Collapse** (14): accordion, toggle "mostra altro", descrizioni.
- **Dropdown** (5) e **carousel** (`data-target="#carouselIndicators…"`): in parte
  sovrapposti — i dropdown del menu sono gestiti da `scuole.js`, e per i caroselli
  esiste già **Splide** caricato a parte (candidato a sostituire il carousel BI).

> Molta interattività "tipo Bootstrap" **non** è BI JS ma jQuery del tema
> (`scuole.js`: dropdown del menu, `accordion()`, e jPushMenu per il menu mobile).
> Quindi la superficie JS di BI è **più piccola di quanto sembri**: in pratica
> modali + collapse + (eventualmente) carousel.

## 3. Difficoltà e ordine d'attacco

| Area | Difficoltà | Strategia |
|------|-----------|-----------|
| Sprite `it-*` | Bassa | già nostro (`svg.php`); nessuna azione |
| Bottoni | Bassa | piccola superficie; estendere il pattern `.btn-scopri` |
| Card | Bassa-media | già molto sovrascritte; ottimo target iniziale |
| Badge/chip, breadcrumb | Media | componenti contenuti, riscrivibili in CSS nostro |
| Display/flex/text utils | Media | mappabili su Tailwind (già rem) o utility nostre |
| Spacing utils | Media (volume) | meccanico ma tanto; attrito = `!important` |
| **Griglia** (container/row/col) | **Alta** | la più pervasiva; CSS Grid/Flexbox + `gap` nativi, durante le riscritture di sezione |
| Modali/collapse/carousel | Alta (JS) | richiede sostituire il JS di BI; legare a una modernizzazione JS (carousel → Splide già presente) |

## 4. Raccomandazione

0. **Purge come vittoria rapida** (vedi §0bis): usiamo ~6% di BI → un build step
   di tree-shaking (con safelist delle classi aggiunte da JS) può tagliare ~470 KB
   a ~30–50 KB **senza cambi visivi**, subito e indipendentemente dai layer.
1. **`@layer` prima** (ADR-0003): mette BI in un layer basso così i nostri
   override vincono puliti mentre sostituiamo. Sblocca tutto il resto.
2. **Vittorie facili**: icone (fatte), bottoni, card — già per metà nostre.
3. **Utilities** (spacing/display/text): convergere verso Tailwind (rem) nei
   componenti nuovi; non riscrivere in blocco.
4. **Griglia**: il "last mile", solo durante le riscritture di sezione — è il
   grosso del CSS di BI e va affrontato per ultimo, con calma.
5. **JS di BI**: delimitato (modali + collapse + carousel). Pianificare a parte,
   sfruttando che il carousel ha già Splide come rimpiazzo.

> Nota: passare da BI 1.6.2/BS4/jQuery a un layer custom moderno **non è solo
> riduzione di dipendenza, è anche uscita da uno stack legacy**.
