# Front-end upgrade smoke tests (LRN-52745)

Playwright tests that verify the jQuery `1.11.3 → 3.7.1` and Bootstrap `3.1.0 → 3.4.1`
upgrade did not regress the jQuery-driven UI in the demos.

## What they cover

Core suite (offline, no external network):

- The bundled `all.min.js` reports jQuery **3.7.1** and the Bootstrap **3.4.1** plugins
  (modal, tooltip, collapse). — `jquery-bootstrap-upgrade.spec.js`
- Bootstrap **tooltips** initialise and show on the analytics data page.
- Bootstrap **modals** (asset-upload, reports click-events) open and close.
- The **html5sortable** plugin plus the jQuery helpers it relies on (`$.map`, `$.trim`,
  `.data()`, `.appendTo()`) work under jQuery 3.7.1.
- The jqXHR **`.done()`/`.fail()` migration** (jQuery 3 removed `.success()`/`.error()`):
  a jqXHR no longer exposes the removed methods, and the Data API form-submit handlers
  run (with `xhr.php` route-stubbed). — `ajax-callbacks.spec.js`

Opt-in live suite (needs external network + the live Learnosity Data API):

- **Live Data API submit** — the demo form submits for real through `xhr.php` to
  `data.learnosity.com` and the `.done()` handler renders the actual response.
  — `live-dataapi.spec.js` (skipped unless `RUN_LIVE=1`; see below).

> Note: the core suite drives Bootstrap's own plugin API and mounts the real sortable
> fragment rather than depending on live API credentials — it guards the library upgrade,
> not the full user flows. The asset-upload / reports-click-events modals and the
> teacher-scoring submit are triggered by clicking inside live cross-origin Learnosity
> iframes with pre-existing session/report data, so they remain **manual QA** (see the PR
> description checklist). Only the Data API submit is reliably automatable end-to-end.

## Running

From this `tests/` directory:

```bash
npm install
npx playwright install chromium
npm test
```

Playwright starts PHP's built-in server on a random free port automatically (requires
`php` on your PATH) and shuts it down when the run finishes, so no manual server step is
needed.

To run against a server you're already running instead, set `BASE_URL` — this skips the
managed server entirely:

```bash
make run-php                                   # from the repo root, serves :8080
BASE_URL=http://localhost:8080 npm test        # from tests/
```

`php -v` should report PHP 8.1+.

### Live Data API test (opt-in)

The live test is skipped by default so the core suite stays offline-safe. To run it:

```bash
RUN_LIVE=1 npm test                    # whole suite incl. live
RUN_LIVE=1 npx playwright test live-dataapi.spec.js   # just the live test
```

It needs outbound access to `data.learnosity.com` and working demo credentials in
`www/lrn_config.php`. If the API can't be reached (offline, credentials rotated, region
blocked) it **skips** rather than fails, so a network blip won't break the build.
