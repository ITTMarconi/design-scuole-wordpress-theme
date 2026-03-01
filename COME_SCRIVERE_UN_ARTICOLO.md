# Come scrivere un articolo per l'importazione

Questa guida spiega come preparare un file Markdown (`.md`) pronto per essere
importato nel sito tramite lo script `scripts/md-import.js`.

---

## Struttura del file

Ogni file è diviso in due parti separate da `---`:

```
---
# frontmatter YAML: metadati del post
---

Corpo dell'articolo in Markdown.
```

Il **frontmatter** contiene titolo, tipo, data e altri campi strutturati.
Il **corpo** è il testo vero e proprio, scritto in Markdown standard.

---

## Frontmatter — campi comuni

### Campi obbligatori

| Campo   | Valori possibili | Descrizione |
|---------|-----------------|-------------|
| `type`  | vedi tabella sotto | Tipo di contenuto |
| `title` | testo libero | Titolo del post |

### Campi facoltativi

| Campo | Valore esempio | Descrizione |
|-------|---------------|-------------|
| `date` | `2026-03-15` | Data di pubblicazione (ISO 8601). Default: oggi |
| `status` | `draft` / `publish` / `private` | Stato del post. Default: `draft` |
| `excerpt` | testo breve | Breve descrizione (max ~160 caratteri) |
| `featured_image` | `./img/copertina.jpg` | Immagine di copertina, percorso relativo al file `.md` |
| `tipologia` | slug del termine | Termine della tassonomia tipologia (vedi sotto) |
| `tags` | `[robotica, PCTO, alternanza]` | Tag liberi, lista YAML |

---

## Tipi di contenuto (`type`)

| Valore `type`    | Sezione del sito         | Tassonomia tipologia          |
|-----------------|--------------------------|-------------------------------|
| `post`           | Notizie / Articoli       | `tipologia-articolo`          |
| `circolare`      | Circolari                | `tipologia-circolare`         |
| `scheda_progetto`| Progetti                 | `tipologia-progetto`          |
| `scheda_didattica`| Didattica               | —                             |
| `documento`      | Documenti                | `tipologia-documento`         |
| `evento`         | Calendario eventi        | `tipologia-evento`            |
| `servizio`       | Servizi                  | `tipologia-servizio`          |
| `struttura`      | Organizzazione           | `tipologia-struttura`         |
| `luogo`          | Luoghi                   | `tipologia-luogo`             |

---

## Campi aggiuntivi per tipo

### `post` (notizia / articolo)

```yaml
type: post
category: news          # categoria WordPress nativa (slug)
```

### `circolare`

```yaml
type: circolare
numero: "042/2026"      # numero di protocollo
is_pubblica: true       # true = visibile a tutti, false = solo interni
```

### `scheda_progetto`

```yaml
type: scheda_progetto
obiettivi: "Sviluppare competenze di coding e problem solving."
data_inizio: 2026-09-01
data_fine:   2027-06-30
```

### `documento`

```yaml
type: documento
data_scadenza: 2026-12-31
```

---

## Immagini

### Immagine di copertina

```yaml
featured_image: ./img/copertina.jpg
```

Il percorso è **relativo al file `.md`**. L'immagine viene caricata nella
Libreria Media di WordPress e associata come immagine in evidenza.

### Immagini nel corpo

Le immagini nel testo si inseriscono con la sintassi Markdown standard:

```markdown
![Descrizione dell'immagine](./img/foto-evento.jpg)
```

Anche qui il percorso è relativo al `.md`. Lo script carica ogni immagine
locale su WordPress e sostituisce automaticamente il percorso locale con
l'URL definitivo. Le immagini già su web (`https://…`) vengono lasciate
invariate.

> **Suggerimento:** tieni le immagini in una sottocartella `img/` accanto
> al file `.md`. Dai nomi descrittivi senza spazi: `foto-laboratorio-2026.jpg`.

---

## Corpo dell'articolo

Usa Markdown standard. Di seguito i costrutti più utili.

### Titoli

```markdown
## Titolo di secondo livello
### Titolo di terzo livello
```

Non usare `# H1`: il titolo principale viene dal campo `title` del frontmatter.

### Paragrafi e a capo

Separa i paragrafi con una riga vuota. Un semplice invio non crea un nuovo
paragrafo — serve la riga vuota.

```markdown
Primo paragrafo.

Secondo paragrafo.
```

### Enfasi

```markdown
**grassetto**   _corsivo_   ~~barrato~~
```

### Liste

```markdown
- Primo elemento
- Secondo elemento
  - Sotto-elemento (due spazi di rientro)

1. Primo passo
2. Secondo passo
3. Terzo passo
```

### Link

```markdown
[testo del link](https://www.ittmarconi.edu.it)
```

### Citazione

```markdown
> Questo è un testo in evidenza o una citazione.
```

### Tabella

