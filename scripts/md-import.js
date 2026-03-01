#!/usr/bin/env node
/**
 * md-import.js — Markdown → WordPress REST API batch importer
 *
 * Usage:
 *   WP_URL=https://dev.ittm.it WP_USER=admin WP_APP_PASS="xxxx xxxx" \
 *     node scripts/md-import.js ./content/post.md [--dry-run]
 *
 *   npm run import:md -- ./content/post.md --dry-run
 *
 * Requires Node 18+ (native fetch). Falls back to node-fetch if unavailable.
 */

'use strict';

// ─── Dependencies ─────────────────────────────────────────────────────────────

const fs   = require('fs');
const path = require('path');
const matter = require('gray-matter');

// ─── Load .env file (if present) ─────────────────────────────────────────────
// Looks for .env in the project root (parent of scripts/).
// No external dependency — parsed manually.
{
  const envPath = path.resolve(__dirname, '..', '.env');
  if (fs.existsSync(envPath)) {
    const lines = fs.readFileSync(envPath, 'utf8').split('\n');
    for (const line of lines) {
      const trimmed = line.trim();
      if (!trimmed || trimmed.startsWith('#')) continue;
      const eq = trimmed.indexOf('=');
      if (eq === -1) continue;
      const key = trimmed.slice(0, eq).trim();
      const val = trimmed.slice(eq + 1).trim().replace(/^["']|["']$/g, '');
      if (!(key in process.env)) process.env[key] = val; // env vars win over .env
    }
  }
}
const { marked } = require('marked');
const FormData = require('form-data');

// ─── Configuration ────────────────────────────────────────────────────────────

const WP_URL     = (process.env.WP_URL     || '').replace(/\/$/, '');
const WP_USER    = process.env.WP_USER     || '';
const WP_APP_PASS = process.env.WP_APP_PASS || '';

// Allow self-signed / untrusted SSL certs in dev environments.
// Set WP_INSECURE=true in .env when WP_URL uses a self-signed certificate.
if (process.env.WP_INSECURE === 'true') {
  process.env.NODE_TLS_REJECT_UNAUTHORIZED = '0';
}

const args    = process.argv.slice(2);
const DRY_RUN = args.includes('--dry-run');
const mdFiles = args.filter(a => !a.startsWith('--'));

// ─── Post type → REST endpoint base ──────────────────────────────────────────

const REST_BASE = {
  post:             '/wp/v2/posts',
  circolare:        '/wp/v2/circolare',
  scheda_progetto:  '/wp/v2/scheda_progetto',
  scheda_didattica: '/wp/v2/scheda_didattica',
  documento:        '/wp/v2/documento',
  evento:           '/wp/v2/evento',
  servizio:         '/wp/v2/servizio',
  struttura:        '/wp/v2/struttura',
  luogo:            '/wp/v2/luogo',
};

// ─── Frontmatter key → WP meta key, per post type ────────────────────────────

const META_MAP = {
  post: {
    excerpt: '_dsi_articolo_descrizione',
  },
  circolare: {
    excerpt:     '_dsi_circolare_descrizione',
    numero:      '_dsi_circolare_numerazione_circolare',
    is_pubblica: '_dsi_circolare_is_pubblica',
  },
  scheda_progetto: {
    excerpt:    '_dsi_scheda_progetto_descrizione',
    obiettivi:  '_dsi_scheda_progetto_obiettivi',
    data_inizio: '_dsi_scheda_progetto_timestamp_inizio',
    data_fine:   '_dsi_scheda_progetto_timestamp_fine',
  },
  scheda_didattica: {
    excerpt: '_dsi_scheda_didattica_descrizione',
  },
  documento: {
    excerpt:       '_dsi_documento_descrizione',
    data_scadenza: '_dsi_documento_data_scadenza',
  },
};

// ─── Taxonomy map: post type → tipologia taxonomy slug ───────────────────────

const TIPOLOGIA_TAX = {
  post:             'tipologia-articolo',
  circolare:        'tipologia-circolare',
  scheda_progetto:  'tipologia-progetto',
  scheda_didattica: null,
  documento:        'tipologia-documento',
  evento:           'tipologia-evento',
  servizio:         'tipologia-servizio',
  struttura:        'tipologia-struttura',
  luogo:            'tipologia-luogo',
};

// ─── Helpers ──────────────────────────────────────────────────────────────────

function authHeader() {
  const token = Buffer.from(`${WP_USER}:${WP_APP_PASS.replace(/\s/g, '')}`).toString('base64');
  return `Basic ${token}`;
}

async function apiFetch(endpoint, options = {}) {
  const url = WP_URL + '/wp-json' + endpoint;
  const headers = {
    Authorization: authHeader(),
    ...options.headers,
  };
  let res;
  try {
    res = await fetch(url, { ...options, headers });
  } catch (err) {
    // Surface the real cause (SSL error, ECONNREFUSED, ENOTFOUND, etc.)
    const cause = err.cause ? ` (${err.cause.code ?? err.cause.message ?? err.cause})` : '';
    throw new Error(`Network error${cause} — ${url}\nHint: if this is an SSL error, add WP_INSECURE=true to your .env`);
  }
  if (!res.ok) {
    const body = await res.text();
    throw new Error(`HTTP ${res.status} ${res.statusText} — ${url}\n${body}`);
  }
  return res.json();
}

async function uploadMedia(filePath, retries = 3) {
  const filename = path.basename(filePath);
  const fileBuffer = fs.readFileSync(filePath);

  for (let attempt = 1; attempt <= retries; attempt++) {
    try {
      const form = new FormData();
      form.append('file', fileBuffer, { filename });

      if (DRY_RUN) {
        console.log(`  [dry-run] Would upload media: ${filePath}`);
        return { id: 0, source_url: `DRY_RUN_URL/${filename}` };
      }

      // Native fetch (Node 18+ / undici) does not consume form-data streams
      // reliably. Convert to a buffer so the body is sent in full.
      const data = await apiFetch('/wp/v2/media', {
        method: 'POST',
        body: form.getBuffer(),
        headers: form.getHeaders(),
      });
      return data;
    } catch (err) {
      if (attempt === retries) throw err;
      console.warn(`  Media upload attempt ${attempt} failed, retrying…`);
      await new Promise(r => setTimeout(r, 1000));
    }
  }
}

function resolveLocalSrc(src, mdDir) {
  if (/^https?:\/\//i.test(src) || /^data:/i.test(src)) return null;
  return path.resolve(mdDir, src);
}

// ─── Main import function ─────────────────────────────────────────────────────

async function importFile(mdPath) {
  const mdDir     = path.dirname(path.resolve(mdPath));
  const raw       = fs.readFileSync(mdPath, 'utf8');
  const { data: fm, content: body } = matter(raw);

  // Validate required frontmatter
  const missing = ['title', 'type'].filter(k => !fm[k]);
  if (missing.length) {
    throw new Error(`Missing required frontmatter fields: ${missing.join(', ')}`);
  }

  const postType = fm.type;
  if (!REST_BASE[postType]) {
    throw new Error(`Unknown post type "${postType}". Supported: ${Object.keys(REST_BASE).join(', ')}`);
  }

  console.log(`\nImporting: ${mdPath}`);
  console.log(`  type:   ${postType}`);
  console.log(`  title:  ${fm.title}`);

  // ── Convert Markdown to HTML ──────────────────────────────────────────────
  let html = marked.parse(body);

  // ── Upload body images ────────────────────────────────────────────────────
  const imgRegex = /<img[^>]+src="([^"]+)"/g;
  const localImgs = new Map(); // src → uploaded URL
  let match;

  while ((match = imgRegex.exec(html)) !== null) {
    const src = match[1];
    const localPath = resolveLocalSrc(src, mdDir);
    if (localPath && !localImgs.has(src)) {
      if (!fs.existsSync(localPath)) {
        console.warn(`  WARNING: body image not found, skipping: ${localPath}`);
        continue;
      }
      console.log(`  Uploading body image: ${src}`);
      const media = await uploadMedia(localPath);
      localImgs.set(src, media.source_url);
    }
  }

  // Replace local src with WP URLs
  for (const [src, wpUrl] of localImgs) {
    html = html.split(`src="${src}"`).join(`src="${wpUrl}"`);
  }

  // ── Upload featured image ─────────────────────────────────────────────────
  let featuredMediaId = 0;
  if (fm.featured_image) {
    const featuredPath = resolveLocalSrc(fm.featured_image, mdDir);
    if (featuredPath && fs.existsSync(featuredPath)) {
      console.log(`  Uploading featured image: ${fm.featured_image}`);
      const media = await uploadMedia(featuredPath);
      featuredMediaId = media.id;
    } else {
      console.warn(`  WARNING: featured_image not found: ${fm.featured_image}`);
    }
  }

  // ── Build meta object ─────────────────────────────────────────────────────
  const metaMap = META_MAP[postType] || {};
  const meta = {};
  for (const [fmKey, wpKey] of Object.entries(metaMap)) {
    if (fm[fmKey] !== undefined && fm[fmKey] !== null) {
      meta[wpKey] = fm[fmKey];
    }
  }

  // ── Build REST body ───────────────────────────────────────────────────────
  const postBody = {
    title:          fm.title,
    content:        html,
    status:         fm.status || 'draft',
    ...(fm.date && { date: new Date(fm.date).toISOString() }),
    ...(fm.excerpt && { excerpt: fm.excerpt }),
    ...(featuredMediaId && { featured_media: featuredMediaId }),
    ...(Object.keys(meta).length && { meta }),
  };

  console.log(`  REST body keys: ${Object.keys(postBody).join(', ')}`);
  if (Object.keys(meta).length) {
    console.log(`  Meta: ${JSON.stringify(meta)}`);
  }

  if (DRY_RUN) {
    console.log(`  [dry-run] Would POST to ${REST_BASE[postType]}`);
    console.log(`  [dry-run] Post body:`, JSON.stringify(postBody, null, 4));
  }

  // ── Create post ───────────────────────────────────────────────────────────
  let postId;
  if (!DRY_RUN) {
    const created = await apiFetch(REST_BASE[postType], {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(postBody),
    });
    postId = created.id;
    console.log(`  Created post ID: ${postId}`);
  } else {
    postId = 0;
    console.log(`  [dry-run] Post would be created`);
  }

  // ── Assign taxonomies ─────────────────────────────────────────────────────
  const taxAssignments = [];

  // tipologia
  const tipTax = TIPOLOGIA_TAX[postType];
  if (tipTax && fm.tipologia) {
    taxAssignments.push({ taxonomy: tipTax, terms: [fm.tipologia] });
  }

  // tags (post_tag — available on all CPTs via argomento.php)
  if (fm.tags) {
    const tags = Array.isArray(fm.tags) ? fm.tags : [fm.tags];
    taxAssignments.push({ taxonomy: 'post_tag', terms: tags.map(String) });
  }

  // category — native posts only
  if (postType === 'post' && fm.category) {
    const cats = Array.isArray(fm.category) ? fm.category : [fm.category];
    taxAssignments.push({ taxonomy: 'category', terms: cats.map(String) });
  }

  for (const { taxonomy, terms } of taxAssignments) {
    console.log(`  Assigning taxonomy "${taxonomy}": [${terms.join(', ')}]`);

    if (DRY_RUN) {
      console.log(`  [dry-run] Would POST /wp-json/ittm/v1/set-terms`);
      continue;
    }

    try {
      await apiFetch('/ittm/v1/set-terms', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ post_id: postId, taxonomy, terms }),
      });
    } catch (err) {
      console.error(
        `  ERROR assigning taxonomy "${taxonomy}" to post ${postId}. Fix manually in WP Admin.`
      );
      console.error(`  Details: ${err.message}`);
    }
  }

  console.log(`  Done: ${DRY_RUN ? '[dry-run]' : `post ID ${postId}`}`);
  return postId;
}

