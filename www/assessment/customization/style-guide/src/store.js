import { configureStore,  } from '@reduxjs/toolkit';
import questionApiReducer from 'ducks/questionApi';
import appConfig from 'ducks/appConfig';
import questionApiService from "./services/questionApiService";

const getMiddleware = () => {
    const services = {};

    services.questionApiService = new questionApiService();

    return services;
};

export default configureStore({
    reducer: {
        questionApi: questionApiReducer,
        appConfig: appConfig
    },
    middleware: getDefaultMiddleware =>
        getDefaultMiddleware({
            thunk: {
                extraArgument: getMiddleware()
            }
        }),
    devTools: true
});
