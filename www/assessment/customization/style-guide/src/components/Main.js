import QuestionContainer from "./QuestionContainer";
import React from "react";
import ListItem from "@mui/material/ListItem";
import List from "@mui/material/List";
import ListItemText from "@mui/material/ListItemText";
import CopyIcon from '@mui/icons-material/ContentCopy';
import HighlightIcon from '@mui/icons-material/HighlightAltSharp';
import IconButton from "@mui/material/IconButton";
import Box from "@mui/material/Box";
import Tooltip from "@mui/material/Tooltip";
import Grid from "@mui/material/Grid";
import { colors, presets } from "../mui-theme";
import { useDispatch, useSelector } from "react-redux";
import { getActiveSelectors, getWidgetClassnames, setActiveSelectors, setSnackbar } from "../ducks/app";
import { isRendered } from "../ducks/questionApi";
import Skeleton from "@mui/material/Skeleton";
import { getRandomColourIndex } from "../utils";
import constants from "../contants";

const highlightSelector = ({ selector, colorSelector }) => {
    const targetElements = document.querySelectorAll(selector);

    if (!targetElements.length) return null;

    Array.prototype.slice.call(targetElements).forEach(function(element) {
        element.classList.add('highlight');
        element.classList.add('on');
        element.classList.add(colorSelector);
    });
}

const removeColorSelectors = element => {
    const list = element.classList.entries();
    for (let value of list) {
        if( Array.isArray(value) ) {
            value.forEach( i => {
                if (`${i}`.indexOf('color-')>-1) {
                    element.classList.remove(i);
                }
            });
        } else {
            if (value.indexOf('color-')>-1) {
                element.classList.remove(value);
            }
        }
    }
};

const removeSelectorsByElements = targetElements => {
    Array.prototype.slice.call(targetElements).forEach(function(element) {
        element.classList.remove('highlight');
        element.classList.remove('on');
        removeColorSelectors(element);
    });
}

const getColorFromColorSelectors = selector => {
    const defaultColor = colors.primaryHighlight;
    if (!selector) {
        return defaultColor;
    }
    const index = selector.match(/\d+$/)[0];
    return constants.highlightColors[index-1] || defaultColor;
}

const RegionHeader = ({ children, sx }) => <Box sx={{
    display: 'flex',
    borderBottom: presets.border1pxSolid,
    backgroundColor: colors.secondaryBg,
    fontSize: 16,
    fontWeight: "bold",
    height: 40,
    lineHeight: '40px',
    ...sx
}}>
    {children}
</Box>;


const ListPreloader = () => <Box sx={{ width: '90%', minWidth: 400, mt: 1, ml: 4, mr: 4 }}>
    <Skeleton height={60} width="100%" variant="text" />
    <Skeleton height={60} width="100%" variant="text" />
    <Skeleton height={60} width="100%" animation={false} variant="text" />
    <Skeleton height={60} width="100%" animation={false} variant="text" />
</Box>;

