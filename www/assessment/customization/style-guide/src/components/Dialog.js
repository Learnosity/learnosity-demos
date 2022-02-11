import * as React from 'react';
import Button from '@mui/material/Button';
import Dialog from '@mui/material/Dialog';
import DialogTitle from '@mui/material/DialogTitle';
import DialogContent from '@mui/material/DialogContent';
import DialogActions from '@mui/material/DialogActions';
import IconButton from '@mui/material/IconButton';
import CloseIcon from '@mui/icons-material/Close';
import { useDispatch, useSelector } from "react-redux";
import { getDialogProps, setDialog } from "../ducks/app";
import { Divider } from "@mui/material";

const EnhanceDialogTitle = (props) => {
    const { children, onClose, ...other } = props;

    return (
        <DialogTitle sx={{ m: 0, p: 2 }} {...other}>
            {children}
            {onClose ? (
                <IconButton
                    aria-label="close"
                    onClick={onClose}
                    sx={{
                        position: 'absolute',
                        right: 8,
                        top: 8,
                        color: (theme) => theme.palette.grey[500],
                    }}
                >
                    <CloseIcon />
                </IconButton>
            ) : null}
        </DialogTitle>
    );
};

export default () => {
    const dispatch = useDispatch();
    const [isOpen, setIsOpen] = React.useState(false);
    const { children, title, closeLabel, open } = useSelector( state => getDialogProps(state))

    React.useEffect(() => {
        setIsOpen(open);
    },[open]);

    const handleClose = () => {
        dispatch(setDialog({
            children: null,
            open: false
        }));
        setIsOpen(false);
    };

    return (
        <div>
            <Dialog
                onClose={handleClose}
                aria-labelledby="customized-dialog-title"
                open={isOpen}
                maxWidth="xs"
            >
                <EnhanceDialogTitle id="customized-dialog-title" onClose={handleClose}>
                    {title}
                </EnhanceDialogTitle>
                <DialogContent>
                    <Divider sx={{ mb: 2 }} />
                    {children}
                </DialogContent>
                <DialogActions>
                    <Button autoFocus onClick={handleClose}>
                        {closeLabel}
                    </Button>
                </DialogActions>
            </Dialog>
        </div>
    );
}
