// @ts-check
const { defineConfig } = require('@playwright/test');

/**
 * Playwright config for integration tests that run against the real
 * PHP demo server at http://localhost:8080.
 *
 * Usage:
 *   npx playwright test tests/profanity/author-integration.spec.js --config=playwright.integration.config.js
 *
 * Prerequisites:
 *   The PHP development server must already be running on port 8080:
 *     php -S localhost:8080 -t www
 */
module.exports = defineConfig({
    testDir: './tests/profanity',
    testMatch: 'author-integration.spec.js',
    timeout: 90000,
    use: {
        baseURL: 'http://localhost:8080',
        headless: true
    }
});
