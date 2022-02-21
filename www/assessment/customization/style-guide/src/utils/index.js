export const getUrlParams = (param) => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param) || '';
}

const getRandomNumber = (min1, max1) => {
    const min = Math.ceil(min1);
    const max = Math.floor(max1);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

export const getRandomColourIndex = () => {
    const colors = ['#bae2ff', '#7FDBFF',
        '#39CCCC', '#B10DC9',
        '#F012BE', '#85144b',
        '#FF4136', '#FF851B',
        '#FFDC00', '#3D9970', '#2ECC40', '#01FF70'];

    const index = getRandomNumber(0, colors.length);

    return index + 1;
}

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
    waitElementToExist,
    getUrlParams
}
