export const delay = (ms = 1000) => new Promise((resolve) => setTimeout(resolve, ms));

export const  waitElementToExist = (selector, parent = document.body) => {
    return new Promise(resolve => {
        if (document.querySelector(selector)) {
            return resolve(document.querySelector(selector));
        }

        const observer = new MutationObserver(mutations => {
            if (document.querySelector(selector)) {
                resolve(document.querySelector(selector));
                observer.disconnect();
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    });
}

export default {
    delay,
    waitElementToExist
}
