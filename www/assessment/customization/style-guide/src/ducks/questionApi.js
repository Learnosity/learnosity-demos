import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';

export const initQuestionApi = createAsyncThunk(
    'gca/questionApi/init',
    ( signedRequest, thunkAPI) => {
        return thunkAPI.extra.questionApiService.init(signedRequest)
            .then(() => {
                // TODO : send notification or UI to show the api is ready
            });
    }
);

export const renderQuestionType = createAsyncThunk(
    'gca/questionApi/render',
    (data, thunkAPI) => {
        return thunkAPI.extra.questionApiService.append(data)
            .then(() => {
                // TODO : send notification or UI to show the question type has been appended
            });
    }
);

const slice = createSlice({
    name: 'questionApi',
    initialState: {
        loading: false,
        selectedQuestionType: null,
        selectedQuestionState: 0,
    },
    reducers: {
        init: (state) => {
            state.isReady = true;
        },
        setSelectedQuestionTypeIndex: (state,  { payload }) => {
            state.questionTypeIndex = payload
        },
        setSelectedQuestionState: (state,  { payload }) => {
            state.selectedQuestionState = payload
        }
    },
    extraReducers: {
        [renderQuestionType.pending]: (state) => {
            state.loading = true;
        },
        [renderQuestionType.rejected]: (state) => {
            state.loading = false;
        },
        [renderQuestionType.fulfilled]: (state) => {
            state.loading = false;
        }
    },
});

// actions
export const {
    init,
    setSelectedQuestionTypeIndex,
    setSelectedQuestionState } = slice.actions

// selectors
export const isReady = state => state.questionApi.isReady;

export default slice.reducer;
