import FormControl from "@mui/material/FormControl";
import Select from "@mui/material/Select";
import MenuItem from "@mui/material/MenuItem";
import ToggleButtonGroup from "@mui/material/ToggleButtonGroup";
import ToggleButton from "@mui/material/ToggleButton";
import React from "react";
import Box from "@mui/material/Box";
import { useDispatch, useSelector } from "react-redux";
import {
    getCategories,
    getQuestionState,
    getQuestionType,
    setDialog,
    setQuestionState,
    setQuestionType
} from "../ducks/app";
import { API_STATES } from "../contants";
import IconButton from "@mui/material/IconButton";
import HelpOutlineOutlinedIcon from '@mui/icons-material/HelpOutlineOutlined';
import Tooltip from "@mui/material/Tooltip";
import Typography from "@mui/material/Typography";
import { colors } from "../mui-theme";
import Grid from "@mui/material/Grid";
import { getUrlParams } from "../utils";

const FormLabel = ({ children, icon }) => <Box sx={{
    fontSize: 16,
    lineHeight: '24px',
    display: 'flex',
    height: 40
}}>
    <Typography sx={{alignSelf: 'center'}}>{children}</Typography>
    {icon}
</Box>;

export default () => {
    const dispatch = useDispatch();

    const [questionType, setQuestionTypeCategory] = React.useState('');
    const [questionState, toggleQuestionState] = React.useState(API_STATES.INITIAL);

    const categories = useSelector(state => getCategories(state));
    const selectedQuestionType = useSelector(state => getQuestionType(state));
    const selectedQuestionState = useSelector(state => getQuestionState(state));

    React.useEffect(() => {
        let newQuestionType = selectedQuestionType;
        const paramQuestionState = getUrlParams('state');
        let newQuestionState = selectedQuestionState || questionState;

        if (categories.length && !questionType && !selectedQuestionType) {
            newQuestionType = categories[0].value;
            setQuestionTypeCategory(newQuestionType);
            dispatch(setQuestionType(newQuestionType));
        }
        if (questionState && paramQuestionState && questionState !== paramQuestionState) {
            newQuestionState = paramQuestionState;
            dispatch(setQuestionState(newQuestionState));
        }

        toggleQuestionState(newQuestionState);
        setQuestionTypeCategory(newQuestionType);
    }, [categories, selectedQuestionType, selectedQuestionState])

    const categoryChangeHandler = ({target: {value}}) => {
        setQuestionTypeCategory(value);
        dispatch(setQuestionType(value));
    };

    const stateChangeHandler = (_, value) => {
        toggleQuestionState(value);
        dispatch(setQuestionState(value));
        // redirect with the state
        window.location.assign(`?state=${value}`);
    };

    const showInfoHandler = () => {
        const content = <Typography>The API State controls the startup modes of the API,
            to allow for different behaviors during an assessment.
            <a href="https://help.learnosity.com/hc/en-us/articles/360000755438-Switching-Between-Testing-and-Reviewing-With-States" target="_blank">
             Learn more about the API states.</a>
        </Typography>

        dispatch(setDialog({
            children: content,
            title: 'API State',
            open: true
        }));
    }

    return <Box
        className="toolbar"
        sx={{
            mt: 3,
            ml: { xs: 2, sm: 16 },
            mr: { xs: 2, sm: 16 },
            mb: 3
        }}>
        <Grid container spacing={1}>
            <Grid item xs={12} sm={12}  md={4} >
                <FormControl sx={{ width: '100%'}}>
                    <FormLabel>Question type</FormLabel>
                    <Select size="small"
                            value={questionType}
                            onChange={categoryChangeHandler} >
                            {
                                categories.map(item =>
                                    <MenuItem key={item.value} value={item.value}>
                                        {item.label}
                                    </MenuItem>)
                            }
                    </Select>
                </FormControl>
            </Grid>

            <Grid item xs={12} sm={12} md={8}>
                <Box sx={{
                    ml: { md: 4, sm: 0 }
                }}>
                    <FormLabel icon={
                        <Tooltip title="info" arrow>
                            <IconButton onClick={showInfoHandler} size="small" sx={{ color: colors.gray , ml: 1}}>
                                <HelpOutlineOutlinedIcon/>
                            </IconButton>
                        </Tooltip>}>
                        API State
                    </FormLabel>
                    <ToggleButtonGroup
                        variant="outlined"
                        exclusive
                        value={questionState}
                        size="small"
                        onChange={stateChangeHandler}>
                        <ToggleButton value={API_STATES.INITIAL}>Initial</ToggleButton>
                        <ToggleButton value={API_STATES.RESUME}>Resume</ToggleButton>
                        <ToggleButton value={API_STATES.PREVIEW}>Preview</ToggleButton>
                        <ToggleButton value={API_STATES.REVIEW}>Review</ToggleButton>
                    </ToggleButtonGroup>
                </Box>
            </Grid>
        </Grid>
    </Box>
}
