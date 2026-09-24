# Front-end upgrade smoke tests (LRN-52745)

Playwright tests that verify the jQuery `1.11.3 → 3.7.1` and Bootstrap `3.1.0 → 3.4.1`
upgrade did not regress the jQuery-driven UI in the demos.

## What they cover

- The bundled `all.min.js` reports jQuery **3.7.1** and the Bootstrap **3.4.1** plugins
  (modal, tooltip, collapse).
- Bootstrap **tooltips** initialise and show on the analytics data page.
- Bootstrap **modals** (asset-upload, reports click-events) open and close.
- The **html5sortable** plugin plus the jQuery helpers it relies on (`$.map`, `$.trim`,
  `.data()`, `.appendTo()`) work under jQuery 3.7.1.

> Note: the asset-upload and reports modals are normally opened by the live Learnosity
> Author/Reports APIs, and the question-editor sortable modal is not wired to any served
> page. Rather than depend on live API credentials, the tests drive Bootstrap's own
> plugin API and mount the real sortable fragment. The intent is to guard the library
> upgrade, not the full user flows.

## Running

1. Start the demo server from the repo root:

   ```bash
   make run-php          # serves http://localhost:8080
   ```

2. In another terminal, from this `tests/` directory:

   ```bash
   npm install
   npx playwright install chromium
   npm test
   ```

Override the target with `BASE_URL`, e.g. `BASE_URL=http://localhost:8000 npm test`.
