# Rian Cullet — website

Bespoke WordPress theme for Rian Cullet, a Delhi-based glass cullet
collection, sorting, processing and recycling company established in 1995.

No page builder. No CSS framework. No JavaScript libraries.

---

## Installing on a live WordPress site

1. Build the theme zip from the repository root:

   ```bash
   git archive --format=zip --prefix=rian-cullet/ -o rian-cullet.zip HEAD:wp-content/themes/rian-cullet
   ```

2. In wp-admin: **Appearance → Themes → Add New → Upload Theme**, choose
   `rian-cullet.zip`, then **Activate**.
3. A notice appears at the top of wp-admin. Click **Create pages and
   menus**. This creates the six pages, sets the static front page, and
   builds the header and footer menus. It never overwrites a page that
   already exists.
4. **Settings → General → Site Title**: `Rian Cullet`. The header and
   footer wordmark print the site title as live text.
5. If `/about/` does not load, set **Settings → Permalinks** to any
   option other than *Plain*. Most hosts have this on already.

That is the whole setup. The pages need no content: every page is a
template in this theme, so it looks exactly like the design preview
from the moment it is activated.

## Running it locally

### Without Docker (quickest)

Requires Node. Boots a throwaway WordPress in PHP-WASM with the theme
mounted live, the pages created and the menus built:

```bash
npx -y @wp-playground/cli@3.1.40 server --mount-dir wp-content/themes/rian-cullet /wordpress/wp-content/themes/rian-cullet --blueprint tools/playground/blueprint.json
```

Then open http://127.0.0.1:9400. Theme edits show on reload. The site is
discarded when the command stops.

### With Docker

Requires Docker Desktop.

```bash
docker compose up -d
```

Then open http://localhost:8080, complete the WordPress installer and
follow steps 2–5 above (the theme is already mounted, so skip the
upload and just activate it).

The database credentials in `docker-compose.yml` are throwaway values for
a disposable local container. They are not production secrets and must
never be reused on a live host.

### Design preview without WordPress

```bash
node tools/preview-server.js
```

http://localhost:4321 renders `preview/home.html`, which mirrors the
homepage using the real theme CSS and JS. It exists so the design can be
reviewed without a PHP runtime. **WordPress is the source of truth** —
the preview is a review aid and will drift if it is not kept in step.

---

## Layout

```
wp-content/themes/rian-cullet/
├── style.css              theme header only
├── theme.json             editor tokens (palette, type, spacing)
├── functions.php          bootstrap; wiring only
├── inc/
│   ├── helpers.php        rc_figure(), rc_button(), rc_logo_mark(), menus
│   ├── setup.php          theme supports, menus, image sizes, favicons
│   ├── enqueue.php        asset loading, font preload
│   ├── seo.php            title, meta, canonical, Open Graph
│   ├── schema.php         Organization + LocalBusiness JSON-LD
│   ├── enquiry-form.php   form render, validation, storage, mail
│   ├── patterns.php       editor constraints
│   ├── customizer.php     phone + email settings
│   └── starter-content.php  "Create pages and menus" (admin only)
├── template-parts/
│   ├── header/nav.php
│   └── sections/          one file per homepage section
└── assets/
    ├── css/               00-tokens .. 07-motion, in cascade order
    ├── js/                nav, reveal, counters, process (~20KB raw)
    ├── fonts/             self-hosted WOFF2 (see below)
    └── img/               photography, logo mark, favicons

docs/brand/                source logo artwork (not deployed)
tools/playground/          blueprint for the no-Docker local WordPress
tools/preview/             component library mirrored by preview/home.html
```

CSS loads in numbered order and each file declares the previous one as a
dependency, so the cascade cannot be reordered by accident.

---

## Design system

The full token set is `assets/css/00-tokens.css`. Two rules matter most:

**Amber is not a text colour on light backgrounds.** `#C99A3D` on
`#F7F7F2` measures 2.39:1, which fails even the 3:1 large-text threshold.
On light surfaces amber is restricted to rules, dots, underlines and
borders. On `#173C2C` it measures 4.75:1 and passes AA, so it may carry
text there. For amber-toned text on light, use `--rc-amber-ink`.

**Surfaces publish both their foreground and their background.** Any
element that sets `--rc-on-surface` must also set `--rc-surface-bg`, or a
filled button will render its label in the same colour as its fill.

Corner radius is `0` by design. Inputs get `2px`. There are no pills.

---

## Replacing photography

Drop a file into `assets/img/` named after the slot. `rc_figure()` probes
for `.avif`, then `.webp`, then `.jpg` and uses whatever is present. If
nothing is found it renders a labelled placeholder naming the missing
file, so a gap is always visible rather than silent.

| Slot | Ratio | Delivered |
|---|---|---|
| `hero-slide-1` … `hero-slide-4` | 16:9, 2400×1350 | yes |
| `intro-cullet-macro` | 4:5, 1200×1500 | yes |
| `factory-cullet` | 4:5, 1200×1500 | yes |
| `external-cullet` | 4:5, 1200×1500 | yes |
| `clear-glass` | 3:4, 1200×1600 | yes |
| `amber-glass` | 3:4, 1200×1600 | yes |
| `green-glass` | 3:4, 1200×1600 | yes |
| `processing-sorting` | 3:2, 1800×1200 | yes |
| `og-default` | 1200×630 | yes |
| `logo-mark` | the R mark, 192px tall | yes (header + footer) |
| `logo-square-512` | 1:1, 512×512 | yes (structured-data logo) |
| `favicon-32`, `favicon-192`, `apple-touch-icon` | 1:1 | yes |

