# Visione del sito — ITT Istituto Tecnico Tecnologico G. Marconi

> Documento di riferimento sul **perché** esiste questo sito e su quali principi guidano le scelte progettuali. È il documento più stabile: cambia raramente. Quando si valuta una modifica (layout, contenuto, nuova sezione), la si confronta con quanto scritto qui.

## 1. Che cos'è questo sito

Il sito è basato sul [modello Scuole di Designers Italia](https://designers.italia.it/modelli/scuole/) e sul design system [Bootstrap Italia](https://italia.github.io/bootstrap-italia/), personalizzato per l'ITT Marconi di Rovereto. Questo offre una base coerente con le linee guida AGID e orientata all'accessibilità.

Il sito non assolve un'unica funzione: svolge **cinque compiti** contemporaneamente, ed è da questa molteplicità che derivano le principali tensioni progettuali.

## 2. I cinque compiti del sito

1. **Punto di accesso quotidiano** — porta d'ingresso alle attività di tutti i giorni per studenti e famiglie (registro elettronico, circolari, orari, calendario).
2. **Informazione per le famiglie** — informazioni utili sia per gli studenti e le famiglie della scuola, sia per i futuri studenti e le loro famiglie (orientamento).
3. **Adempimenti normativi** — luogo istituzionale dove pubblicare e conservare la documentazione obbligatoria (Albo online, Amministrazione Trasparente, documenti istituzionali).
4. **Vetrina di notizie ed eventi** — messa in evidenza di notizie ed eventi legati a tutte le attività della scuola.
5. **Giornalismo studentesco** — spazio dedicato alla pubblicazione e alla valorizzazione degli articoli scritti dagli studenti.

## 3. I destinatari

| Destinatario | Intento prevalente | Cosa cerca |
|--------------|--------------------|------------|
| Studente / famiglia della scuola | Pratico | Accesso rapido e ricorrente agli strumenti quotidiani |
| Futuro studente / famiglia | Esplorativo / emotivo | Capire chi siamo, conoscere l'offerta formativa e percepire l'atmosfera |
| Cittadino / ente | Istituzionale | Documentazione istituzionale e trasparenza |
| Personale interno | Operativo | Notizie, comunicazioni e materiali |
| Studente redattore | Editoriale | Pubblicare e vedere valorizzati i propri contenuti |

Questi intenti sono **profondamente diversi**: pratico, esplorativo, istituzionale, operativo ed editoriale. La sfida progettuale è soddisfarli tutti senza penalizzarne nessuno.

## 4. Principi progettuali

1. **Il modello Scuole è un punto di riferimento, non un limite.** Il sito ne conserva i principi di chiarezza, semplicità di navigazione e attenzione ai bisogni della comunità scolastica, lasciando spazio all'evoluzione delle soluzioni tecniche e dell'interfaccia.
2. **Ogni livello della pagina ha un compito.** Si evita che lo stesso elemento provi a fare più lavori in conflitto tra loro.
3. **Accessibilità prima dell'estetica, quando sono in conflitto.** Le informazioni essenziali devono essere disponibili come testo reale, non solo nelle immagini. I colori rispettano i rapporti di contrasto WCAG (vedi `design-system.md`).
4. **Identità istituzionale coerente.** Il rosso del logo Marconi e la tipografia istituzionale sono elementi riconoscibili e costanti.

## 5. Filosofia dell'hero

L'hero della home **non serve a indirizzare verso azioni specifiche**: è una scelta deliberata.

- È il **livello emotivo e stagionale** del sito: cambia periodicamente per richiamare stagioni, eventi e ispirazione.
- Comunica «questo è un luogo vivo e attivo», soprattutto ai destinatari **potenziali** (orientamento).
- Le immagini possono essere fotografie reali, eventualmente rielaborate, oppure composizioni originali e immagini generate. Possono richiamare un evento, un periodo dell'anno o avere una funzione puramente ispirazionale.

Questa scelta **libera** le schede e la navigazione sottostanti dal compito emotivo, lasciando loro una funzione pratica.

## Documenti correlati

- `design-system.md` — token, componenti, tipografia, roadmap verso il tema scuro.
- `adr/` — registro delle decisioni di design e architettura.
