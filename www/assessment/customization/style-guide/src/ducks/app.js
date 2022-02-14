import { createAsyncThunk, createSlice } from '@reduxjs/toolkit';
import { API_STATES } from "../contants";

export const getJson = createAsyncThunk(
    'gca/app/getJson',
    ( url, thunkAPI) => {
        return thunkAPI.extra.appServices.getJson(url);
    }
);

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
            state.activeSelectors = [];
        },
        setQuestionState: (state,  { payload }) => {
            state.selectedQuestionState = payload;
            state.activeSelectors = [];
        },
        setActiveSelectors: (state,  { payload }) => {
            const { selector } = payload;
            // toggle the selectors
            const selectors = state.activeSelectors;
            if (!selectors.some( item => item.selector === selector )) {
                state.activeSelectors.push(payload);
            } else {
                state.activeSelectors = selectors.filter(item => item.selector !== selector);
            }
        }
    },
    extraReducers: {
        [getJson.pending]: (state) => {
            state.questionTypesConfig = null;
        },
        [getJson.rejected]: (state) => {
            state.questionTypesConfig = null;
        },
        [getJson.fulfilled]: (state, { payload } ) => {
            state.questionTypesConfig = { ...payload };
        }
    },
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
export const getQuestionState = state => state.app.selectedQuestionState  || API_STATES.INITIAL;
export const getQuestionType = state => state.app.selectedQuestionType;
export const getActiveSelectors = state => state.app.activeSelectors;
export const getWidgetQuestion = (state) => {
    const widget = getWidget(state);

    return widget && widget.question;
}
export const getWidgetClassnames = (state) => {
    const widget = getWidget(state);
    const { selectedQuestionState } = state.app;

    if(!widget) return [];

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

export default slice.reducer;
