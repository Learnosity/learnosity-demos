# Bootstrap 5 upgrade

Working spec for the Bootstrap 3 → 5.3 migration on the `bootstrap-upgrade` branch.
Living document — keep the phase checklists and the inventory numbers current as work lands.

## Context

This is a customer-facing demo site (191 PHP files under `www/` and `src/`) still running **Bootstrap 3.1.0**
(2014) and **jQuery 1.11.3** (2015), both vendored under `www/static/vendor/` and concatenated by gulp into
the committed `www/static/dist/all.min.{js,css}` bundle that every page loads via `src/includes/header.php`.

Two problems follow. First, the front-end stack is a decade out of date on a site whose entire purpose is to
show prospective customers what a modern Learnosity integration looks like — and it carries the accessibility
and RTL gaps of its era, which matters because the site ships `rtl.php` demos. Second, the code is pinned to
jQuery 1.x specifically: `www/static/js/dataapi/dataApiRequest.js` calls `.success()`/`.error()` on the
`$.ajax` promise, which jQuery 3 removed — so the stack cannot be nudged forward incrementally.

Goal: Bootstrap 5.3, with **stock ES6 replacing all first-party jQuery**, the site's appearance unchanged,
and nothing deleted.

## Locked decisions

| Decision | Choice |
|---|---|
| Target | Bootstrap **5.3** (`bootstrap.bundle.min.js` — includes Popper, required for tooltips/dropdowns) |
| Rollout | Layered: shell first, **flip the served bundle to BS5 right after the shell layer**, then migrate sections. Un-migrated sections will look broken on the branch in between — accepted. |
| Icons | Vendored **Bootstrap Icons** webfont at `www/static/vendor/bootstrap-icons/` |
| jQuery | **Removed from all first-party code**, replaced with stock ES6. The library files stay in the repo. |
| Visual target | **Preserve the current look.** A visible design change is a regression. |
| Build | Modernise the pipeline; keep committed `dist/` output (the site must run from a clone with no build step) |
| Deletions | **None.** No file removed, no dependency dropped — new deps are added alongside the old. Any deletion needs explicit confirmation first. |

Two more constraints fall out of the codebase itself:

- **Do not rename or move demo files.** `src/includes/nav.php` derives the "View source" link from
  `REQUEST_URI`, so every demo's path under `www/` is also its public GitHub URL. Renames break external links
  — that is what `src/includes/mapping.php`'s redirect table exists to patch up.
- Bump `$assetVersion` in `www/env_config.php` whenever `dist/` is rebuilt, or browsers serve stale bundles.

## Current-state inventory

Measured across `www/` + `src/` `*.php` (191 files), excluding `vendor/` and `dist/`.

### Mechanical — pure find-and-replace, no structural change

| BS3 | BS5 | Occurrences | Files |
|---|---|---|---|
| `data-toggle=` / `data-target=` / `data-dismiss=` / `data-parent=` | `data-bs-*` | 329 / 84 / 22 / 17 | 109 / 81 / 13 / 2 |
| `data-original-title="…"` | `data-bs-title="…"` | 171 | 95 |
| `glyphicon glyphicon-X` | `bi bi-X` | 411 | 104 |
| `text-right` | `text-end` | 108 | 14 |
| `list-inline` | `list-inline` + `list-inline-item` on children | 96 | 96 |
| `pull-right` / `pull-left` | `float-end` / `float-start` | 31 / 3 | 15 / 2 |
| `col-*-offset-N` | `offset-*-N` | 15 | 14 |
| `btn-default` | `btn-outline-secondary` | 11 | 10 |
| `close` (modal ×) | `btn-close` | 10 | 10 |
| `col-xs-N` | `col-N` | 15 | 1 |
| `sr-only` | `visually-hidden` | 5 | 3 |
| `.in` (shown state) | `.show` | 5 in `main.css`, 1 in markup | 2 |
| `<th class="info">` (contextual table cell) | `table-info` | 3 | 1 |
| `table-condensed` | `table-sm` | 1 | 1 |

**Tables needed three fixes beyond the class renames**, found from a report that "Ask Yourself" on
`assessment/inline.php` had lost its blue heading and gained a stray rule:

1. BS3's contextual cell classes were bare words (`.info`, `.success`, `.danger`…) styled via
   `.table > tbody > tr > th.info`. BS5 renames them `.table-*` **and changes the palette** — `.table-info` is
   `#cff4fc` against BS3's `#d9edf7`. BS5 paints the cell with an inset box-shadow driven by `--bs-table-bg`,
   so overriding that variable restores the original colour.
2. **BS3 drew cell separators as `border-top`; BS5 uses `border-bottom`.** Same lines between rows, but BS5
   adds one *under the last row* that BS3 never had. Restored in `main.css`; note
   `.table-bordered > :not(caption) > * > *` is (0,2,1) and still outranks that (0,1,1) rule, so bordered
   tables keep their full box.
3. BS3 set `line-height: 1.428571429` and a 20px table margin on cells; BS5 inherits the body line-height
   (1.6 here) and uses a 16px margin.
4. **BS5 paints a background on every cell; BS3 painted none.** BS5's `.table` sets
   `--bs-table-bg: var(--bs-body-bg)` and each cell gets `background-color: var(--bs-table-bg)`, so anything
   set on the `<tr>` is covered. That silently killed the cut-score row highlighting on
   `analytics/teacher-centric-reporting.php`, which colours whole student rows by performance band via
   `tr[data-custom_performance="N"] { background: … }`. The row background *was* applied — the cells were
   painted white on top of it. Fixed by defaulting `--bs-table-bg` to `transparent` on `.table`.

   This does **not** disturb the contextual or striped variants, which was the thing to get right:
   `.table-info` and friends set `--bs-table-bg` on the cell itself, so they still win over the inherited
   value; and striping/hover come from `--bs-table-bg-type` rendered as an inset `box-shadow`, a separate
   channel entirely. Both were verified after the change.

