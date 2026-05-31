# ADR 0003 — Ridurre la dipendenza da Bootstrap Italia (strangler-fig + cascade layers)

- **Stato:** Proposta
- **Data:** 2026-05-31
- **Contesto correlato:** `design-system.md` §0, `adr/0002-token-semantici-per-theming.md`

## Contesto

Il tema è un fork del Modello Scuole e si appoggia a **Bootstrap Italia** (CSS +
JS). Si vuole **ridurre gradualmente** questa dipendenza — non per ideologia, ma
per avere più controllo su layout e stile e poter evolvere l'interfaccia — senza
allontanarsi dai principi del modello (vedi `vision.md`: «il modello è
riferimento, non limite»).

Un dato concreto del nostro setup attuale motiva la scelta:

- Il nostro output Tailwind v4 (`assets/css/tail.css`) è **già in cascade
  layers** (`@layer theme, base, components, utilities`).
- `assets/css/bootstrap-italia.css` **non è in layer**.
- Regola della cascata: **gli stili non-layer vincono su quelli in layer** a
  parità di specificità. Quindi **oggi Bootstrap Italia può sovrascrivere le
  utility Tailwind**: è una delle cause delle "lotte di specificità" ricorrenti.

## Decisione (proposta)

Adottare un approccio **strangler-fig**: avvolgere Bootstrap Italia, **invertire
il controllo della cascata** tramite `@layer`, e poi **sostituire i componenti
BI in modo incrementale** durante le riscritture — non una rimozione big-bang.

Ordine dei layer previsto (dal più debole al più forte):

```
@layer vendor,    /* Bootstrap Italia */
       tailwind,  /* utility/base Tailwind */
       app;       /* CSS custom della scuola (scuole-marconi, overrides) */
```

Con BI nel layer `vendor`, il nostro codice vince **senza** specificità gonfiate
né `!important`, e ogni componente riscritto "esce" da BI restando isolato.

## Cosa NON risolve (limiti da tenere presenti)

- **`!important` di BI ignora i layer.** Le utility tipo `.py-5`, `.d-none`
  continueranno a vincere e vanno gestite caso per caso (come già fatto per il
  `py-5` dell'hero Argomenti).
- **Non riduce il peso.** Layering = priorità, non dimagrimento del bundle. Il
  "meno Bootstrap" in byte arriva solo sostituendo davvero i componenti.
- **Non tocca il JS di BI** (dropdown, push-menu, modali, carousel…).
  L'indipendenza piena richiede anche la sostituzione del JS.
- **Richiede una modifica di build/caricamento.** BI è caricato via
  `wp_enqueue` (link separato): per metterlo in un layer va avvolto il suo
  contenuto in `@layer vendor { … }` (step di build) oppure importato con
  `@import … layer(vendor)` (render-blocking, da evitare per un file così
  grande). Va misurato l'impatto.

## Piano di adozione (sequenza, per non sbagliare ordine)

1. **Token semantici completi** (ADR-0002): i componenti non devono dipendere
   dalle variabili di BI.
2. **Tailwind-first** sui componenti nuovi (già regola in `design-system.md`).
3. **Inventario della superficie BI** realmente usata: griglia, utility,
   componenti, e dipendenze JS. Serve per pianificare con dati.
   → Fatto: `bootstrap-italia-inventory.md` (runtime reale = **v1.6.2 / BS4 /
   jQuery**; la griglia è la dipendenza più pervasiva, il JS di BI è delimitato
   a modali/collapse/carousel).
4. **PoC dei cascade layers** in locale: dichiarare l'ordine dei layer e
   avvolgere BI nel layer `vendor`, **misurare cosa si rompe** (specificità,
   `!important`, ordine), senza deploy.
5. **Introduzione dei layer** con lo step di build, una volta validato il PoC:
   risolve anche il problema Tailwind-vs-BI e dà la base per sostituire BI in
   modo pulito.
6. **Sostituzione incrementale** dei componenti BI, sezione per sezione, durante
   le riscritture già in corso.

> Non introdurre i layer come *prima* mossa a freddo: prima la base (token,
> Tailwind-first, inventario), poi i layer.

## Risultati del PoC (2026-05-31) — esito: **GO, con 1 prerequisito**

**Metodo:** sul dev, BI ri-iniettato in un `@layer` (throwaway, nessun deploy),
con `url()` riscritte in assoluto per non falsare il test. Diff dei
`getComputedStyle` sui soli elementi **HTML visibili** (esclusi sprite icone e
`display:none`), su due pagine: home e una single (servizio).

**Risultato:** nessuna rottura di **colore, sfondo, bordo, ombra, display o
layout** in nessuna delle due pagine.
- Home: **91 / 1180** elementi visibili cambiano.
- Single servizio: **20 / 700** — e **zero** cambiamenti "pesanti" (solo tipografia).

**Causa unica dei cambiamenti:** una regola globale in `tail.css`
(`h1–h6 { @apply text-2xl font-semibold mb-2 mt-4 }`) oggi **soppressa da BI**.
Abbassando BI di priorità, quella regola si attiva e irrigidisce **tutti** i
titoli (`font-weight 400→600`, dimensione/`line-height` diversi). È un footgun
latente a prescindere dai layer.

**`!important` di BI:** invariato — i layer non lo toccano, quindi le utility
`!important` continuano a comportarsi **esattamente come adesso**: nessuna
rottura da lì.

**Prerequisito prima del rollout:** mettere in sicurezza quella regola titoli
(scoparla ai contesti voluti o rimuoverla). **Caveat:** PoC su 2 pagine;
estendere a pagine con form/modali/carousel prima di introdurre i layer in
produzione.

## Conseguenze

**Positive**
- Cascata prevedibile: il nostro codice e Tailwind vincono su BI senza hack.
- Percorso di uscita incrementale e a basso rischio (un componente alla volta).
- Riduce le "lotte di specificità" e il ricorso a `!important`.

**Negative / costi**
- Step di build aggiuntivo per layerare un file vendor.
- Beneficio parziale finché restano `!important` e JS di BI.
- Richiede disciplina nel non re-introdurre dipendenze da BI nei componenti nuovi.

## Alternative considerate

- **Rimozione big-bang di Bootstrap Italia** — scartata: costo/rischio enormi
  (CSS + JS + allineamento al modello), nessun valore incrementale lungo il
  percorso.
- **Continuare con specificità/`!important`** per sovrascrivere BI — scartata:
  è il debito che stiamo cercando di ridurre.
- **Lasciare tutto com'è** — accettabile nel breve, ma non avvicina all'obiettivo
  dichiarato di ridurre la dipendenza.
