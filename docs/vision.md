# Visione del sito — ITTM Istituto Tecnico Tecnologico G. Marconi

> Documento di riferimento sul **perché** esiste questo sito e su quali principi
> guidano le scelte di design. È il documento più stabile: cambia raramente.
> Quando si valuta una modifica (layout, contenuto, nuova sezione), la si
> confronta con quanto scritto qui.

## 1. Cosa è questo sito

Il sito è basato sul [modello Scuole di Designers Italia](https://designers.italia.it/modelli/scuole/)
e sul design system [Bootstrap Italia](https://italia.github.io/bootstrap-italia/),
personalizzato per l'ITTM Marconi di Rovereto. Questo garantisce una base
conforme alle linee guida AGID e accessibile per impostazione predefinita.

Non è un sito a scopo unico: assolve **cinque compiti** contemporaneamente, ed è
da questa molteplicità che derivano le principali tensioni di progettazione.

## 2. I cinque compiti del sito

1. **Punto di accesso quotidiano** — porta d'ingresso alle attività di tutti i
   giorni per studenti e famiglie (registro elettronico, circolari, orari,
   calendario).
2. **Informazione per le famiglie** — informazioni utili sia per studenti e
   famiglie **attuali**, sia per quelli **futuri/potenziali** (orientamento).
3. **Conformità legale** — luogo istituzionale dove pubblicare e conservare la
   documentazione obbligatoria (Albo online, Amministrazione Trasparente,
   documenti istituzionali).
4. **Vetrina di notizie ed eventi** — messa in evidenza di notizie ed eventi
   legati a tutte le attività della scuola.
5. **Giornalismo studentesco** — da quest'anno, spazio dove vengono pubblicate
   le notizie scritte dagli studenti.

## 3. I pubblici

| Pubblico | Intento prevalente | Cosa cerca |
|----------|--------------------|------------|
| Studente / famiglia **attuale** | Transazionale | Accesso rapido e ricorrente agli strumenti quotidiani |
| Studente / famiglia **potenziale** | Esplorativo / emotivo | Capire chi siamo, l'offerta formativa, l'atmosfera |
| Cittadino / ente | Obbligatorio | Documentazione istituzionale e trasparenza |
| Personale interno | Operativo | News, comunicazioni, materiali |
| Studente-redattore | Editoriale | Pubblicare e veder valorizzati i propri contenuti |

Questi intenti sono **fondamentalmente diversi** (transazionale vs. ispirazionale
vs. obbligatorio vs. editoriale). La sfida progettuale è servirli tutti senza che
nessuno venga penalizzato.

## 4. Principi di design

1. **La base conforme non si tocca senza motivo.** La struttura del modello
   Scuole (IA, footer istituzionale, componenti Bootstrap Italia) è un valore,
   non un vincolo da aggirare. Le personalizzazioni vivono sopra di essa.
2. **Ogni livello della pagina ha un compito.** Si evita che lo stesso elemento
   provi a fare più lavori in conflitto tra loro.
3. **Accessibilità prima dell'estetica, quando sono in conflitto.** Le
   informazioni essenziali devono esistere come testo reale, non solo dentro le
   immagini. I colori rispettano i rapporti di contrasto WCAG (vedi
   `design-system.md`).
4. **Identità istituzionale coerente.** Il rosso del logo Marconi e la
   tipografia istituzionale sono costanti riconoscibili.

## 5. Filosofia dell'hero

L'hero della home **non è un lanciatore di azioni** ed è una scelta deliberata.

- È il **livello emotivo e stagionale** del sito: cambia frequentemente per
  richiamare stagioni, eventi e ispirazione.
- Comunica «questo è un luogo vivo e attivo», soprattutto verso il pubblico
  **potenziale** (orientamento).
- Le immagini sono fotografie reali, eventualmente rielaborate, associate
  all'evento o al periodo in corso.

Questa scelta **libera** le card e la navigazione sottostanti dal compito
emotivo, lasciandole concentrare sul lavoro funzionale.

**Conseguenze accettate e da presidiare:**

- Il pubblico **quotidiano** non deve dipendere dall'hero per raggiungere gli
  strumenti ricorrenti: l'accesso rapido alle azioni frequenti va garantito da
  un livello che sopravvive a qualsiasi hero in rotazione (vedi
  `adr/0001-hero-stagionale-rotante.md`).
- Le informazioni essenziali di un evento (titolo, data, ora) non possono
  vivere **solo** come pixel dentro l'immagine: vanno rese disponibili anche
  come testo reale, e l'attributo `alt` dell'hero va aggiornato a ogni
  rotazione.

## Documenti correlati

- `design-system.md` — token, componenti, tipografia, roadmap verso il tema scuro.
- `adr/` — registro delle decisioni di design e architettura.