```markdown
| Colonna A | Colonna B | Colonna C |
|-----------|-----------|-----------|
| valore 1  | valore 2  | valore 3  |
```

---

## Esempi completi

### Notizia semplice

```markdown
---
type: post
title: "Open Day 2026: iscriviti ora"
date: 2026-01-20
status: publish
excerpt: "Sabato 8 febbraio apriamo le porte dell'istituto alle famiglie."
featured_image: ./img/open-day-2026.jpg
tipologia: notizie
tags: [open day, orientamento, famiglie]
category: news
---

Sabato **8 febbraio 2026** l'ITTM Marconi apre le porte alle famiglie
e agli studenti delle medie che stanno scegliendo la scuola superiore.

## Programma della mattinata

- 9:00 — Accoglienza e presentazione dell'istituto
- 10:00 — Visita ai laboratori (informatica, elettronica, meccanica)
- 11:30 — Incontro con docenti e studenti

![Laboratorio di elettronica](./img/laboratorio-elettronica.jpg)

Per informazioni scrivi a [orientamento@ittmarconi.edu.it](mailto:orientamento@ittmarconi.edu.it).
```

---

### Circolare

```markdown
---
type: circolare
title: "Circolare n. 042 — Aggiornamento calendario scolastico"
date: 2026-03-01
status: publish
numero: "042/2026"
is_pubblica: true
excerpt: "Modifica al calendario per il ponte del 25 aprile."
tipologia: comunicazioni
tags: [calendario, festività]
---

Si comunica a docenti, personale ATA e famiglie che, in occasione del
ponte del **25 aprile**, le attività didattiche sono sospese anche
**venerdì 24 aprile 2026**.

Il calendario aggiornato sarà disponibile sul sito istituzionale.

Il Dirigente Scolastico
```

---

### Progetto

```markdown
---
type: scheda_progetto
title: "RoboMarconi 2026 — Robotica educativa"
date: 2026-09-01
status: publish
excerpt: "Progetto annuale di robotica rivolto alle classi terze e quarte."
featured_image: ./img/robomarconi-logo.png
tipologia: PCTO
obiettivi: |
  Sviluppare competenze di programmazione, problem solving e lavoro
  di squadra attraverso la costruzione e la programmazione di robot.
data_inizio: 2026-09-15
data_fine:   2027-05-30
tags: [robotica, coding, PCTO, Arduino]
---

## Descrizione

RoboMarconi è il progetto di robotica educativa dell'ITTM che coinvolge
ogni anno oltre 60 studenti delle classi terze e quarte.

## Fasi del progetto

1. **Settembre–ottobre** — Formazione base su Arduino e Python
2. **Novembre–gennaio** — Progettazione e costruzione del robot
3. **Febbraio–aprile** — Test e ottimizzazione
4. **Maggio** — Gara finale e presentazione ai genitori

![Robot prototipo](./img/robot-prototipo.jpg)
```

---

## Come importare il file

### 1. Installa le dipendenze (prima volta)

```bash
npm install
```

### 2. Crea il file `.env` con le credenziali

Copia il file di esempio e compilalo:

```bash
cp .env.example .env
```

Poi apri `.env` e inserisci i tuoi valori:

```
WP_URL=https://dev.ittm.it
WP_USER=admin
WP_APP_PASS=xxxx xxxx xxxx xxxx xxxx xxxx
```

**Come ottenere la Application Password:**
WP Admin → **Utenti** → il tuo profilo → sezione **Password dell'applicazione**
→ scegli un nome (es. `importer`) → clicca Aggiungi → copia la password mostrata
(non verrà più visualizzata).

> Il file `.env` è in `.gitignore` e non viene mai committato. Non condividerlo.

### 3. Prova con dry-run

```bash
npm run import:md -- ./percorso/al/file.md --dry-run
```

Controlla l'output: titolo, tipo, meta e tassonomie devono corrispondere
a quello che ti aspetti. Nessun dato viene inviato al server.

### 4. Importazione reale

```bash
npm run import:md -- ./percorso/al/file.md
```

Lo script stampa l'ID del post creato. Puoi poi aprirlo in WP Admin per
verificare o correggere eventuali dettagli prima di pubblicarlo.

---

## Errori comuni

| Errore | Causa | Soluzione |
|--------|-------|-----------|
| `Missing required frontmatter fields: title` | Il campo `title` manca | Aggiungilo al frontmatter |
| `Unknown post type "articolo"` | Valore `type` non valido | Usa uno dei valori nella tabella dei tipi |
| `HTTP 401` | Credenziali errate | Verifica `WP_USER` e `WP_APP_PASS` |
| `HTTP 403` | L'utente non ha permessi | L'utente WordPress deve avere il ruolo **Editor** o superiore |
| `body image not found` | Percorso immagine errato | Controlla che il file esista nel percorso relativo indicato |
| La tassonomia non viene assegnata | Errore nel termine | Lo script logga il post ID — correggi manualmente in WP Admin |
