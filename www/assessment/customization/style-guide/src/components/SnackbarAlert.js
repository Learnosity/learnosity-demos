import React from "react";
import Snackbar from "@mui/material/Snackbar";
import Alert from "@mui/material/Alert";
import { useDispatch, useSelector } from "react-redux";
import { getSnackbar, setSnackbar } from "../ducks/app";
import { delay } from '../utils';

export default () => {

    const dispatch = useDispatch();
    const [open, setIsOpen] = React.useState(false);
    const [text, setText] = React.useState('');
    const [severity, setSeverity] = React.useState('success');

    const snackbarProps = useSelector( state => getSnackbar(state));

    const closeSnackbarHandler = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }
        reset();
        dispatch(setSnackbar({ open: false }));
    };

    React.useEffect(() => {
        if (open) {
            delayOpenSnackbar(snackbarProps);
        } else {
            openSnackbar(snackbarProps);
        }
    }, [snackbarProps]);

    const delayOpenSnackbar =  async (props) => {
        reset();
        await delay();
        openSnackbar(props);
    }

    const openSnackbar = (props) => {
        setIsOpen(props.open);
        setText(props.text);
        setSeverity(props.severity || 'success');
    }

    const reset = () => {
        setIsOpen(false);
        setText('');
        setSeverity('success');
    }

    return <Snackbar
        open={open}
        autoHideDuration={3000}
        onClose={closeSnackbarHandler}
        anchorOrigin={{ vertical: 'bottom', horizontal: 'center' }}
    >
        <Alert onClose={closeSnackbarHandler} severity={severity} sx={{ width: '100%' }}>
            {text}
        </Alert>
    </Snackbar>;
}