**The `.in` → `.show` rename is the one to watch.** It is the class Bootstrap's *JavaScript* adds to signal
"shown", so it appears in CSS selectors and in initially-open markup rather than as a static class on a
component — which is why an inventory built by grepping markup missed it. It broke the init-preview modal on
84 pages: BS5 added `.show`, the site's custom `.preview-fade.in` rule never matched, and the modal opened at
`opacity: 0`. Also affected `.dropdown.open` (→ `.dropdown.show`), three `#collapseN.collapse.in` rules, and
one `class="panel-collapse collapse in"` in `www/authoring/custom-qe-layout.php`.

**Modal header order matters now.** BS3's `.close` floated right, so `<button>` before `<h4 class="modal-title">`
rendered correctly. BS5's `.modal-header` is flex and gives `.btn-close` `margin-left: auto`, so a close button
placed *first* drags the title to the right and overlaps it. The title must come first in the DOM. Fixed in 9
modal files; `endtoend-item-preview.php` has no title and is correct as-is.

Only **8 distinct glyphicons** are in use, and 166 of the 411 uses sit in one repeated toolbar snippet:

| BS3 glyphicon | Uses | Bootstrap Icons |
|---|---|---|
| `glyphicon-book` | 86 | `bi-book` |
| `glyphicon-search` | 80 | `bi-search` |
| `glyphicon-question-sign` | 18 | `bi-question-circle-fill` |
| `glyphicon-chevron-down` | 14 | `bi-chevron-down` |
| `glyphicon-move` | 5 | `bi-arrows-move` |
| `glyphicon-list-alt` | 1 | `bi-list-ul` |
| `glyphicon-chevron-right` / `-left` | 1 / 1 | `bi-chevron-right` / `bi-chevron-left` |

`www/static/css/main.css` also colours three glyphicons directly (`.glyphicon-question-sign:before` and
neighbours, ~lines 763–773) — retarget those rules to the `.bi-*` classes.

### Structural — needs hand migration

Clusters into four groups, not 191 scattered files:

| BS3 construct | BS5 | Occ | Where |
|---|---|---|---|
| `panel panel-default` + `panel-heading`/`-body`/`-title` | `card` + `card-header`/`-body`/`-title` | 139 | **18 files**: 13 landing/index pages + 5 settings modals |
| `panel-group` + `panel-collapse` accordion | `accordion` / `accordion-item` / `accordion-button` | 3 / 17 | `www/analytics/data/index.php`, `www/authoring/custom-qe-layout.php` |
| `data-toggle="tab"` nav-tabs | `nav-tabs` + `data-bs-toggle="tab"`, JS via `bootstrap.Tab` | 42 | **14 files**, all `www/analytics/data/{sessions,itembank,scoring}/*.php` |
| `form-horizontal` + `form-group` + `control-label` | grid rows + `form-label` + margin utilities | 19 / 196 / 187 | settings modals + Data API fragments (~20 files) |
| `.checkbox` / `.radio` wrappers | `form-check` + `form-check-input` / `form-check-label` | 43 / 166 | `settings-questioneditor.php` (96), `settings-content-author.php` (66), `settings-items-failed-submit.php` (4) |
| `navbar-toggle` / `navbar-collapse` / `navbar-nav > li > a` | `navbar-toggler` / `collapse navbar-collapse` / `nav-link` | 1 / 1 / 2 | `src/includes/nav.php` only |

Correction to an earlier draft of this document: `well` and `thumbnail` are **not** used as classes
anywhere. The counts came from prose ("as well as") and comments ("question template thumbnails"). There is
no work to do for either.

### `jumbotron` — deliberate exception

`class="jumbotron section"` appears in **123 files** (every demo page) and BS5 removed the component. Rather
than restructure 123 files, keep the class name and promote the 14 `jumbotron` rules already in `main.css`
into a project-owned component, adding the base padding/background BS3 supplied. Zero markup churn, look
preserved exactly.

This is scoped to `.jumbotron` alone. It is **not** a general BS3 compatibility layer — every other removed
class gets migrated properly.

### First-party jQuery to replace with ES6

287 `$(…)` calls across 53 files; 128 files contain inline `<script>` blocks. Dominant idioms, by frequency:

`.attr()` 152 · `.on()` 149 · `.each()` 67 · `.append()` 59 · `.remove()` 57 · `.find()` 51 ·
`.addClass()` 46 · `.html()` 45 · `.val()` 35 · `.click()` 25 · `.trigger()` 23 · `$.each` 22 · `.text()` 22 ·
`.removeClass()` 21 · `.closest()` 16 · `.data()` 15

BS3 plugin calls that must become BS5 constructors: `.modal()` ×7, `.tooltip()` ×3, `.tab()` ×1,
`.collapse()` ×2. Network calls to `fetch`: `$.ajax` ×3, `$.post` ×5, `$.get` ×1.

Already jQuery-free and usable as the house ES6 style: `www/static/js/cookieBanner.js` (ES6 class, template
literals) and `www/static/js/prettyPrint.js`.

## Target stack

