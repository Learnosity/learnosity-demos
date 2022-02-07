import React from 'react';
import {GCA_QUESTiON_WRAPPER, signedRequest} from "../contants/index";
import { useDispatch, useSelector } from 'react-redux';
import { initQuestionApi, renderQuestionType } from '../ducks/questionApi';
import { getWidgetByIndex } from '../ducks/appConfig';

export default () => {
    const dispatch = useDispatch();
    // #TODO:  need to get this from the dropdown
    const defaultWidget = useSelector(state => getWidgetByIndex(state, 0));

    React.useEffect(() => {
        // init the API
        dispatch(initQuestionApi(signedRequest)).then(
            ()=> {
                // render the first question type widget
                dispatch(renderQuestionType(defaultWidget));
            }
        );
    }, [])

    return (<><div className={GCA_QUESTiON_WRAPPER} /></>);
}
