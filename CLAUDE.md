# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A PHP 8.1+ static-ish demo site (no framework, no build step for PHP) showing minimal integrations of the
Learnosity APIs (Items, Assess, Author, Question Editor, Reports, Data, Grading, Events). Each demo page is
one self-contained PHP file whose job is to build a request object, sign it with the Learnosity PHP SDK, and
hand it to the corresponding JS API. Demos require an internet connection — all APIs are hosted by Learnosity.

## Commands

```bash
make run-php              # composer install + php -S localhost:8080 --docroot www
make run-php PORT=8000    # custom port
make lint                 # php -l over every .php in src/ and www/ (the only check that exists)
make update-assets        # npm install + gulp → rebuilds www/static/dist/all.min.{js,css}
make clean                # rm vendor/, composer.phar, node_modules/
```

There is no test suite (`npm test` is a stub). `make lint` is the full CI-equivalent gate.

**Always browse via `localhost`, never `127.0.0.1` or a LAN IP.** The signature includes the domain and
Learnosity only whitelists `localhost` and `*.learnosity.com`; other hosts get rejected by the APIs (the
header prints a warning banner for them).

## Layout and include mechanics

- `www/` is the docroot; every file under it is a routable URL. `src/` holds shared, non-routable code.
- `www/env_config.php` pushes both `www/` and `src/` onto `include_path`. That is why demos write
  `include_once 'includes/header.php'` (→ `src/includes/header.php`), `'views/modals/…'`, `'utils/…'` with no
  relative path, while `env_config.php`/`lrn_config.php` themselves are included with an explicit `../`
  (or `../../` from nested dirs). Including `env_config.php` first is mandatory or nothing else resolves.
- `vendor/` is committed on purpose (the site should run straight from a clone). The SDK actually loaded is
  `vendor/learnosity/learnosity-sdk-php`, autoloaded from the tail of `lrn_config.php`. `src/sdk` is a git
  submodule that is normally left un-checked-out — don't assume it's populated.

## The demo page contract

Nearly all pages follow this order; deviating breaks the shared scaffolding:

```php
include_once '../env_config.php';       // include_path + $assetVersion
include_once 'includes/header.php';     // <head>, nav, opens .container
include_once '../lrn_config.php';       // consumer keys, $domain, $url_* , SDK autoload
// build $security + $request …
$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();
// …HTML with the API's mount div…
<script src="<?php echo $url_items; ?>"></script>   // never hardcode API script URLs
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
```

- The signed init object **must** be in a variable named `$signedRequest` — `initialisation-preview.php`
  (the magnifying-glass toolbar modal, used by ~84 pages) `die()`s otherwise.
- Every API script URL comes from a `$url_*` var in `lrn_config.php`, all suffixed with `$lts_version`
  (currently `v2026.2.LTS`). Bumping the API version for the whole site = editing that one constant.

## Config and credentials

`www/lrn_config.php` carries the public demo consumer key/secret plus a second `*_postgres` pair used by
specific endpoints (e.g. feedback). Local overrides go in `www/config_override.php` (gitignored, sourced at
the end of `lrn_config.php`) — prefer that over editing `lrn_config.php` when experimenting.

## Cross-cutting pieces worth knowing before editing

- **Data API is always server-side.** Browser code POSTs `endpoint` + `request` + `action` to
  `www/analytics/data/xhr.php`, which validates the scheme/host against `$url_data` before signing and
  proxying via `DataApi`. JS helpers: `www/static/js/dataapi/`. Never sign a Data API request in JS.
- **Interactive settings panels**: `src/views/modals/settings-*.php` render a form that POSTs back to the same
  demo page; `src/utils/settings-override.php` then merges `$_POST` into `$request` with per-API special
  cases keyed on `api_type`. If you add a settings field, its handling likely belongs in that switch.
- **Front-end assets are committed build output.** `gulpfile.js` concatenates `www/static/vendor/*` +
  `www/static/{js,css}/*` into `www/static/dist/all.min.{js,css}`; the header only ever loads the dist
  bundle. Edit the sources, run `make update-assets`, and commit the regenerated dist files. Bump
  `$assetVersion` in `env_config.php` to bust caches. The stack is jQuery 1.11 + Bootstrap 3.
- **Navigation is hand-maintained.** Top nav sections live in the `$pages` array in `src/includes/nav.php`;
  each section's `index.php` (`www/{authoring,assessment,analytics,usecases,partners}/index.php`) is a
  hand-written grid of Bootstrap panels linking to demos. A new demo file is invisible until you add its
  panel there.
- **"View source"** in the nav derives a github.com/Learnosity/learnosity-demos URL from `REQUEST_URI`, so a
  demo's path under `www/` is also its public source URL — renaming/moving a demo breaks external links, which
  is what `src/includes/mapping.php` (302 redirect table, included by `index.php` and `custom_404.php`) exists
  to patch up. Add moved/renamed paths there.

## Conventions

- Commit messages are tag-prefixed: `[FEATURE]`, `[DEMO]`, `[BUG]`, `[UPGRADE]`, `[MAINTENANCE]`, `[CLEANUP]`,
  `[DOC]`, with the Jira key appended (`LRN-#####`). Branches are `LRN-#####/<type>/<slug>`; PRs target
  `develop`. Version bumps land as `[UPGRADE] Upgrade to vYYYY.N.lts` touching `$lts_version`.
- Demo request objects use anonymized/placeholder identity data (`ANONYMIZED_USER_ID`, `Uuid::generate()` for
  `session_id`) and inline comments linking to the relevant reference docs — keep that style.
