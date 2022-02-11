import { createTheme } from '@mui/material/styles';
import { red } from '@mui/material/colors';

export const colors = {
    primaryBorder: `#939393`,
    secondaryBg: `#F7F7F7`,
    primaryBg: `#00313D`,
    primaryHighlight: '#bae2ff',
    secondaryHighlight: '#94e9f5',
    gray: '#333333',
    textColor: '#333',
    darkerGray: '#4e4e4e',
    honey: '#FFCB00'
};

export const presets = {
    border1pxSolid: `1px solid ${colors.primaryBorder}`,
    border1pxSolidHighlight: `1px solid ${colors.secondaryHighlight}`,
};

const theme = createTheme({
    breakpoints: {
        values: {
            xs: 0,
            sm: 700,
            md: 1200,
        },
    },
    shape: {
        borderRadius: 0,
    },
    typography: {
        fontFamily: [
            'Helvetica Neue',
            'Arial',
            'sans-serif'
        ].join(','),
        fontSize: 14,
        h1: {
            color: 'white',
            fontSize: 32,
            lineHeight: '24px',
            fontWeight: 700
        },
        h4: {
            color: 'white',
            fontSize: 18,
            lineHeight: '12px',
            fontWeight: 400
        },
        subtitle1: {
            fontSize: 16,
            lineHeight: '24px'
        }
    },
    palette: {
        primary: {
            main: '#000',
        },
        secondary: {
            main: '#19857b',
        },
        error: {
            main: red.A400,
        },
        text: {
            primary: colors.textColor,
            secondary: "#00000"
        }
    },
    components: {
        MuiIconButton: {
            styleOverrides: {
                root: {
                    color: 'black'
                }
            }
        },
        MuiListItem: {
            styleOverrides: {
                root: {
                    backgroundColor: "white",
                    marginBottom: 2,
                    padding: 8
                }
            }
        },
        MuiToggleButton: {
            styleOverrides: {
                root: {
                    minWidth: 80,
                    border: presets.border1pxSolid,
                    "&.Mui-selected": {
                        backgroundColor: "black",
                        color: "white",
                        fontWeight: 600,
                        '&:hover': {
                            backgroundColor: '#3c3c3c',
                            color: 'white'
                        }
                    },
                    color: colors.darkerGray,
                    '&:hover': {
                        backgroundColor: 'rgba(229,229,229,0.8)',
                        color: colors.textColor
                    }
                }
            }
        }
    },
});

export default theme;
