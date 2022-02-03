import React from 'react';
import Box from "@mui/material/Box";
import Skeleton from "@mui/material/Skeleton";
import { GCA_QUESTiON_WRAPPER } from "../contants/index";
import { useDispatch, useSelector } from 'react-redux';
import { isApiReady, isRendered, renderQuestionType } from '../ducks/questionApi';
import { getQuestionState, getWidgetQuestion } from '../ducks/app';


const SkletonPreloader = () => <Box sx={{ width: '100%', minWidth: 400 }}>
    <Skeleton height={40} width="80%" />
    <Skeleton  width="100%" />
    <Skeleton animation={false} height={200} width="100%" />
    <Box sx={{ width: '100%', display: 'flex', flexDirection: 'row' }}>
        <Skeleton height={40} width="70%" />
        <Box sx={{ width: 20 }} />
        <Skeleton height={40} width="30%" />
    </Box>
</Box>;

export default () => {
    const dispatch = useDispatch();
    const widgetQuestion = useSelector(state => getWidgetQuestion(state));
    const questionState = useSelector(state => getQuestionState(state));
    const isQuestionApiReady = useSelector(state => isApiReady(state));
    const isQuestionRendered = useSelector(state => isRendered(state));
    const [isQuestionUIReady, setIsQuestionUIReady] = React.useState(false);

    React.useEffect(() => {
        if (isQuestionApiReady && widgetQuestion && questionState) {
            setIsQuestionUIReady(false);
            dispatch(renderQuestionType({ question: widgetQuestion, state: questionState }));
        }
    }, [isQuestionApiReady, widgetQuestion, questionState])

    React.useEffect(() => {
        if (isQuestionRendered) {
            setIsQuestionUIReady(true);
        }

    }, [isQuestionRendered])

    return <Box sx={{ p: 2 }}>
        {
            !isQuestionUIReady && <SkletonPreloader />
        }
        <div className={GCA_QUESTiON_WRAPPER} style={{ display: isQuestionUIReady ?  'block' : 'none' }}/>
    </Box>;
}
