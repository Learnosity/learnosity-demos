import React from 'react';
import { useDispatch, useSelector } from 'react-redux';
import './assets/scss/app.scss';
import { getJson, getQuestionTypesConfig, isConfigReady } from './ducks/app';
import Header from "./components/Header";
import Toolbar from "./components/Toolbar";
import Main from "./components/Main";
import { initQuestionApi, isApiReady } from "./ducks/questionApi";
import { signedRequest } from "./contants";
import SnackbarAlert from "./components/SnackbarAlert";
import Dialog from "./components/Dialog";

export default function App() {
    const [isLoading, setLoading] = React.useState(true);
    const dispatch = useDispatch();
    const isQuestionConfigReady = useSelector(state => isConfigReady(state));
    const questionTypesConfig = useSelector(state => getQuestionTypesConfig(state));
    const isQuestionApiReady = useSelector(state => isApiReady(state))

    React.useEffect( () => {
        const el = document.querySelector(".page-preloader");
        if (el) {
            el.remove();
        }
        setLoading(false);
    }, []);

    React.useEffect(() => {
        if (!questionTypesConfig && !isLoading) {
            dispatch(getJson('public/config.json'));
        }
    },[questionTypesConfig, isLoading]);

    React.useEffect(() => {
        if ( isQuestionConfigReady && !isQuestionApiReady ) {
            dispatch(initQuestionApi(signedRequest));
        }
    }, [isQuestionConfigReady, isQuestionApiReady])

    if (isLoading) {
        return null;
    }

    return <div className="app-wrapper">
            <Header />
            <Toolbar />
            <Main />
            <SnackbarAlert />
            <Dialog />
        </div>;
}
