import * as React from 'react';
import Button from "@mui/material/Button";
import { colors } from "../mui-theme";
import { useDispatch } from "react-redux";
import { setDialog } from "../ducks/app";

export default () => {
    const dispatch = useDispatch();

    const clickHandler = () => {
        dispatch(setDialog({
            children: 'Thank you for your feedback!',
            title: 'FEEDBACK',
            closeLabel: 'OK',
            open: true
        }));
    }
    return <Button
        onClick={clickHandler}
        size="large"
        sx={{
            position: 'fixed',
            bottom: 0,
            left: 20,
            backgroundColor: colors.honey
        }}
    >Feedback</Button>

}
