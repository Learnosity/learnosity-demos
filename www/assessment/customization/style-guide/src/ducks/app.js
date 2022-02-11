import { createSlice } from '@reduxjs/toolkit';

const slice = createSlice({
    name: 'app',
    initialState: {
        questionTypesConfig: null,
        selectedQuestionType: '',
        selectedQuestionState: 'initial',
        snackbar: {
            open: false,
            text: '',
            severity: 'success'
        },
        dialog: {
            children: null,
            title: 'Alert',
            closeLabel: 'Close',
            open: false
        },
        activeSelectors: []
    },
    reducers: {
        loadJson: (state,  { payload }) => {
            state.questionTypesConfig = { ...payload };
        },
        setSnackbar: (state,  { payload }) => {
            state.snackbar = {...state.snackbar, ...payload};;
        },
        setDialog: (state,  { payload }) => {
            state.dialog = {...state.dialog, ...payload};
        },
        setQuestionType: (state,  { payload }) => {
            state.selectedQuestionType = payload;
        },
        setQuestionState: (state,  { payload }) => {
            state.selectedQuestionState = payload;
            state.activeSelectors = [];
            // remove the classNames old styles
            const classNames =  getClassnames(state);
            if( classNames.length ) {
                classNames.forEach( i => {
                    delete i.oldStyle
                });
            }
        },
        setActiveSelectors: (state,  { payload: { selector, oldStyle }}) => {
            // override the className with oldStyle
            const className =  getClassnames(state).find( i => i.source === selector);
            if( oldStyle && className ) {
                className.oldStyle = oldStyle;
            }

            // toggle the selectors
            const selectors = state.activeSelectors;
            if (selectors.indexOf(selector) < 0) {
                state.activeSelectors.push(selector);
            } else {
                state.activeSelectors = selectors.filter(i => i!== selector);
            }
        }
    }
});

// actions
export const { loadJson,
    setQuestionType,
    setQuestionState,
    setActiveSelectors,
    setSnackbar,
    setDialog } = slice.actions

// selectors
export const getQuestionTypesConfig = state => state.app.questionTypesConfig;
export const isConfigReady = state => !!state.app.questionTypesConfig;
export const getWidget = state => {
    const { selectedQuestionType } = state.app;
    if(!selectedQuestionType) return null;

    const { questionTypes } = state.app.questionTypesConfig;
    const questionType =  questionTypes.find(({ type }) => type === selectedQuestionType);

    return questionType;
}
export const getQuestionState = state => state.app.selectedQuestionState;
export const getQuestionType = state => state.app.selectedQuestionType;
export const getActiveSelectors = state => state.app.activeSelectors;
export const getWidgetQuestion = (state) => {
    const widget = getWidget(state);

    return widget && widget.question;
}
export const getWidgetClassnames = (state) => {
    const widget = getWidget(state);
    const { selectedQuestionState } = state.app;

    if(!selectedQuestionState || !widget) return [];

    const widgets = widget.widgets || [];
    const widgetByState = widgets.find(({ state }) => state === selectedQuestionState);

    return widgetByState ? widgetByState.classnames : [] ;
}
export const getCategories = (state) => {
    if(!state.app || !state.app.questionTypesConfig) return [];

    const { questionTypes } = state.app.questionTypesConfig;
    return questionTypes.map(({ type, label }) => ({ value: type, label }));
}
export const getSnackbar = state =>  state.app.snackbar;
export const getDialogProps = state => state.app.dialog;

// helpers
const getClassnames = state => {
    const { questionTypes } = state.questionTypesConfig;
    const questionType =  questionTypes.find(({ type }) => type === state.selectedQuestionType);
    const widgetByState = (questionType.widgets || []).find((i ) => i.state === state.selectedQuestionState);
    return widgetByState && widgetByState.classnames || [];
}



export default slice.reducer;
