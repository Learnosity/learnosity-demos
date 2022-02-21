import { configureStore,  } from '@reduxjs/toolkit';
import questionApiReducer from 'ducks/questionApi';
import appReducer from 'ducks/app';
import questionApiService from "./services/questionApiService";
import appServices from "./services/appServices";

const getMiddleware = () => {
    const services = {};

    services.questionApiService = new questionApiService();
    services.appServices = appServices;

    return services;
};

const localStorageMiddleware = ({ getState }) => {
    return next => action => {
        const result = next(action);
        const { app } = getState();
        const toStore = { ...app, dialog: {
                children: null,
                open: false
            }};

        localStorage.setItem('gcaState', JSON.stringify(toStore));
        return result;
    };
};

const reHydrateStore = () => {
    if (localStorage.getItem('gcaState') !== null) {
        const app = JSON.parse(localStorage.getItem('gcaState'));
        return {
            app
        }
    }
};

export default configureStore({
    reducer: {
        questionApi: questionApiReducer,
        app: appReducer
    },
    preloadedState: reHydrateStore(),
    middleware: getDefaultMiddleware =>
        getDefaultMiddleware({
            thunk: {
                extraArgument: getMiddleware()
            },
            serializableCheck: {
                // Ignore these action types
                ignoredActions: ['gca/questionApi/init/fulfilled','app/setDialog'],
                ignoredActionPaths: ['payload.disable', 'payload.children.$$typeof', 'app.dialog.children.$$typeof']
            }
        }).concat(localStorageMiddleware),
    devTools: true
});
