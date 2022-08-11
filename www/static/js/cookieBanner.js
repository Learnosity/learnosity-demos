const BANNER_HTML = `
    <div id="lrn-cookie-banner">
        <p>
            By continuing to browse or by clicking "I accept", you consent to the storing of statistics,
            communications, and strictly necessary cookies as set out in our
            <a href="https://learnosity.com/privacy-policy/" target="_new">Privacy Policy.</a>
            You can control your cookie settings below
        </p>
        <div class="lrn-flex-container">
            <button class="lrn-accept-cta lrn-flex-item">I accept</button>
            <button class="lrn-reject-cta lrn-flex-item">Refuse non-essential cookies</button>
        </div>
    </div>
`;
const LRN_COOKIE_KEY = 'lrn_tracking';
const LRN_COOKIE_EXPIRED = 'Thu, 01 Jan 1970 00:00:01 GMT';
const LRN_COOKIE_MAX_AGE = '15778476';
const LRN_COOKIE_PATH = 'path=/';
const LRN_COOKIE_SAME_SITE = 'Strict';


class CookieBanner {
    constructor() {
        const url = new URL(window.location.href);
        const resetConsent = url.searchParams.get('resetConsent');

        if (resetConsent) {
            document.cookie = `${LRN_COOKIE_KEY}=;SameSite=${LRN_COOKIE_SAME_SITE};expires=${LRN_COOKIE_EXPIRED};${LRN_COOKIE_PATH}`;
        }
        const cookiesEnabled = this.getCookieValue(LRN_COOKIE_KEY);

        // If the cookie exists it means the user has already
        // seen the modal and made a choice. Exit the constructor
        // as there is no need for anything else
        if (cookiesEnabled !== undefined) {
            return;
        }
        this.mainElement = document.body;
        this.createElements();
        this.attachEvents();
    }

    createElements() {
        this.mainElement.insertAdjacentHTML('beforeEnd', BANNER_HTML);
        this.activeElement = document.getElementById('lrn-cookie-banner');
        this.acceptButton = this.activeElement.getElementsByClassName('lrn-accept-cta')[0];
        this.rejectButton = this.activeElement.getElementsByClassName('lrn-reject-cta')[0];
    }

    attachEvents() {
        this.acceptButton.addEventListener(
            'click',
            () => {
                this.setCookiePreference(true);
                this.destroy();
                this.reloadPage();
            }
        );
        this.rejectButton.addEventListener(
            'click',
            () => {
                this.setCookiePreference(false);
                this.destroy();
                this.reloadPage();
            }
        );
    }

    // looks like we can blindly apply the hash as its is harmless if
    // it is not defined. This will be needed for the author site
    // integration.
    reloadPage() {
        window.location = window.location.pathname + window.location.hash;
    }

    setCookiePreference(val) {
        document.cookie =
            `${LRN_COOKIE_KEY}=${val};SameSite=${LRN_COOKIE_SAME_SITE};secure;max-age=${LRN_COOKIE_MAX_AGE};path=/`;
    }

    destroy() {
        this.acceptButton.removeEventListener('click', this.setCookiePreference);
        this.rejectButton.removeEventListener('click', this.setCookiePreference);
        this.activeElement.remove();
    }

    getCookiePreference() {
        return this.getCookieValue(LRN_COOKIE_KEY);
    }

    getCookieValue(cookieKey) {
        const match = document.cookie.match(
            new RegExp('(^| )' + cookieKey + '=([^;]+)')
        );

        if (match) {
            return match[2];
        }
    }
}
