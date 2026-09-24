// Playwright config for the jQuery 3.7.1 / Bootstrap 3.4.1 upgrade smoke test (LRN-52745).
//
// These tests confirm that the bundled front-end libraries (www/static/dist/all.min.js)
// load and behave correctly after the jQuery 1.11.3 -> 3.7.1 and Bootstrap 3.1.0 -> 3.4.1
// upgrade. They exercise the jQuery-driven UI that the pen-test remediation touched:
// Bootstrap modals, Bootstrap tooltips, and the html5sortable plugin.
//
// Playwright starts the PHP demo server automatically (see the webServer block below) on a
// RANDOM free port, so it never collides with anything you already have running. From the
// tests/ directory you only need:
//     npm install
//     npx playwright install chromium
//     npx playwright test
//
// To run against an already-running server instead, set BASE_URL, e.g.
//     BASE_URL=http://localhost:8000 npx playwright test
// When BASE_URL is set, the managed server is not started (Playwright reuses whatever is
// listening there).

const { defineConfig, devices } = require('@playwright/test');
const net = require('net');
const path = require('path');

// Host must be exactly "localhost" for Learnosity API signing in the demos.
const HOST = 'localhost';

// docroot is www/ at the repo root (one level up from tests/).
const REPO_ROOT = path.resolve(__dirname, '..');

// Grab a free ephemeral port from the OS: open a throwaway listener on port 0, read back the
// assigned port, release it. Bound to 127.0.0.1 so it maps to localhost. There's a tiny
// window between close and PHP binding, but on an ephemeral port collisions are ~nil.
function findFreePort() {
    return new Promise((resolve, reject) => {
        const srv = net.createServer();
        srv.unref();
        srv.on('error', reject);
        srv.listen(0, '127.0.0.1', () => {
            const { port } = srv.address();
            srv.close(() => resolve(port));
        });
    });
}

// Playwright evaluates this config in more than one process (runner + workers) and may load
// it more than once. We must resolve the SAME port every time, or the webServer and the
// tests end up on different ports. Cache the chosen port in an env var so every subsequent
// load in this process tree reuses it. The very first load (no BASE_URL, no cached port)
// picks a fresh one.
async function resolvePort() {
    if (process.env.PW_PHP_PORT) {
        return Number(process.env.PW_PHP_PORT);
    }
    const port = await findFreePort();
    process.env.PW_PHP_PORT = String(port);
    return port;
}

module.exports = (async () => {
    // If the caller pins BASE_URL, respect it and don't manage a server.
    const externalBaseUrl = process.env.BASE_URL;
    const port = externalBaseUrl ? null : await resolvePort();
    const baseURL = externalBaseUrl || `http://${HOST}:${port}`;

    return defineConfig({
        testDir: '.',
        // These are DOM/behaviour checks, not flows; keep them quick and fail fast.
        timeout: 30 * 1000,
        expect: { timeout: 5 * 1000 },
        fullyParallel: true,
        reporter: 'list',
        use: {
            baseURL,
            headless: true,
            trace: 'on-first-retry',
        },
        projects: [
            {
                name: 'chromium',
                use: { ...devices['Desktop Chrome'] },
            },
        ],
        // Start PHP's built-in server on the chosen random port before the tests, and shut it
        // down after. Skipped entirely when BASE_URL is provided.
        ...(externalBaseUrl
            ? {}
            : {
                  webServer: {
                      command: `php -S ${HOST}:${port} --docroot www`,
                      cwd: REPO_ROOT,
                      url: baseURL,
                      timeout: 30 * 1000,
                      // Random port, so there's never an existing server to reuse.
                      reuseExistingServer: false,
                      stdout: 'pipe',
                      stderr: 'pipe',
                  },
              }),
    });
})();