export default () => {

    const dispatch = useDispatch();
    const [listSelectors, setListSelectors] = React.useState([]);
    const widgetClassNames = useSelector(state => getWidgetClassnames(state));
    const activeSelectors = useSelector(state => getActiveSelectors(state));
    const isQuestionRendered = useSelector(state => isRendered(state));

    React.useEffect(() => {
        if (isQuestionRendered) {
            updateListSelectors();
        }
    }, [widgetClassNames, isQuestionRendered]);

    React.useEffect(() => {
        if (isQuestionRendered) {
            if (activeSelectors.length) {
                resetAllSelectors();
                updateListSelectors();
            }
            activeSelectors.map(selector => highlightSelector(selector));
        }
    }, [activeSelectors, isQuestionRendered]);

    const updateListSelectors = () => {
        // #TODO : filter from the current view the available selectors
        //  const newList = widgetClassNames.filter( ({ source })=> {
        //     return document.querySelector(source);
        // });

         const newList = [...widgetClassNames].map( (item)=> {
             const { source } = item;
             const selector =  activeSelectors.find(item => item.selector === source) || {};

            return {...item, colorSelector: getColorFromColorSelectors(selector.colorSelector) };
        });

         setListSelectors(newList);
    }

    const highlightHandler = (selector) => {
        const targetElements = document.querySelectorAll(selector);

        if (!targetElements.length) {
            const snackbarProps = {
                open: true,
                text: 'The selector is not available in the current view.',
                severity: 'warning',
            };
            dispatch(setSnackbar(snackbarProps));

            return null;
        }

        removeSelectorsByElements(targetElements);

        const colorSelector = `color-${getRandomColourIndex()}`;
        const payload = { selector, colorSelector }

        dispatch(setActiveSelectors(payload));
    }


    const resetAllSelectors = () => {
        widgetClassNames.forEach( ({ source })=> {
            const targetElements = document.querySelectorAll(source);
            removeSelectorsByElements(targetElements);
        });
    };

    const copySelector = (selector) => {
        const textArea = document.createElement("textarea");
        textArea.value = selector;
        document.body.appendChild(textArea);
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        textArea.focus();
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        // set snackbar
        const snackbarProps = { open: true, text: 'CSS selectors successfully copied!', severity: 'success' };

        dispatch(setSnackbar(snackbarProps));
    }

    return <>

        <Box className="main" sx={{
            mt: 3,
            ml: { xs: 2, sm: 16 },
            mr: { xs: 2, sm: 16 },
            mb: 3
        }}>
            <Box sx={{
                border: presets.border1pxSolid,
                display: 'flex'
            }}>
                <Grid container spacing={0}>
                    <Grid item sm={12} md={6} sx={{ width: { xs: '100%', sm: '100%' } }}>
                        <RegionHeader sx={{justifyContent: 'center'}}>
                            Preview
                        </RegionHeader>
                        <QuestionContainer/>
                    </Grid>
                    <Grid item sm={12} md={6} sx={{ width: { xs: '100%', sm: '100%' } }}>
                        <Box sx={{
                            borderLeft: { md: presets.border1pxSolid, xs: 'unset' },
                            borderTop: { md: 'unset' , xs: presets.border1pxSolid },
                            backgroundColor: colors.secondaryBg,
                            height: '100%',
                        }}>
                            <RegionHeader sx={{ width: '100%' }}>
                                <Box sx={{
                                    paddingLeft: 2,
                                    width: 232
                                }}> Selector </Box>
                                <Box> Usage </Box>
                            </RegionHeader>
                            <Box sx={{
                                whiteSpace: 'nowrap',
                                height: 'auto',
                                width: '100%',
                                overflowX: 'auto',
                                maxHeight: '100%', overflowY: 'scroll',
                            }}>
                                <List disablePadding sx={{ height: 425, minHeight: 400, minWidth: 520 }}>
                                    {
                                        isQuestionRendered ? listSelectors.map((item, index) => <ListItem disablePadding key={index}>
                                            <Tooltip title={item.source} arrow>
                                                <ListItemText
                                                    primary={item.source}
                                                    sx={{minWidth: 220, width: 220, flex: 'unset'}}
                                                    primaryTypographyProps={{
                                                        noWrap: true,
                                                        sx: {
                                                            minWidth: 200,
                                                            width: 200,
                                                            fontWeight: 'bold'
                                                        }
                                                    }}
                                                />
                                            </Tooltip>
                                            <Tooltip title={item.description} arrow>
                                                <ListItemText primary={item.description}
                                                              sx={{minWidth: 200}}
                                                              primaryTypographyProps={{
                                                                  noWrap: true,
                                                                  sx: {
                                                                      minWidth: 200
                                                                  }
                                                              }}
                                                />
                                            </Tooltip>
                                            <Tooltip title="copy" arrow>
                                                <IconButton onClick={() => {
                                                    copySelector(item.source);
                                                }}>
                                                    <CopyIcon/>
                                                </IconButton>
                                            </Tooltip>
                                            <Tooltip title="highlight" arrow>
                                                <IconButton
                                                    sx={
                                                        activeSelectors.some(i => i.selector === item.source) ?
                                                            {
                                                                backgroundColor: item.colorSelector,
                                                                border: `1px solid ${item.colorSelector}`
                                                            } : {
                                                                backgroundColor: 'transparent',
                                                                border: '1px solid transparent'
                                                            }
                                                    }
                                                    onClick={() => {
                                                        highlightHandler(item.source);
                                                    }}>
                                                    <HighlightIcon/>
                                                </IconButton>
                                            </Tooltip>

                                        </ListItem>)
                                        : <ListPreloader />
                                    }
                                </List>
                            </Box>
                        </Box>
                    </Grid>
                </Grid>
            </Box>
        </Box>

    </>
}
