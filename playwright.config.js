// @ts-check
const { defineConfig } = require('@playwright/test');

module.exports = defineConfig({
    testDir: './tests/profanity',
    timeout: 30000,
    use: {
        baseURL: 'http://localhost:8999',
        headless: true
    },
    webServer: {
        command: 'npx serve -l 8999 --no-clipboard',
        port: 8999,
        reuseExistingServer: true
    }
});
