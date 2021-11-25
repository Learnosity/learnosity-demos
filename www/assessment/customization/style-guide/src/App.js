import React from 'react';
import { useDispatch } from 'react-redux';
import './assets/scss/app.scss';
import QuestionContainer from './components/QuestionContainer';
import { loadJson } from './ducks/appConfig';
import configJson from 'config.json';

export default function App() {
    const dispatch = useDispatch();

    React.useState(() => {
       // TODO: in case we need to load anything in the App before we rendering the questionApi
        dispatch(loadJson(configJson));
    },[]);

    return (<div className="app-wrapper"><QuestionContainer /></div>);
}