The current photographs are licensed stock from Unsplash, used as an
interim. They are not Rian Cullet's own facility. See
`docs/photography-shot-list.md` for what to shoot to replace them.

**There is no founder portrait, by decision.** The founder section is
composed as a typographic pause instead: a narrow measure inside a wide
page, bounded by hairlines, closed with a signature block. Nothing in
the layout is waiting on an image that is not coming.

---

## Logo

The source artwork is in `docs/brand/`: the R mark on its own, and the
full lockup (mark, "RIAN CULLETS", tagline, "40+ years" line).

**The site uses the mark only, beside a live-text wordmark.** The header
is transparent over the hero, then turns paper, then charcoal whenever
a dark section passes beneath it. The mark reads on all of those; the
lockup's navy and green lettering disappears on the dark ones. Keeping
the name as text also means it inverts with the header like everything
else, and stays sharp at any size.

To swap the mark without touching code: **Appearance → Customize → Site
Identity → Logo**. Upload the mark alone, not the lockup. A Site Icon set
there also replaces the theme's favicons.

The derived files in `assets/img/` were cut from the source artwork:
trimmed, and near-opaque pixels (alpha 240–254 in the supplied file)
snapped to fully opaque so the mark is not faintly see-through on dark.

---

## The rotating hero

Four slides, defined in `rc_hero_slides()`. Each pairs a photograph with
a brand line, and the order walks the same colour story the rest of the
page tells: mixed cullet, green, amber, clear.

Two motions run, deliberately unalike, so the change never reads as one
single effect:

| | Motion | Timing |
|---|---|---|
| Photography | cross-dissolve, plus a slow continuous scale | 1600ms fade, 9s drift |
| Tagline | leaves upward, next rises from below, line by line, each masked | 520ms out, 420ms handoff, 820ms in |

The tagline is a **handoff, not a cross-fade**: the outgoing lines clear
their mask before the incoming ones arrive. Measured across a change,
the two taglines share the screen for 0ms and the headline is empty for
about 120ms — a beat, not a pause. Running them together instead puts
two headlines in one grid cell and the result is unreadable.

All four taglines sit in a single grid cell, so the headline block is
always as tall as the longest line set and rotating never shifts the
layout.

Slide one carries the primary SEO headline and is the only image loaded
eagerly; the rest are lazy. Every tagline is real text in the DOM, so
the content is complete for crawlers and without JavaScript, where the
hero is simply slide one.

Only the active tagline is exposed to assistive technology. The rest are
`aria-hidden`, so the heading always reads as one line.

**The pause control is required, not decorative.** WCAG 2.2.2 applies to
anything that moves on its own for more than five seconds. The timer
bars double as progress and as direct navigation. Rotation also stops
while the tab is hidden, and under `prefers-reduced-motion` the timer
never starts at all — the hero is slide one, held, with the controls
still available for manual changes.

Add or remove slides with the `rc_hero_slides` filter. With fewer than
two, the controls hide themselves and the hero becomes a still image.

---

## Fonts

Three self-hosted files in `assets/fonts/`, all SIL Open Font License:

```
instrument-serif-400.woff2
instrument-serif-400-italic.woff2
instrument-sans-variable.woff2
```

If any is removed, the fallback stack renders correctly, and
`rc_preload_fonts()` skips preloading any file that is not on disk, so
nothing 404s.

---

## The enquiry form

`POST` to `admin-post.php`, guarded by a nonce, a honeypot field and a
timestamp trap. Both spam traps report success rather than failure, since
telling a bot it failed only teaches it what to change.

Every submission is written to a private `rc_enquiry` post **before** mail
is attempted, and appears under **Enquiries** in wp-admin. Shared-host
mail is unreliable; the database copy is the record of truth.

`From` stays on the site domain so the message satisfies SPF and DMARC.
The sender's address goes in `Reply-To`.

**Before launch, configure SMTP.** PHP `mail()` on shared hosting lands in
spam. Change the recipient with the `rc_enquiry_recipient` filter.

---

## Still outstanding

- **Phone number and email address** — never supplied. Set them under
  **Appearance → Customize → Rian Cullet: contact details**. Until then
  they are omitted from the site *and* from the structured data rather
  than faked.
- **Company name and years: the logo disagrees with the site.** The
  supplied lockup reads "RIAN CULLETS" and "40+ years". The site says
  "Rian Cullet" and derives its years from the 1995 founding date
  (31+ today). One of them needs correcting; the site has not been
  changed until the client confirms which is right. The name shown in
  the header and footer is the WordPress Site Title, so a name change
  needs no code.
- **Privacy policy** — no content. The page is `noindex` while empty.
  WordPress creates it as a draft; **Create pages and menus** publishes
  that draft (empty) so the footer link resolves, unless it has been
  edited.
- **SMTP** — see above; required before launch.

No certifications, capacities, tonnages, client names, export markets or
environmental percentages appear anywhere in this codebase, because none
were provided. Do not add them to the schema without source data.
