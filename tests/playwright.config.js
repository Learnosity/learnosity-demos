// Playwright config for the jQuery 3.7.1 / Bootstrap 3.4.1 upgrade smoke test (LRN-52745).
//
// These tests confirm that the bundled front-end libraries (www/static/dist/all.min.js)
// load and behave correctly after the jQuery 1.11.3 -> 3.7.1 and Bootstrap 3.1.0 -> 3.4.1
// upgrade. They exercise the jQuery-driven UI that the pen-test remediation touched:
// Bootstrap modals, Bootstrap tooltips, and the html5sortable plugin.
//
// The PHP demo server must be running first:
//     make run-php            # serves http://localhost:8080
//
// Then, from the tests/ directory:
//     npm install
//     npx playwright install chromium
//     npx playwright test

const { defineConfig, devices } = require('@playwright/test');

const BASE_URL = process.env.BASE_URL || 'http://localhost:8080';

module.exports = defineConfig({
    testDir: '.',
    // These are DOM/behaviour checks, not flows; keep them quick and fail fast.
    timeout: 30 * 1000,
    expect: { timeout: 5 * 1000 },
    fullyParallel: true,
    reporter: 'list',
    use: {
        baseURL: BASE_URL,
        // The demos require the domain to be exactly "localhost" for Learnosity API
        // signing, and Bootstrap/jQuery are served from the same origin.
        headless: true,
        trace: 'on-first-retry',
    },
    projects: [
        {
            name: 'chromium',
            use: { ...devices['Desktop Chrome'] },
        },
    ],
});