Added to `package.json` **alongside** the existing gulp devDependencies (nothing removed):
`bootstrap@^5.3`, `bootstrap-icons`, `esbuild`.

`esbuild` replaces the gulp concat + babel + uglify + clean-css chain with one tool and one command. The
existing `gulpfile.js` and its devDeps stay in the repo per the no-deletion rule; `make update-assets` becomes
the esbuild invocation. Output paths stay `www/static/dist/all.min.{js,css}`, so `src/includes/header.php`
needs no change beyond picking up the icon stylesheet.

New bundle contents — the BS3 and jQuery vendor files remain on disk, simply unbundled:

- **JS**: `bootstrap.bundle.min.js` + `prettyPrint.js` + `main.js` + `cookieBanner.js`
- **CSS**: `bootstrap.min.css` + `bootstrap-icons.min.css` + `main.css`

### How the two stacks coexist

Both bundles are built and committed side by side, and a **single variable selects which one the site serves**:

```php
// www/env_config.php
$assetBundle = 'all.min';       // Bootstrap 3 (gulpfile.js)
                                // 'all.bs5.min' = Bootstrap 5 (build.mjs)
```

`src/includes/header.php` interpolates it into both asset tags, so changing that one line switches every page
at once. Phase 1 flips it; until then the site serves BS3 exactly as before. To preview BS5 mid-Phase-1, edit
it locally without committing.

| Command | Builds | Output |
|---|---|---|
| `make update-assets` / `npm run build` | Bootstrap 5 (`build.mjs`, esbuild) | `dist/all.bs5.min.{js,css}` |
| `make update-assets-legacy` / `npm run build:legacy` | Bootstrap 3 (`gulpfile.js`, gulp) | `dist/all.min.{js,css}` |

**Nothing is copied into `dist/`.** Font and image references resolve relatively from the bundle's own
location, which the build relies on deliberately:

| Reference | Resolves to | Action |
|---|---|---|
| `main.css` → `../fonts/Gilroy-*.otf` | `www/static/fonts/` | correct as-is |
| `main.css` → `../images/*.svg` | `www/static/images/` | correct as-is |
| `bootstrap-icons.min.css` → `fonts/bootstrap-icons.*` | `dist/fonts/` — wrong | rewritten by `build.mjs` to `../vendor/bootstrap-icons/fonts/` |

`build.mjs` throws if that rewrite target is missing, so a future Bootstrap Icons upgrade that changes its
`url()` shape fails the build loudly instead of silently shipping broken icons.

## Execution phases

### Phase 0 — Spec + dependencies ✅
- [x] This spec at `docs/bootstrap-5-upgrade.md`
- [x] Added `bootstrap@5.3.8`, `bootstrap-icons@1.13.1`, `esbuild@0.28.1` to `package.json` devDependencies
      (gulp and babel deps retained untouched)
- [x] Vendored BS5 and Bootstrap Icons under `www/static/vendor/bootstrap5/` and
      `www/static/vendor/bootstrap-icons/`
- [x] `build.mjs` + `make update-assets` (gulp preserved as `make update-assets-legacy`)
- [x] `$assetBundle` switch in `www/env_config.php`, consumed by `src/includes/header.php`
- [x] **Bundle not flipped** — default is still `all.min` (BS3); verified the served markup is unchanged

Known state at the end of Phase 0: `dist/all.bs5.min.js` is built but **not yet loadable**, because `main.js`
still calls jQuery. Phase 1 rewrites it. Nothing loads the BS5 bundle until the flip, so this is inert.

### Phase 1 — Shell, then flip ✅
- [x] Mechanical sweep applied across 139 files (`data-bs-*`, icons, renamed utilities, `list-inline-item`,
      `btn-close`). Four leftovers lived in inline JS as attribute-name *strings* rather than markup and were
      fixed by hand: `analytics/data/index.php`, `usecases/gallery/report.php`,
      `usecases/endtoend/authoring.php`, `usecases/endtoend_customquestion/authoring.php`
- [x] `nav.php` rebuilt as a BS5 navbar, keeping the `<li>`/`<a>` nesting so the existing
      `.navbar li a` and `.navbar-nav > li > a` rules still match. Also fixed a pre-existing malformed
      `<li>` (was never closed)
- [x] `main.js` rewritten in ES6, no jQuery. Tooltips now initialise explicitly via `bootstrap.Tooltip`
- [x] Bootstrap 3 metric-parity block added at the top of `main.css` (see below)
- [x] `src/views/modals/initialisation-preview.php` de-jQueryed — **pulled forward from Phase 3** because it
      is shared scaffolding on 84 pages, so leaving it would have thrown `$ is not defined` site-wide
- [x] Flipped `$assetBundle` to `all.bs5.min` and bumped `$assetVersion`

After the flip, **37 of 174 pages** still contain inline jQuery and will throw on load until Phases 3–5:
`usecases` 22, `assessment` 6, `authoring` 6, `analytics` 3, `partners` 0.

#### The metric-parity block

Bootstrap 3 supplied global metrics this design was built on and never restated. Those are now pinned at the
**top** of `main.css`, so the rest of the file keeps overriding them in the same order it overrode Bootstrap 3.
Do not move this block down the file.

