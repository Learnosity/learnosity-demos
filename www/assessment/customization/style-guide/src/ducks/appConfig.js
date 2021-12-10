import { createSlice } from '@reduxjs/toolkit';

const slice = createSlice({
    name: 'appConfig',
    initialState: {
     questionConfig: {}
    },
    reducers: {
        loadJson: (state, { payload }) => {
            // TODO: in case we need to normalize
            state.questionConfig = payload;
        }
    }
});

// actions
export const { loadJson } = slice.actions

// selectors
export const getQuestionConfig = state => state.appConfig.questionConfig;
export const getWidgetByIndex = (state, index) => {
    const { questionTypes } = state.appConfig.questionConfig;
    // #TODO : should also map the other question type
    const selectedQuestionType = 'mcq';
    // #TODO: use lodash
    const questionTypeWidgets =  questionTypes.find(({ type }) => type === selectedQuestionType).widgets;

    return questionTypeWidgets[index] && questionTypeWidgets[index].question;
}

export default slice.reducer;
