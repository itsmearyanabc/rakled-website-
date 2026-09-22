# Fonts

Self-hosted, Latin subset, WOFF2.

| File | Family | Use |
|---|---|---|
| `instrument-serif-400.woff2` | Instrument Serif | H1, H2 and large statements (>=40px only) |
| `instrument-serif-400-italic.woff2` | Instrument Serif Italic | reserved |
| `instrument-sans-variable.woff2` | Instrument Sans 400–700 | H3 down, body, all UI |

Both families are licensed under the **SIL Open Font License 1.1**, which
permits self-hosting and commercial use.

They are served from this directory rather than a third-party CDN, so no
visitor request leaves the site's own origin to render text. `inc/enqueue.php`
preloads the two faces used above the fold, and skips any file that is not
present rather than emitting a preload that 404s.

Instrument Serif is a high-contrast display face and becomes thin at small
sizes. `assets/css/02-typography.css` restricts it to the display range for
that reason; H3 and below are set in Instrument Sans.