| Pinned | BS3 | BS5 default |
|---|---|---|
| `body` font-size | 14px | 16px |
| Headings h1–h6 | 36/30/24/18/14/12px | 40/32/28/24/20/16px |
| Heading + `p` margins | 20/10px, `0 0 10px` | 0 + `.5rem`, `0 0 1rem` |
| `.container` widths | 750/970/1170px (`width`) | 540–1320px (`max-width`) |
| `.modal-dialog` | 600px (`width`) | 500px (`max-width`) |
| Grid gutter | 30px | 24px |
| `.row` children | float-based, never stretched | flex `align-items: stretch` |
| `.navbar-nav > li > a` padding-y | 15px | 8px |
| `a` text-decoration | none | underline |
| `b`, `strong` | `bold` (absolute) | `bolder` (relative) |
| **root font-size** | **`html { font-size: 62.5% }` → 1rem = 10px** | **not set → 1rem = 16px** |

**The root font-size is the highest-consequence difference in this whole migration.** Bootstrap 3 set
`html { font-size: 62.5% }`, so every `rem` in `main.css` was authored against **1rem = 10px**. BS5 sets no
root font-size, so all of them silently grew by 1.6× — card padding 21.875px → 35px, margins 12.5px → 20px,
and so on across the file.

Setting the root back to 62.5% is *not* an option: BS5's own stylesheet is rem-based throughout, so it would
shrink all of Bootstrap by the same factor. Instead all 26 `rem` values in `main.css` were converted to their
10px equivalents, which renders identically and no longer depends on the root at all. **Do not reintroduce
`rem` into `main.css`** — there is a warning at the top of the file. `em` is fine; it resolves against the
element's own font-size.

Two of these were caught by screenshot diffing rather than by reading the code, and both were site-wide:
BS5 underlines every link, and its relative `bolder` resolves to only 400 inside `.jumbotron p`
(`font-weight: 200`), so `<strong>` silently stopped rendering bold.

**`.row` became a flex container, and stretch makes child heights *definite*.** BS3's `.row` was float-based, so
its children never stretched to a shared height. BS5's is flex with `align-items: stretch`, which sets each
child's cross size from the flex line — a definite height, which then **cannot grow when content arrives
later**. Learnosity's reports render asynchronously, so the container was frozen at its pre-render height and
the report spilled out of the card and into the footer on
`analytics/teacher-centric-reporting.php` (measured: `clientHeight` 850 vs `scrollHeight` 978). `align-items:
flex-start` restores BS3's behaviour. Verified against the landing page card grids first — identical, because
those size themselves with `min-height`, so stretch was never contributing anything there.

**Watch for `width` being clamped by a new `max-width`.** BS3 sized things with `width`; BS5 frequently uses
`max-width`, and since `max-width` wins regardless of source order, this file's widths get silently capped.
It hit `.container` (1440px → full-bleed) and `.modal-dialog` (`width: 70%` → 500px). Both are fixed by
resetting `max-width: none`. A sweep of every `width` rule in `main.css` against BS5's component styles found
no third case, but check this first whenever something renders narrower than expected.

`.jumbotron` is defined in the same region — Bootstrap 3's own rules, re-homed.

#### Known visual deltas (not yet resolved)

1. **The navbar is now a single row.** Bootstrap 3's float-based `.navbar-header` put the logo on its own row
   with the nav beneath it; BS5 lays logo, nav and "View source" out on one flex row, so page content sits
   ~20px higher. Forcing the old wrap was attempted three ways (`flex-basis` and `min-width` on
   `.navbar-collapse`, `flex` on the logo) and each either failed to wrap or clipped "View source" —
   see the comment in `main.css`. Needs a decision: accept the single row, or rework the header markup.
2. **Minor text re-wrap** in the third landing panel (one extra line). Cosmetic, cause not chased.

Two Bootstrap 3 artifacts were *fixed* by the switch: stray list markers beside the nav items, and the toolbar
glyphicons, which were not rendering at all.

Critical files: `src/includes/header.php`, `src/includes/nav.php`, `src/includes/footer.php`,
`www/static/js/main.js`, `www/static/css/main.css`.

- `nav.php`: navbar to BS5 (`navbar-expand-lg`, `navbar-toggler`, `nav-link`, `dropdown-item`). Leave the
  `$pages` array and the `$hasViewSource` / `$santized_url` logic untouched.
- `main.js`: rewrite both functions in ES6. `$('.toolbar li').tooltip()` becomes an explicit `bootstrap.Tooltip`
  loop (BS5 tooltips are opt-in, not automatic). `jumbotronToggle`'s `fadeIn`/`fadeOut` become CSS transitions
  driven by a class.
- `main.css`: own `.jumbotron`, retarget the three glyphicon colour rules, absorb whatever BS3 base styling the
  preserved look depended on. Check `www/static/css/quad.css` (loaded only by
  `www/analytics/live-progress-reporting.php`) for BS3 coupling.
- Run the **mechanical sweep** across all 191 files in this phase — it is find-and-replace, and it is what makes
  the flip survivable for most pages.
- Flip the served bundle to BS5 and bump `$assetVersion`.

### Phase 2 — Landing pages ✅
11 files: `www/index.php`, `www/{assessment,authoring,analytics,usecases,partners}/index.php`, and
`www/usecases/{customquestions,printing,feedback,endtoend,endtoend_customquestion}/index.php`.

- [x] `panel panel-default` → `card`, `panel-heading` → `card-header`, `panel-body` → `card-body`,
      `panel-title` → `card-title` (330 class attributes). The site's own modifier names
      (`main-page-panel`, `panel-short`) are left alone — they are not Bootstrap classes.
- [x] `main.css` rules extended to match both vocabularies, e.g. `.panel .panel-heading, .card .card-header`.
      **The `.panel` halves are still live** because the settings modals (Phase 3) and the Data API accordion
      (Phase 4) still use panel markup. Drop them once those land.
