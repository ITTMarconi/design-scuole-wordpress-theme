# Design System — ITTM Marconi

> Documenta **come** è costruito il sito: token, tipografia, componenti e regole
> di utilizzo. È il documento operativo da consolidare e l'artefatto chiave per
> abilitare il **tema scuro** in futuro.
>
> Questo è uno snapshot **onesto dello stato attuale**, non un ideale: dove il
> sistema è incoerente, lo si segnala come debito da sanare.

## 0. Come lavorare sui sorgenti

- Si modificano **sempre** i file in `assets-src/css/`, **mai** quelli in
  `assets/css/` (output compilato, sovrascritto a ogni build).
- Dopo ogni modifica al CSS sorgente: `npm run build:css`.
- File CSS principali:
  - `scuole-marconi.css` — CSS custom primario della scuola (qui vivono i token).
  - `overrides.css` — override di Bootstrap Italia.
  - `tail.css` — sorgente TailwindCSS.
  - `admin-style.css` — interfaccia di amministrazione.
- Preferire le utility Tailwind al nuovo CSS custom quando possibile (vedi
  `CLAUDE.md`).

### Convenzioni per il codice NUOVO

Il tema è in **refactoring graduale**: il codice esistente non va convertito in
blocco: le modernizzazioni avvengono quando una sezione viene riscritta. Il
codice **nuovo o modificato**, però, segue da subito queste best practice:

- **Unità**: `rem` per spaziature e dimensioni legate al testo (min-height,
  padding, gap). `px` solo per bordi/hairline e piccoli dettagli decorativi
  fissi (raggi, blur delle ombre, micro-offset). Le utility Tailwind sono già
  rem-based: preferirle per i componenti nuovi.
- **Accessibilità**: `:focus-visible`, fallback `prefers-reduced-motion`,
  informazioni essenziali come testo reale (mai solo dentro le immagini).
- **Token, non numeri magici**: usare le CSS custom properties / token semantici
  (vedi §1) invece di valori hardcoded.
- **CSS moderno** dove serve davvero: `clamp()` per dimensioni fluide, proprietà
  logiche, `gap`, ecc.
- **Niente conversioni "di passaggio"**: si modernizza solo il codice che si sta
  effettivamente riscrivendo.

### CSS moderno: cosa adottare (sito pubblico, vincoli di accessibilità)

Il pubblico è ampio (non solo browser evergreen) e valgono gli obblighi di
accessibilità della PA: l'adozione delle feature va decisa in base al supporto,
non alla moda.

- **Adottare ora** (Baseline, basso rischio): proprietà logiche
  (`margin-inline`, `padding-block`, `inset`), `gap`, intrinsic sizing
  (`min-content`, `fit-content`), `aspect-ratio`, `:has()`, custom properties /
  token, `:focus-visible`, `prefers-reduced-motion`, unità `rem`.
- **Selettivo** (utile, ma con criterio): container queries per i componenti
  (dimensionare sul contenitore, non sul viewport — Tailwind v4 le espone);
  `@property` per animare in modo fluido variabili tipizzate (es. gradienti).
- **Solo progressive enhancement** (supporto non garantito): View Transitions
  API, scroll-driven animations, `@scope`, style queries. Mai come unico
  percorso: sempre con fallback funzionante.

**Due trappole da ricordare:**

- **`clamp()` per il testo deve contenere un termine `rem`.** Un `clamp()`
  basato solo su `vw` **disattiva lo zoom** e viola la WCAG 1.4.4. Forma
  corretta: `clamp(1rem, 4vw + 0.5rem, 2rem)`.
