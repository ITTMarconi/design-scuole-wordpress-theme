# ADR 0002 — Token semantici di colore come prerequisito per il tema scuro

- **Stato:** Proposta
- **Data:** 2026-05-31
- **Contesto correlato:** `design-system.md` §1.4 e §4

## Contesto

Obiettivo dichiarato: **consolidare il design system** e, in futuro, introdurre
un **tema scuro**.

Stato attuale dei colori (`assets-src/css/scuole-marconi.css`):

- Esiste un buon strato di **token primitivi/di brand** (`--redbrown`,
  `--purplelight`, `--greendark`, `--bluelectric`, `--petrol`, rosso Marconi con
  annotazioni WCAG…).
- Esiste solo un **abbozzo incompleto e duplicato** di token semantici
  (`--text`, `--background`, `--primary`, `--secondary`, `--accent`), in parte
  lasciato in commento.
- La maggior parte del CSS usa **direttamente** colori di brand o **valori
  grezzi** (`#fff`, `#333`, `rgba(...)`).

Finché i colori sono usati direttamente, il tema scuro richiederebbe di
riscrivere innumerevoli regole: non sostenibile.

## Decisione (proposta)

Adottare un'architettura a **due livelli**:

1. **Token primitivi** — i colori grezzi attuali, invariati (la palette).
2. **Token semantici** — token **per ruolo** che referenziano i primitivi. Il
   CSS dei componenti usa **solo** questi.

Esempi di token semantici previsti:

| Token semantico | Significato |
|-----------------|-------------|
| `--color-surface` | sfondo superfici |
| `--color-surface-raised` | sfondo card / elementi sollevati |
| `--color-text` | testo principale |
| `--color-text-muted` | testo secondario |
| `--color-border` | bordi |
| `--color-brand` | accento istituzionale (rosso Marconi) |
| `--color-accent` | accento di sezione |

Il **tema scuro ridefinisce solo lo strato semantico** sotto un selettore
dedicato (es. `[data-theme="dark"]` e/o `@media (prefers-color-scheme: dark)`),
senza toccare i primitivi né il CSS dei componenti.

## Piano di adozione

1. Definire lo strato semantico completo, mappato sui primitivi per il tema
   chiaro (nessun cambiamento visivo).
2. Migrare il CSS dall'uso dei token semantici, **file per file**, partendo da
   `scuole-marconi.css` e `overrides.css`.
3. Aggiungere i valori del tema scuro ridefinendo solo i semantici.
4. Verificare i contrasti WCAG anche in modalità scura.
5. Aggiungere il controllo di tema (toggle e/o preferenza di sistema).

La fase 3+ sarà oggetto di un **PRD dedicato al tema scuro**.

## Conseguenze

**Positive**
- Tema scuro abilitato modificando un solo strato.
- CSS più leggibile e manutenibile (ruoli espliciti).
- I rapporti di contrasto restano centralizzati e verificabili.

**Negative / costi**
- Lavoro di migrazione iniziale non banale (sostituzione capillare degli usi
  diretti di colore).
- Necessità di disciplina: vietare nuovi usi di valori grezzi nel CSS dei
  componenti.

## Alternative considerate

- **Override puntuali per il dark mode** (riscrivere le regole sotto un
  selettore scuro) — scartato: fragile, duplicato, difficile da mantenere.
- **Niente strato semantico, solo rinominare i brand** — scartato: non separa il
  *ruolo* dal *valore*, quindi non abilita davvero il theming.