- [x] A `.card` parity block restates BS3's panel metrics through BS5's card custom properties
      (`--bs-card-spacer-*`, `--bs-card-cap-padding-*`, `--bs-card-border-*`).
- [x] All 26 `rem` values in `main.css` converted to px — see the root font-size note above.

#### `.card` was already taken

`main.css` used `.card` for the **gallery** demo's item pods (`www/usecases/gallery/`), unrelated to
Bootstrap. Two consequences:

1. Since the Phase 1 flip those gallery pods had silently been picking up BS5's own `.card` component styles
   (border, `display: flex`) — a live bug nobody had noticed.
2. Its `.card:not(.active) { padding: 25px 0 }` (0,2,0) outranked the migrated landing cards' `.card` (0,1,0),
   hijacking their padding.

Both are fixed by renaming that component to `.gallery-card` / `.gallery-card-active` — 14 selectors in
`main.css` plus the markup and jQuery selectors in `gallery/index.php` and `gallery/report.php`. JavaScript
*variable* names (`$card`, `cardIndex`) were left alone; they are not class names.

**Check for this before adopting any other Bootstrap component name.** `main.css` is a decade of custom CSS and
may well own other names BS5 also defines.

#### Verification

The third landing card measured under both bundles, every value matching: card 401.7×400px, padding
21.875px/18.75px, border 1px #ddd, body width 362.2px, font 18px/28.8px, text block 332.2×115.2px.

### Phase 3 — Settings modals ✅

> **Do not change any input `name` attributes.** `src/utils/settings-override.php` merges `$_POST` into
> `$request` through a per-API `switch ($filter_post['api_type'])` and reads exact names — `regionsSetting`,
> `hide_attribute_group_*`, `ui[public_methods]`, `accordion-order`, and others. Renaming a field silently
> breaks the demo it drives. None were touched.

- [x] `form-horizontal` dropped from all 5 forms (BS5 removed it)
- [x] 94 × `form-group` → `form-group row`; 100 × `control-label` → `col-form-label`
- [x] 11 × `panel panel-info` → `card`, plus `panel-heading`/`panel-body` → `card-header`/`card-body`
- [x] Inline jQuery → ES6 in `settings-items-regions.php`, `settings-questioneditor-v3.php` and
      `endtoend-item-preview.php` (the last needed a `toFormData` helper, since `$.ajax` serialised nested
      objects into `request[items][0]` form keys and `fetch` does not)
- [x] `www/assessment/failed-submission.php` de-jQueryed too — it hosts one of the two reachable modals

Two Bootstrap classes are deliberately kept as **project-owned** names rather than migrated, because BS5
defines neither: `.form-group` (purely for its 15px/18px margin; the row grid now comes from an explicit
`.row` beside it) and BS3's right-aligned label behaviour, restated as `#settings .col-form-label`.

`#settings .card` needs a **reset**. The BS3 markup was `panel panel-info`, which never matched the
`.panel-default` content-card styling, so as a `.card` it would newly inherit the landing pages' min-height,
padding, radius and big shadow. The reset restores the plain white block with a subtle shadow that BS3 rendered.

#### Corrections to this document's original inventory

- **There are no `.radio` or `.checkbox` wrapper classes in the settings modals.** The "166 `.radio` / 43
  `.checkbox`" figures came from grepping `radio"` and `checkbox"`, which matched `type="radio"` attributes.
  Those are bare inputs, which BS3 rendered natively too — so nothing to convert.
- The only real `.checkbox` wrappers (36 inputs) live in `www/analytics/data/**`, i.e. **Phase 4**.
- **6 of the 11 modals are unreferenced**: `settings-assess`, `settings-content-author`,
  `settings-questioneditor`, `settings-questioneditor-v3`, `regions-settings`, `endtoend-item-preview`.
  Only `settings-items-regions` (via `assessment/regions.php`), `asset-upload`, `youtube-embed` and
  `initialisation-preview` are actually reachable.
- `settings-items-failed-submit.php` **is** included by `assessment/failed-submission.php`, but that page has
  no trigger linking to it — only the init-preview button. The modal is unreachable in the UI. Pre-existing.

#### Outstanding: one jQuery holdout

`settings-questioneditor.php` still uses jQuery (10 calls). It loads
`/static/vendor/html5sortable/jquery.sortable.min.js` itself and calls `$('.sortable').sortable()` to let the
user drag attribute-group accordions into a new order, writing the result into the `accordion-order` field
that `settings-override.php` reads. Replacing that with stock ES6 means implementing native HTML5
drag-and-drop reordering.

**Decision: revisit if and when that modal is wired up to a demo.** No page includes it today, so the
drag-and-drop work would be unverifiable, and jQuery is no longer in the bundle — meaning this file is
already non-functional if included as-is. Anyone reconnecting it needs to do the ES6 sortable work first.
This is the only remaining first-party jQuery outside the phases below.

#### Verification

`assessment/regions.php` end to end, with no JS errors: the modal opens, the ES6 `loadRegions` populates all
6 options, the label is right-aligned in a 231px column beside a 231px field column with an 18px row gap, and
the card is reset to `padding: 0` with only the subtle shadow. The **POST round-trip** was exercised too —
selecting "vertical-toolbar" populated the hidden `itemsConfig` field, submitting re-signed the request, and
the re-rendered page's `initializationObject.request.config.regions` came back as the vertical-toolbar layout
instead of `"main"`.

