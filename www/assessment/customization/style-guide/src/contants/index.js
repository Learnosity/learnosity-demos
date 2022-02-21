export const signedRequest = window.lrn_gca_signed_request;

export const API_STATES = {
    INITIAL: 'initial',
    RESUME: 'resume',
    PREVIEW: 'preview',
    REVIEW: 'review'
}

// should be the same order in the highlight.scss
export const highlightColors = ['#bae2ff', '#d8e7ed',
    '#bcffff', '#d8c1dc',
    '#ffe7fa', '#dfa6c2',
    '#fddcda', '#f0c49d',
    '#fffbe2', '#cfffea', '#a1e3a8', '#01FF70', '#d3c4d7'];

export  * from './selectors';

export default {
    API_STATES,
    highlightColors,
    signedRequest
}