// ─── Entry point ──────────────────────────────────────────────────────────────

async function main() {
  if (!WP_URL || !WP_USER || !WP_APP_PASS) {
    if (!DRY_RUN) {
      console.error(
        'ERROR: Set WP_URL, WP_USER, and WP_APP_PASS environment variables.\n' +
        '  Example:\n' +
        '    WP_URL=https://dev.ittm.it WP_USER=admin WP_APP_PASS="xxxx xxxx" \\\n' +
        '      node scripts/md-import.js ./content/post.md'
      );
      process.exit(1);
    }
  }

  if (mdFiles.length === 0) {
    console.error('ERROR: Provide at least one .md file path as argument.');
    process.exit(1);
  }

  if (DRY_RUN) {
    console.log('DRY RUN — no network calls will be made.\n');
  }

  let ok = 0;
  let fail = 0;

  for (const file of mdFiles) {
    if (!fs.existsSync(file)) {
      console.error(`File not found: ${file}`);
      fail++;
      continue;
    }
    try {
      await importFile(file);
      ok++;
    } catch (err) {
      console.error(`\nFAILED: ${file}`);
      console.error(err.message);
      fail++;
    }
  }

  console.log(`\n─── Import complete: ${ok} succeeded, ${fail} failed ───`);
  if (fail > 0) process.exit(1);
}

main();