### Phase 4 — Data API cluster ✅
`www/analytics/data/index.php`, the 14 fragments under `sessions/`, `itembank/`, `scoring/`, plus
`www/static/js/dataapi/dataApiRequest.js` (112 lines) and `formToObject.js` (123 lines).

Note the structure: the fragments are **not standalone pages** — `index.php` includes all 14 into one
accordion, which is why `ladda.min.js` is loaded once there and covers every fragment's button.

- [x] Accordion migrated to **cards + collapse**, not BS5's `.accordion` component. `.accordion` brings its own
      chrome (background, borders, and a generated chevron on `.accordion-button`) which would fight the custom
      `.panel-data` styling and double up with the existing `bi-chevron-down` span. Cards + collapse is still an
      idiomatic BS5 pattern and preserves the look. **`data-bs-parent` moved from the trigger to the collapsing
      element** — BS5 reads it there.
- [x] Tabs: 42 items to `<li class="nav-item"><a class="nav-link">`, with `.active` on the link rather than the
      `<li>`, and `role="tablist"` on each `<ul>`
- [x] Forms: `form-horizontal` dropped, 102 × `form-group` → `form-group row`, 87 × `control-label` →
      `col-form-label`
- [x] `dataApiRequest.js` and `formToObject.js` rewritten in ES6. `$.ajax` → `fetch` with `URLSearchParams`;
      `.success()`/`.error()` → `await` + `try`/`catch` (those are jQuery-1.x-only APIs, so this also fixes a
      latent bug); `.tab('show')` → `bootstrap.Tab.getOrCreateInstance(el).show()`;
      `$(document).ajaxStart`/`ajaxStop` → explicit `ladda.start()`/`stop()` around the fetch.
      `Ladda` and `prettyPrint` are not jQuery-dependent and stay.
- [x] `xhr.php` proxy contract untouched — still `endpoint` / `request` / `action` POST fields
- [x] `www/authoring/custom-qe-layout.php` pulled in as well: it held a third `panel-group` accordion, and
      retiring it means **no Bootstrap panel class remains anywhere in the markup**
- [x] The transitional `.panel*` halves of the dual selectors added in Phase 2 are now removed from `main.css`
      (17 selectors)

`.checkbox` is **kept as a project-owned class**, deliberately not migrated to BS5's `.form-check`: BS5 restyles
the checkbox itself with a custom box, where BS3 laid out a native checkbox with a hanging indent. Verified
still rendering natively (`appearance: auto`) with BS3's 20px hanging indent. That makes four owned exceptions
in total — `.jumbotron`, `.form-group`, `.checkbox`, and the `panel-data`/`main-page-panel` modifier names.

#### A regex trap worth knowing

Converting the inactive tabs first failed silently. The pattern used a `[^>]*` lookahead to find
`data-bs-toggle="tab"` on the same tag — but these attributes contain `<?php echo $resource; ?>`, whose `?>`
includes a `>`, so the character class stopped early and only the 14 active tabs converted. **When matching
across an HTML attribute in these templates, remember the value may contain PHP tags.** The fix was to anchor
on the literal `<li><a href="#tab-` prefix instead.

#### Verification

A **live signed round-trip** against the real Data API, with no JS errors: 14 cards each with a
`data-bs-parent` collapse; opening the tags section works; switching to the Request JSON tab fires
`show.bs.tab` and renders 220 characters of request JSON; submitting the form posts through `xhr.php` and the
Response tab auto-activates showing `"status": true, "records": 50`.

### Phase 5 — Remaining inline jQuery ✅
31 files converted. **No first-party jQuery remains in any code the site itself loads.**

