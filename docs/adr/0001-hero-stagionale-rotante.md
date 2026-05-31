# ADR 0001 — Hero stagionale e rotante (non lanciatore di azioni)

- **Stato:** Accettata
- **Data:** 2026-05-31
- **Contesto correlato:** `vision.md` §5

## Contesto

La home serve cinque pubblici con intenti diversi (vedi `vision.md`). Si è posta
la domanda se l'hero debba essere un **banner funzionale con una singola call to
action** oppure un **livello emotivo/stagionale in rotazione**.

L'hero attuale mostra una fotografia reale (eventualmente rielaborata con AI)
associata a un evento o periodo, con il logo dell'evento appena trascorso, e
cambia frequentemente.

## Decisione

L'hero è **deliberatamente** il livello **emotivo e stagionale** del sito, **non**
un lanciatore di azioni:

- cambia spesso per richiamare stagioni, eventi e ispirazione;
- comunica «scuola viva e attiva», soprattutto al pubblico potenziale
  (orientamento);
- libera card e navigazione sottostanti dal compito emotivo.

## Conseguenze

**Positive**
- Il livello emotivo ha una casa chiara; il resto della pagina resta funzionale.
- Coerenza con la natura editoriale/orientativa del sito.

**Da presidiare (vincoli accettati)**
1. **Accesso quotidiano indipendente dall'hero.** Il pubblico ricorrente non
   deve dipendere dall'immagine in rotazione per raggiungere gli strumenti di
   tutti i giorni. → Da garantire con un livello di accesso rapido che
   sopravvive a qualsiasi hero (proposta aperta, non ancora implementata).
2. **Niente informazioni essenziali solo nei pixel.** Titolo, data e ora di un
   evento devono esistere anche come **testo reale** accanto all'immagine; l'
   attributo `alt` dell'hero va aggiornato a ogni rotazione. Vincolo di
   accessibilità e SEO **non negoziabile**.
3. **Qualità e autenticità delle immagini.** Preferire fotografie reali; la
   rielaborazione AI è ammessa ma da usare con misura per non intaccare la
   percezione di autenticità verso il pubblico potenziale.

## Alternative considerate

- **Hero come banner con singola CTA** — scartato: comprimerebbe il livello
  emotivo/stagionale, importante per l'orientamento, in un unico messaggio
  funzionale.
- **Nessun hero / hero statico** — scartato: rinuncerebbe al richiamo stagionale
  e al senso di «scuola viva».
