/*
|--------------------------------------------------------------------------
| Front-end asset build (Bootstrap 5)
|--------------------------------------------------------------------------
|
| Concatenates and minifies the front-end assets into the committed bundle
| under www/static/dist/. Replaces the gulp pipeline in gulpfile.js, which
| is retained for the legacy Bootstrap 3 bundle (`make update-assets-legacy`).
|
| Usage: node build.mjs        (or `make update-assets`)
|
| The output is committed to the repository on purpose: the demo site must
| run straight from a clone with no build step. After rebuilding, bump
| $assetVersion in www/env_config.php to bust browser caches.
|
*/

import { readFile, writeFile } from 'node:fs/promises';
import { transform } from 'esbuild';

const DIST = './www/static/dist';

// Bundle basename. Bootstrap 3 (gulp) owns 'all.min'; Bootstrap 5 is served
// once $assetBundle in www/env_config.php is pointed at this name.
const BUNDLE = 'all.bs5.min';

// Bootstrap must come first: it defines window.bootstrap, which main.js uses.
const SCRIPTS = [
    './www/static/vendor/bootstrap5/js/bootstrap.bundle.min.js',
    './www/static/js/prettyPrint.js',
    './www/static/js/main.js',
    './www/static/js/cookieBanner.js'
];

const STYLES = [
    './www/static/vendor/bootstrap5/css/bootstrap.min.css',
    './www/static/vendor/bootstrap-icons/bootstrap-icons.min.css',
    './www/static/css/main.css'
];

/*
| Font and image paths are left to resolve relatively from the bundle's own
| location (www/static/dist/), which is why nothing is copied into dist/:
|   main.css        ../fonts/Gilroy-*.otf   -> www/static/fonts/       (correct as-is)
|   main.css        ../images/*.svg         -> www/static/images/      (correct as-is)
|   bootstrap-icons fonts/bootstrap-icons.* -> dist/fonts/             (needs rewriting)
*/
const CSS_REWRITES = [
    ['url("fonts/bootstrap-icons.', 'url("../vendor/bootstrap-icons/fonts/bootstrap-icons.']
];

async function concat (files) {
    const parts = await Promise.all(files.map((file) => readFile(file, 'utf8')));
    return parts.join('\n');
}

async function scripts () {
    const source = await concat(SCRIPTS);
    // ES2020 keeps the ES6 we write (classes, template literals, arrow functions)
    // intact. Bootstrap 5 dropped IE support, so there is nothing to transpile for.
    const { code } = await transform(source, { loader: 'js', minify: true, target: 'es2020' });
    await writeFile(`${DIST}/${BUNDLE}.js`, code);
    return `${BUNDLE}.js`;
}

async function styles () {
    let source = await concat(STYLES);
    for (const [from, to] of CSS_REWRITES) {
        if (!source.includes(from)) {
            throw new Error(`CSS rewrite target not found, check vendored asset versions: ${from}`);
        }
        source = source.replaceAll(from, to);
    }
    const { code } = await transform(source, { loader: 'css', minify: true });
    await writeFile(`${DIST}/${BUNDLE}.css`, code);
    return `${BUNDLE}.css`;
}

for (const build of [scripts, styles]) {
    const name = await build();
    const { size } = await readFile(`${DIST}/${name}`).then((buffer) => ({ size: buffer.length }));
    console.log(`${DIST}/${name}  ${(size / 1024).toFixed(1)} KB`);
}
