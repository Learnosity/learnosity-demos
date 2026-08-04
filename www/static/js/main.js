/*
|--------------------------------------------------------------------------
| Site-wide behaviour
|--------------------------------------------------------------------------
|
| Plain ES6 - no jQuery. See docs/bootstrap-5-upgrade.md
|
*/

const FADE_OUT_MS = 500;
const FADE_IN_MS = 500;
const HEADING_FADE_OUT_MS = 100;
const HEADING_FADE_IN_MS = 600;

/**
 * Bootstrap 5 tooltips are opt-in: unlike Bootstrap 3, a data-bs-toggle
 * attribute alone does not wire them up.
 *
 * The toolbar tooltips live on the <a>, not the surrounding <li>, so they can be
 * reached by keyboard. They are keyed off data-bs-title rather than
 * data-bs-toggle="tooltip" because most of those anchors already use
 * data-bs-toggle="modal", and an element can only carry one of them.
 */
function initTooltips () {
    document.querySelectorAll('.toolbar [data-bs-title]')
        .forEach((element) => new bootstrap.Tooltip(element));
}

/**
 * Serialises a nested object into the bracketed form-encoded keys the demo PHP
 * endpoints read out of $_POST, e.g. { request: { items: ['a'] } } becomes
 * "request[items][0]=a". jQuery's $.post/$.ajax did this automatically; fetch does
 * not. Intentionally global so inline page scripts can use it.
 *
 * @param  {*} value
 * @param  {string} [prefix]
 * @param  {URLSearchParams} [params]
 * @return {URLSearchParams}
 */
function toFormParams (value, prefix, params) {
    params = params || new URLSearchParams();
    if (value !== null && typeof value === 'object') {
        Object.entries(value).forEach(([key, inner]) => {
            toFormParams(inner, prefix ? prefix + '[' + key + ']' : key, params);
        });
    } else {
        params.append(prefix, value);
    }
    return params;
}

/**
 * POSTs a nested object to a demo endpoint the way jQuery's $.post did, and returns
 * the parsed JSON response.
 *
 * @param  {string} url
 * @param  {object} data
 * @return {Promise<object>}
 */
async function postForm (url, data) {
    const response = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
        body: toFormParams(data)
    });
    if (!response.ok) {
        throw new Error(url + ' responded ' + response.status);
    }
    return response.json();
}

/**
 * jQuery's .wrap() - puts `element` inside a new div carrying `className`, in place.
 *
 * @param  {HTMLElement} element
 * @param  {string} className
 * @return {HTMLElement} the new wrapper
 */
function wrapWithDiv (element, className) {
    const wrapper = document.createElement('div');
    wrapper.className = className;
    element.replaceWith(wrapper);
    wrapper.appendChild(element);
    return wrapper;
}

/**
 * jQuery's :visible - does the element take up space in the layout?
 */
function isVisible (element) {
    return Boolean(element && (element.offsetWidth || element.offsetHeight));
}

function fadeOut (element, duration) {
    return element.animate({ opacity: [1, 0] }, { duration, fill: 'forwards' }).finished
        .then(() => {
            element.style.display = 'none';
        });
}

function fadeIn (element, duration) {
    element.style.display = '';
    return element.animate({ opacity: [0, 1] }, { duration, fill: 'forwards' }).finished;
}

/**
 * Collapses the page overview into the toolbar, moving its heading up beside
 * the toolbar icons, and expands it again on a second click.
 *
 * Note: nothing in the site currently renders a .jumbotron-toggle element, so
 * this is unreachable. Ported as-is during the Bootstrap 5 upgrade rather than
 * dropped - see the "out of scope" section of docs/bootstrap-5-upgrade.md.
 */
function jumbotronToggle () {
    const toggle = document.querySelector('.jumbotron-toggle');
    const overview = document.querySelector('.overview');
    const toolbar = document.querySelector('.toolbar');
    const heading = document.querySelector('.overview > h1');

    if (!toggle || !overview || !toolbar) {
        return;
    }

    if (isVisible(document.querySelector('.jumbotron h1'))) {
        toggle.classList.add('bi-chevron-down');
        toggle.classList.remove('bi-chevron-up');
        fadeOut(overview, FADE_OUT_MS).then(() => {
            const collapsed = document.createElement('h3');
            collapsed.className = 'float-start';
            collapsed.style.marginTop = '0px';
            collapsed.style.fontWeight = '100';
            collapsed.innerHTML = heading ? heading.innerHTML : '';
            toolbar.prepend(collapsed);
            toolbar.style.display = 'none';
            fadeIn(toolbar, FADE_IN_MS);
        });
    } else {
        toggle.classList.add('bi-chevron-up');
        toggle.classList.remove('bi-chevron-down');
        toolbar.querySelectorAll(':scope > h3')
            .forEach((element) => fadeOut(element, HEADING_FADE_OUT_MS));
        fadeIn(overview, HEADING_FADE_IN_MS);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initTooltips();
    document.querySelectorAll('.jumbotron-toggle')
        .forEach((element) => element.addEventListener('click', jumbotronToggle));
});