- **`@layer` + Bootstrap Italia.** Gli stili *non* in layer **vincono** su
  quelli in layer. Bootstrap Italia è un file compilato non in layer: se
  mettiamo i nostri override in un `@layer` e lasciamo BI fuori, **vince BI**
  (l'opposto di ciò che vogliamo). Inoltre le utility `!important` di BI
  ignorano del tutto i layer. Quindi `@layer` conviene solo se importiamo anche
  BI dentro un layer (modifica di build) — non va introdotto a cuor leggero.

## 1. Token di colore

I token sono definiti come **CSS custom properties** nel blocco `:root` di
`assets-src/css/scuole-marconi.css`.

### 1.1 Colore istituzionale (rosso Marconi)

| Token | Valore | Note contrasto (su bianco) |
|-------|--------|----------------------------|
| `--rosso-logo-marconi-original` | `#e31e24` | 4.69:1 — AA testo piccolo / AAA testo grande |
| `--rosso-logo-marconi-wcag` | `#b31100` | >7:1 — AAA testo piccolo e grande |
| `--rosso-logo-marconi` | `#e31e24` | alias del colore originale |

> Regola: per **testo e bordi** usare la variante `-wcag` (`#b31100`); la
> variante originale `#e31e24` è riservata a usi decorativi di grande
> dimensione dove il contrasto è già soddisfatto.

### 1.2 Palette per sezione (colori di brand)

Ogni macro-sezione del sito ha un colore identificativo. Ciascun colore ha le
sue varianti `hover` / `active` / `border` / `alpha`.

| Famiglia | Base | Uso |
|----------|------|-----|
| `--redbrown` | `var(--rosso-logo-marconi-wcag)` | accento istituzionale / sezione Scuola |
| `--purplelight` | `#9217ab` | sezione (es. Servizi) |
| `--greendark` | `#026724` | sezione (es. Didattica/verde) |
| `--bluelectric` | `#4b21f2` | sezione (es. Didattica/elettrico) |
| `--petrol` | `#3f5b6e` | superfici scure / footer (`--footer-bg`) |
| `--yellow` | `#fc0` | accento di richiamo |

I token `--menu-*` derivano da questi e sono annotati in sorgente con i rapporti
di contrasto (tutti AAA), perché usati per il testo dei menu.

### 1.3 Neutri e alpha

| Token | Valore |
|-------|--------|
| `--white` | `#fff` |
| `--black` | `#333` |
| `--dark` | `#17324d` |
| `--white-alpha` | `rgba(255,255,255,0.15)` |
| `--black-alpha` | `rgba(0,0,0,0.075)` |
| `--black-alpha-dark` | `rgba(0,0,0,0.125)` |

### 1.4 Livello semantico — `--color-*` (ADR-0002)

Lo strato semantico (token per **ruolo**, non per colore) esiste nel blocco
`:root` di `scuole-marconi.css` e referenzia i primitivi sopra. È l'unico strato
che il **tema scuro** dovrà ridefinire (vedi stub `[data-theme="dark"]` in fondo
al file).

| Token semantico | Mappa su | Ruolo |
|-----------------|----------|-------|
| `--color-surface` / `--color-surface-raised` | `--white` | sfondo pagina / card |
| `--color-surface-sunken` | `#f5f5f5` | sfondi incassati |
| `--color-text` | `--black` | testo principale |
| `--color-heading` | `--dark` | titoli (più scuri del corpo) |
| `--color-text-muted` | `#5c6f82` | testo secondario / metadati |
| `--color-text-on-brand` | `--white` | testo su superfici di brand |
| `--color-border` / `--color-border-strong` | `#e3e4e6` / `#cacacc` | bordi |
| `--color-brand` / `--color-brand-hover` | `--redbrown` | accento istituzionale |
| `--color-accent` | `--petrol` | accento neutro |
| `--color-section-{scuola,servizi,didattica,verde,argomenti}` | palette per-sezione | accenti di sezione |

**Stato (fase 2 in corso):** i componenti che controlliamo noi — card Servizi e
bottone `.btn-scopri` (`overrides.css`) — **consumano già** i token. Resta da
migrare il grosso di `scuole-marconi.css`, che usa ancora colori di brand e
valori grezzi: è l'ultimo ostacolo al tema scuro, da fare **file per file** a
parità visiva (i token mappano sui valori attuali, quindi la migrazione non
cambia nulla a occhio). I one-off decorativi (stop dei gradienti, ombre tinte)
restano grezzi finché non serviranno nel tema scuro.

## 2. Tipografia

| Ruolo | Font | Fallback |
|-------|------|----------|
| Testo e titoli (UI) | **Titillium Web** | Geneva, Tahoma, sans-serif |
| Serif editoriale | **Lora** | Georgia, serif |
| Monospace / codici | **Roboto Mono** | monospace |

Titillium Web è il font istituzionale del modello. I font critici sono
precaricati per le prestazioni (vedi cronologia dei commit perf).

## 3. Componenti e pattern principali

- **Header istituzionale** — striscia ministeriale, logo + denominazione scuola,
  ricerca, «Servizi esterni», accesso. (Bootstrap Italia)
- **Mega-menu** — quattro voci principali (Scuola / Servizi / Novità /
  Didattica) + collegamenti istituzionali.
- **Hero stagionale** — vedi `vision.md` §5 e `adr/0001`.
- **Griglia di news/eventi** — card delle notizie.
- **Bande di sezione colorate** — Servizi, Didattica, Argomenti, footer.
- **Footer istituzionale** — contatti, codici (CF, CM, IPA, CUF, AOO),
  Amministrazione Trasparente, Albo online.

### Linee guida immagini

- Le informazioni essenziali (date, titoli) **non** vanno incise nei pixel:
  devono esistere come testo reale accanto all'immagine.
- Preferire fotografie **reali** della scuola, soprattutto verso il pubblico
  potenziale; riservare la rielaborazione AI ai casi in cui non si dispone di
  uno scatto reale utilizzabile.
- Mantenere rapporti d'aspetto e trattamento coerenti tra le card.

## 4. Roadmap verso il tema scuro

Il tema scuro **non** è una riverniciatura: è abilitato dall'architettura dei
token. Passi, in ordine:

1. **Definire lo strato semantico completo** (§1.4) e mapparlo sui primitivi
   attuali per il tema chiaro — senza cambiare nulla visivamente.
2. **Migrare il CSS** dall'uso diretto dei colori di brand/valori grezzi ai
   token semantici, file per file.
3. **Definire i valori scuri** ridefinendo solo i token semantici sotto un
   selettore di tema (es. `[data-theme="dark"]` o `prefers-color-scheme`).
4. **Verificare i contrasti WCAG** anche in modalità scura.
5. **Aggiungere il controllo di tema** (toggle e/o rispetto della preferenza di
   sistema).

Quando partirà l'iniziativa vera e propria, redigere un **PRD dedicato al tema
scuro** (obiettivi, mappatura token, target di contrasto, rilascio).

## Documenti correlati

- `vision.md` — pubblici, compiti del sito, filosofia dell'hero.
- `adr/` — decisioni puntuali.