Three shared helpers were added to `main.js`, intentionally global so inline page scripts can call them
(esbuild's `transform` keeps top-level names in a classic script, so they survive minification):

| Helper | Replaces |
|---|---|
| `toFormParams` / `postForm` | `$.post`/`$.ajax` bracketed form encoding (`request[items][0]=a`) |
| `wrapWithDiv` | `.wrap()` |
| `fadeIn` / `fadeOut` | `.fadeIn()`/`.fadeOut()` (jQuery's default is 400ms) |

#### What was left, and why

| File(s) | Reason |
|---|---|
| `usecases/customquestions/{custom_percentage_bar,custom_shorttext}{,_q}.js`, `customfeature/simplegallery.js` | Declare their dependency via **`LearnosityAmd.define(['jquery-v1.10.2'], …)`** — the jQuery is supplied by the Learnosity API, not the site, and the custom-question API hands them `options.$el` as a jQuery object by contract. Converting them would break that contract. |
| `custom_{box_whisker,clock,piano}_{q,s}.js` | Minified webpack bundles (they contain lodash). Their `$(` matches are internal identifiers, not jQuery. |
| `src/views/modals/settings-questioneditor.php` | Deferred by decision — needs a native drag-and-drop sortable, and no page includes it. |
| `www/static/js/initCodeMirror.js` | Unreferenced; already out of scope. |

#### Three more BS3→BS5 renames, all hidden in JavaScript

The markup sweep structurally could not see these, since the class names appear as JS string arguments:

- `.addClass('close')` on a dynamically built dismiss button → `btn-close`, dropping the literal `×` (BS5 draws
  its own) and using `aria-label` instead.
- `alert-dismissable` — the misspelling BS3 still accepted. BS5 only defines `alert-dismissible`.
- `jQuery.inArray` → `indexOf`. This one didn't even match a `$(` grep.

#### BS3 modal features BS5 dropped

- **`remote`** (`analytics/reports-click-events.php`) — removed outright. The partial is now fetched and
  injected by hand, and because `innerHTML` does not execute `<script>` tags where jQuery's `.load()` did, the
  injected script element is re-created so the report still initialises.
- **`.modal(options)`** both configured *and* opened the modal; BS5 splits construction from `.show()`.
- **`.unbind('click')`** cleared handlers wholesale, which `removeEventListener` cannot do. Where that idiom
  was used, the existing global handler references are used to detach the previous ones explicitly.

#### Two runtime traps worth remembering

1. **jQuery no-ops on an empty selection; vanilla throws.** `$('#x').find('code').html(…)` silently did nothing
   when the element was gone — and on `analytics/no-ui-reports.php` it *is* gone, because with rendering on the
   Reports API replaces the container's contents. The direct translation threw `Cannot set properties of null`.
   Null checks are not optional padding here; they reproduce jQuery's semantics.
2. **BS5 tooltips cache their title; BS3 re-read it on every show.** `gallery/report.php` updates a tooltip as
   scores arrive, so the instance now needs `setContent()`. An empty `data-bs-title` also breaks construction
   outright: BS5 falls back to the `title` attribute, which is `null`, and fails its own type check — so an
   explicit title string has to be passed.
3. **A CSS class or id selector cannot begin with a digit — but Learnosity ids often do.** jQuery fell back to
   Sizzle, which tolerates it; `querySelectorAll` throws
   `DOMException: '…' is not a valid selector`. So `$('button.' + response_id)` translates to
   `querySelectorAll('button[class~="' + response_id + '"]')`, not `'button.' + response_id`. The same applies
   to `'#' + reference` → `'[id="' + reference + '"]'`. The pre-existing mixed-grading code already used
   `[id="${responseId}"]`, presumably having hit this before. Affected
   `assessment/worked-solutions.php` (a live crash on every Hint click) and `usecases/gallery/report.php`.
   **When translating a jQuery selector built from a runtime id, use an attribute selector.**

#### Learnosity's own CSS outranks ours inside its content

This one is easy to get wrong and worth internalising. The Items API injects a stylesheet at runtime, **after**
our bundle, and its rules are scoped `.lrn …` — specificity (0,2,0). Anything the demo pages inject *into*
Learnosity-rendered content is therefore governed by Learnosity's CSS, not ours, because BS5's component and
utility classes are only (0,1,0).

It bit the Hint button on `assessment/worked-solutions.php`. `.lrn .btn` sets
`border: 1px solid rgba(0,0,0,0)`, so the Phase 1 rename of `btn-default` → `btn-outline-secondary` left the
button as bare text: the outline variant's border colour could not win. **`btn-default` is kept there on
purpose** — Learnosity's stylesheet defines `.lrn .btn-default` (BS5 defines no `.btn-default` at all), giving
`#f0f0f0` / `1px solid #ccc` / `#333`. A button injected into their UI should look like their buttons.

A second, independent cause put it on the wrong line: **BS5 gives every direct child of `.row` `width: 100%`**,
so the injected `<p>` claimed a full row where BS3's floats let its content sit beside the column. `col-auto`
restores that.

Audited the rest of the injected markup: the alerts on `distractors.php`, `locking-questions.php`,
`failed-submission.php` and `endtoend-item-preview.php` all land inside `.lrn` and pick up Learnosity's
BS3-era `.alert-*` colours — which they always did, so no regression. The `endtoend*/authoring.php`
notifications and `gallery/index.php`'s Close button are outside `.lrn` and are styled by BS5 as intended
(confirmed: that Close button computes to BS5's `#6c757d` outline).

#### Verification

Two mechanical gates, both worth keeping:

- **Inline-script syntax check** — extracts every inline `<script>` from the demo pages, substitutes PHP
  placeholders, and parses each with node's `vm`. 132 blocks parse cleanly. It skips `text/template` blocks
  (HTML), `type="module"` blocks, and tags whose attributes are PHP-generated. This caught brace-nesting errors
  in three files where a one-level jQuery callback became a two-level `forEach` + `addEventListener` — `php -l`
  cannot see those.
- **Runtime error sweep** — drives a real browser over 25 converted pages and reports uncaught exceptions,
  filtering noise from the Learnosity APIs themselves. This is what found both runtime traps above. Static
  checks would not have.

### Phase 6 — Accessibility pass ✅

- [x] **167 tooltips moved from the `<li>` to the `<a>`** across 93 files. A tooltip on a non-focusable element
      is unreachable by keyboard. They are keyed off `data-bs-title` rather than `data-bs-toggle="tooltip"`
      because most of those anchors already carry `data-bs-toggle="modal"`, and an element can only have one —
      `main.js` constructs them from `.toolbar [data-bs-title]`, which BS5 requires anyway.
- [x] **88 icon-only links given an `aria-label`**, and 86 redundant `title` attributes removed (they raised a
      second, native browser tooltip alongside ours)
- [x] **172 decorative icons marked `aria-hidden="true"`** — deliberately skipping any that carry a tooltip or
      title, since those convey the information themselves
- [x] **17 help icons made focusable** with `tabindex="0"`; their tooltips sat on a `<span>`, which is BS5's
      documented case for exactly that
- [x] **`data-placement` → `data-bs-placement`** (17) — another BS3 plugin option the Phase 1 sweep missed
- [x] **42 tab links and 42 panes given full ARIA**: `role="tab"` / `role="tabpanel"`, `aria-controls`,
      `aria-selected`, `aria-labelledby`, `role="presentation"` on the `<li>`, and `tabindex="0"` on panels
- [x] **7 modals given `aria-labelledby`** pointing at their title (plus `tabindex="-1"` where missing)

**RTL turned out to be a non-item.** The `rtl.php` / `rtl-activity-list.php` demos set `data-lrn-dir="rtl"` on
the Learnosity script tag, so the API handles direction inside *its own* content while the page chrome stays
LTR — that is the point of the demo. Loading `bootstrap.rtl.css` or setting `dir="rtl"` on the document would
change the LTR chrome, so there is nothing to do.

#### KNOWN UPSTREAM DEFECT: Learnosity's report bundles expect a global `$`

**Not worked around here — this is Learnosity's to fix.** Recorded so nobody re-diagnoses it.

Two of Learnosity's report bundles call a bare global **`$.isEmptyObject()`**:

```js
// lastScoreByItemByUser.js
n.$el.html(…), $.isEmptyObject(l) || n.bindTooltips(), l.useSVG || n.renderTrafficLights()
// lastScoreByTagByUser.js
e.$el.html(…), $.isEmptyObject(t) || (e.bindTooltips(), e.renderProgressBars())
```

They use their own bundled jQuery for `n.$el` and everywhere else, so depending on the *host page* to provide a
global is an oversight on their side. It was masked until now only because the demo site happened to load
jQuery for Bootstrap 3.

**Symptom:** `ReferenceError: $ is not defined` — 11 uncaught exceptions on
`/analytics/teacher-centric-reporting.php`. Because the throw lands mid-statement, the calls after it are
skipped: `bindTooltips()`, and `renderTrafficLights()` / `renderProgressBars()`. The report table itself still
renders, since `n.$el.html(…)` runs first.

**Affected report types:** `lastscore-by-item-by-user`, `lastscore-by-tag-by-user`. The other nine report
bundles the demos use contain no bare `$` and are unaffected.

`$.isEmptyObject` is the only jQuery API those two bundles touch, so the fix upstream is small — either use
their own bundled jQuery reference or drop the call. **Report to Learnosity.** Do not shim it here: a global
`$` on a site that has deliberately removed jQuery would mask genuine regressions in first-party code.

#### Verification

Driven through the browser's own accessibility tree (`Accessibility.getFullAXTree`), not inferred from markup:

- **0 interactive nodes without an accessible name** on every page checked
- Toolbar triggers: all are `<a href>`, all have an `aria-label`, all have a live `Tooltip` instance
- **Tooltips confirmed to appear on real keyboard focus** — dispatching 8 `Tab` keypresses reaches the trigger
  and the tooltip renders. Worth noting that a programmatic `element.focus()` does *not* show it in headless
  Chrome, which looked like a failure until tested with actual key events
- Data API tabs (with a section expanded): 3 × `role=tab` named "Request Form" / "Request JSON" / "Response",
  `aria-selected` on all three, panel labelled
- Settings modal: `role=dialog` with the accessible name "Items API – Custom Settings"

One pre-existing `Uncaught (in promise)` on `/analytics/student-centric-reporting.php` is **not** a regression —
it reproduces identically on the Bootstrap 3 bundle with real jQuery present.

## Explicitly out of scope

Unreferenced but retained untouched per the no-deletion rule, recorded here so a future cleanup has the
evidence: `www/static/js/initCodeMirror.js` (9 jQuery calls, loaded by nothing), and the vendored
`codemirror/`, `html5sortable/jquery.sortable.min.js`, `reveal/`, `head.min.js`, `underscore.min.js`.

Also retained: `www/static/vendor/bootstrap/` (BS3), `www/static/vendor/jquery/`, `gulpfile.js` and its devDeps.

`www/static/vendor/{ace,pdf.js,ladda}` are genuinely used (1–2 pages each) and are not jQuery-dependent — no
work needed.

## Verification

There is no test suite. `make lint` (`php -l` over `src/` and `www/`) is the only automated gate, and it only
catches PHP syntax errors — it will not catch a broken layout.

Per phase:

1. `make lint`
2. `make update-assets`, confirm `dist/` regenerated, bump `$assetVersion`
3. `make run-php` and browse **`http://localhost:8080`** — not `127.0.0.1`. The Learnosity signature includes
   the domain and only `localhost` / `*.learnosity.com` are whitelisted; any other host is rejected by the APIs
   (`header.php` prints a warning banner for it)
4. Browser console must be clean — a leftover `$(…)` on a de-jQueryed page surfaces as `$ is not defined`
5. Visual diff against the pre-migration site (screenshot the same page from `develop` and from the branch)

Representative pages — each exercises a distinct cluster:

| Cluster | Page |
|---|---|
| Shell / flip | `/` and any demo, e.g. `/assessment/assess.php` (toolbar tooltips, init-preview modal) |
| Landing | `/assessment/index.php`, `/usecases/index.php` (card grids) |
| Settings modals | `/assessment/regions.php` — the only page using `settings-override.php` — plus a Question Editor demo for `settings-questioneditor.php` |
| Data API | `/analytics/data/index.php` — accordion, tabs, `ladda` spinners; submit at least one request and confirm the Response tab renders through `xhr.php` |
| Reports | `/analytics/live-progress-reporting.php` (the only `quad.css` consumer) |
| Collapse | `/authoring/custom-qe-layout.php` |
| Keyboard / a11y | Toolbar tooltips and one modal (Phase 6) |

Because Phase 1 flips the bundle before Phases 2–5 land, expect known-broken layouts on the branch in
between. The checklist above is the definition of done for each phase, not a gate on the flip.
