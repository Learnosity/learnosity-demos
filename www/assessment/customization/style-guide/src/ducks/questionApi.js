import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';

export const initQuestionApi = createAsyncThunk(
    'gca/questionApi/init',
    ( signedRequest, thunkAPI) => {
        return thunkAPI.extra.questionApiService.init(signedRequest);
    }
);

export const renderQuestionType = createAsyncThunk(
    'gca/questionApi/render',
    (data, thunkAPI) => {
        return thunkAPI.extra.questionApiService.append(data);
    }
);

const slice = createSlice({
    name: 'questionApi',
    initialState: {
        isAPIready: false,
        isRendered: false
    },
    reducers: {
        setSelectedQuestionTypeIndex: (state,  { payload }) => {
            state.questionTypeIndex = payload
        },
        setSelectedQuestionState: (state,  { payload }) => {
            state.selectedQuestionState = payload
        }
    },
    extraReducers: {
        [initQuestionApi.pending]: (state) => {
            state.isAPIready = false;
        },
        [initQuestionApi.rejected]: (state) => {
            state.isAPIready = false;
        },
        [initQuestionApi.fulfilled]: (state) => {
            state.isAPIready = true;
        },
        [renderQuestionType.pending]: (state) => {
            state.isRendered = false;
        },
        [renderQuestionType.rejected]: (state) => {
            state.isRendered = false;
        },
        [renderQuestionType.fulfilled]: (state) => {
            state.isRendered = true;
        }
    },
});

// actions
export const {
    init,
    setSelectedQuestionTypeIndex,
    setSelectedQuestionState } = slice.actions;

// selectors
export const isApiReady = state => state.questionApi.isAPIready;
export const isRendered = state => state.questionApi.isRendered;

export default slice.reducer;
