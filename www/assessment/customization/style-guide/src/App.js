import React from 'react';
import {useDispatch, useSelector} from 'react-redux';
import './assets/scss/app.scss';
import {getQuestionTypesConfig, isConfigReady, loadJson} from './ducks/app';
import configJson from 'config.json';
import Header from "./components/Header";
import Toolbar from "./components/Toolbar";
import Main from "./components/Main";
import { initQuestionApi, isApiReady } from "./ducks/questionApi";
import { signedRequest } from "./contants";
import SnackbarAlert from "./components/SnackbarAlert";
import Dialog from "./components/Dialog";
import Feedback from "./components/Feedback";

export default function App() {
    const dispatch = useDispatch();
    const isQuestionConfigReady = useSelector(state => isConfigReady(state));
    const questionTypesConfig = useSelector(state => getQuestionTypesConfig(state));
    const isQuestionApiReady = useSelector(state => isApiReady(state))

    React.useState(() => {
        if (!questionTypesConfig) {
            dispatch(loadJson(configJson));
        }
    },[questionTypesConfig]);

    React.useEffect(() => {
        if ( isQuestionConfigReady && !isQuestionApiReady ) {
            dispatch(initQuestionApi(signedRequest));
        }
    }, [isQuestionConfigReady, isQuestionApiReady])

    return <div className="app-wrapper">
            <Header />
            <Toolbar />
            <Main />
            <SnackbarAlert />
            <Dialog />
            <Feedback />
        </div>;
}
